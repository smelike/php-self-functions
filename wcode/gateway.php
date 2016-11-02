    <?php

    use Workerman\Worker;
    include_once 'header.php';

    /**
     * 启动UDP server
     */
    $udp_worker = new Worker($udpSocketName);
    $udp_worker->count = 1;
    $udp_worker->name = "baking_device_worker";

    /**
     * 在workerman启动的时候, 启动给Laravel的TCP服务
     */
    $udp_worker->onWorkerStart = function () {

        global $tcpSocketName;

        $tcp_worker = new Worker($tcpSocketName);
        $tcp_worker->name = 'baking_laravel_worker';

        $tcp_worker->onMessage = function ($connection, $data) {

            global $active_socket;
            global $device_mac;

            $laravel_data = json_decode($data, true);
            $send_socket = pregSocketByMacnIp($laravel_data);
            if ($send_socket)
            {
                deviceHub($connection, $send_socket, $laravel_data);
                $arr_receive_from_laravel = array(
                    'title' => 'Laravel->UDP',
                    'ipport' => 'dest:' . $send_socket->getRemoteIp() . ':' . $send_socket->getRemotePort(),
                    'data' => is_array($laravel_data) ? join("---", $laravel_data) : "not array:--" . $laravel_data
                );
                slog('laravel_c05_request_log', $arr_receive_from_laravel);
            } else {
                $online_log = "ONLINE MACHINE:" . join("-", array_keys($active_socket)) . "\t\t";
                $offline_log = "\r\n MACHINE : {$device_mac}:{$laravel_data['ipport']} NOT ONLINE";
                slog("machine_status_message_log", $online_log . $offline_log);
                $connection->send(0);
            }
        };
        $tcp_worker->listen();
    };

    /*  @以 ipport 匹配 socket
     *  @param $laravel_data
     *  @return mixed
     * */
    function pregSocketByMacnIp($laravel_data)
    {
        global $active_socket;
        global  $device_mac;

        $commandPattern = new CommandPattern($laravel_data['command'], 'null', $laravel_data['payload']);
        $device_mac = $commandPattern->getDeviceMac();

        $socket = false;
        if (isset($active_socket[$device_mac . '_' . $laravel_data['ipport']]))
        {
            $socket = $active_socket[$device_mac . '_' . $laravel_data['ipport']];
        }

        return $socket;
    }

    /*  @设备控制
     *  @param $source_socket
     *  @param $destination_socket
     *  @param $arr_data
     *  @return void
     * */
    function deviceHub($source_socket, $destination_socket, $arr_data)
    {
        global  $device_mac;

        $arr_formatData = foramtControlCommand($arr_data);
        $send_data = join("", $arr_formatData);
        $dret = $destination_socket->send(hex2bin($send_data));
        $source_socket->send($dret);

        if ($dret)
        {
            $arr_device_log = array(
                "sendto" => $destination_socket->getRemoteIp() . ':' . $destination_socket->getRemotePort(),
                'mac' => $device_mac,
                'data' => $send_data,
                "ret" => var_export($dret, true)
            );
            slog("workerman_send05_log", $arr_device_log);
        }
    }

    /**
     * 处理UDP消息的主要函数
     * @param $connection
     * @param $data
     * @return bool
     */
    $udp_worker->onMessage = function ($connection, $data) {

        $ip = $connection->getRemoteIp();
        $port = $connection->getRemotePort();

        var_dump(bin2hex($data));
        $arr_receive = array(
            'title' => 'Device->UDP',
            'ipport' => $ip . ":" . $port,
            'data' => bin2hex($data)
        );

        slog('udp_onmessage_log', $arr_receive);
        sendMessageByCurl($connection, $data);
    };

    /**
     * 格式化控制命令
     * @param $arr_laravel_data
     * @return array
     */
    function foramtControlCommand($arr_laravel_data)
    {
        global $aes;

        $arr_data = formatHead();
        $arr_data['ver_type_tkl'] = '40';
        $arr_data['code'] = '02';
        $arr_data['message_id'] = $arr_laravel_data['message_id'];
        $arr_data['service_code'] = $arr_laravel_data['service_code'];
        $arr_data['command'] = $arr_laravel_data['command'];
        $arr_data['payload'] = bin2hex($aes->encrypt($arr_laravel_data['payload']));
        dataLength($arr_data['payload'], $arr_data);

        return $arr_data;
    }
    /**
     * 生成给device的消息头
     * @return array
     */
    function formatHead()
    {
        return array(
            'ver_type_tkl' => '60',
            'code' => '45',
            'message_id' => '0000',
            'delimiter' => 'FF',
            'service_code' => '02',
            'groupid'   => '02000001',
            'data_len' => '0000',
            'command' => '00',
            'payload' => ''
        );
    }

    /**
     * @param $connection
     * @param $arr_device
     * @return mixed
     */
    function sendDeviceCommand($connection, $arr_device)
    {

        global $aes;

        $arr_data['ver_type_tkl'] = '40';
        $arr_data['code'] = '02';
        $arr_data['message_id'] = $arr_device['message_id'];
        $arr_data['delimiter'] = 'FF';
        $arr_data['service_code'] = $arr_device['service_code'];
        $arr_data['command'] = $arr_device['command'];
        $arr_data['payload'] = $arr_device['payload'];
        $arr_data['payload'] = $aes->encrypt($arr_device['payload']);
        dataLength($arr_data['payload'], $arr_data);

        return $connection->send(hex2bin(join("", $arr_data)));
    }

    /*  @十六进制数字长度补充
     *  @param $payload
     *  @param $arr_data
     *  @return void
     * */
    function dataLength($payload, &$arr_data)
    {
        $data_len_hex = base_convert(ceil(strlen($payload) / 2), 10, 16);

        $len = strlen($data_len_hex);
        if ($len < 4)
        {
            $data_len_hex = str_repeat('0', 4 - $len) . $data_len_hex;
        }
        $arr_data['data_len'] = $data_len_hex;
    }

    /*  @与Laravel通讯,并返回响应给设备
     *  @param $connection
     *  @param $data
     *  @return void
     * */
    function sendMessageByCurl($connection, $data)
    {

        global $active_socket;
        global $aes;

        $arr_command_data = CommandPattern::FormatCommandPattern($data, $aes);

        $arr_data = $arr_command_data['data'];
        $command = $arr_command_data['data']['command'];
        $device_mac = $arr_command_data['device_mac'];

        $ipport = $connection->getRemoteIp() . ":" . $connection->getRemotePort();
        $key = $device_mac . '_' . $ipport;
        $active_socket[$key] = $connection;

        $arr_laravel_ret = telegramWithLaravel($command, $arr_command_data, $ipport);
        responseDevice($connection, $aes, $arr_data, $arr_laravel_ret);
        slog('save_socket_log', array('title' => 'socket', 'ipport' => $key));
    }

    /*  @返回设备响应
     *  @param $connection
     *  @param $aes
     *  @param $arr_data
     *  @param $arr_laravel_ret
     *  @return boolean
     * */
    function responseDevice($connection, $aes, $arr_data , $arr_laravel_ret)
    {

        if ($arr_data['command'] == "03") {
            $arr_data['payload'] = $arr_data['timestamp'] . $arr_data['device_mac'];
            unset($arr_data['timestamp'], $arr_data['device_mac']);
            $encrypt_data = $aes->encrypt($arr_data['payload']);
            $arr_data['payload'] = bin2hex($encrypt_data);
            dataLength($arr_data['payload'], $arr_data);
            $send_binary_string = join('', $arr_data);
        } else if ($arr_data['command'] != '05') {
            if (isset($arr_laravel_ret['payload']) AND $arr_laravel_ret['payload']) {
                $arr_data = array_merge($arr_data, $arr_laravel_ret);
                $arr_format_data = formatPayloadFromLaravel($arr_data);
                $encrypt_data = $aes->encrypt($arr_format_data['payload']);
                $arr_format_data['payload'] = bin2hex($encrypt_data);
                dataLength($arr_format_data['payload'], $arr_format_data);
                $send_binary_string = join('', $arr_format_data);
            }
        }

        if (isset($send_binary_string)) {
            $fileName = 'Response_command_' . $arr_data['command'];
            $arr_log = isset($arr_format_data) ? $arr_format_data : $arr_data;
            slog($fileName, $arr_log);
            return $connection->send(hex2bin($send_binary_string));
        }
    }

    /*  @与 Laravel 通讯的报文结构
     *  @param $command
     *  @param $arr_format_data
     *  @param $ipport
     *  @return mixed
     * */
    function telegramWithLaravel($command, $arr_format_data, $ipport)
    {
        global $laravel_url;

        if ($command == '03') {
            $arr_data = array(
                'message_id' => $arr_format_data['data']['message_id'],
                'service_code' => $arr_format_data['data']['service_code'],
                'command' => $arr_format_data['data']['command'],
                'payload' => $arr_format_data['data']['timestamp'] . $arr_format_data['data']['device_mac'] . $arr_format_data['device_status']
            );
        } else {
            $arr_data = $arr_format_data['data'];
        }
        $arr_data['ipport'] = $ipport;
        $post = array('report' => json_encode($arr_data));

        slog('workerman_laravel_scurl_log', $post);
        return json_decode(scurl($laravel_url, $post), true);
    }

    /**
     * 格式化从laravel返回的数据
     * @param $arr_laravel_data
     * @return array|bool
     */
    function formatPayloadFromLaravel($arr_laravel_data)
    {

        $arr_data = formatHead();

        $arr_data['ver_type_tkl'] = '60';
        $arr_data['code'] = '45';
        $arr_data['message_id'] = $arr_laravel_data['message_id'];
        $arr_data['service_code'] = $arr_laravel_data['service_code'];
        $arr_data['groupid'] = $arr_laravel_data['groupid'];
        dataLength($arr_laravel_data['payload'], $arr_data);
        $arr_data['command'] = $arr_laravel_data['command'];
        $arr_data['payload'] = $arr_laravel_data['payload'];

        return $arr_data;
    }

    Worker::runAll();