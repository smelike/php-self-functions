<?php


    // 根据 mac 与 ip 地址来匹配出 socket 链接, 因为 mac 会存在相同的情况
    function pregSocketByMacnIp($laravel_data)
    {
        global $active_socket;
        global  $device_mac;
        $commandPattern = new CommandPattern($laravel_data['command'], 'null', $laravel_data['payload']);
        $device_mac = $commandPattern->getDeviceMac();
        // 发现还是存在请求端口改变的情况,目前处理是舍去端口来做 socket 匹配.
        // 解决方案:要不干脆自动给每个请求指定一个以毫秒时间戳的数值作为端口好了呢?
        $socket = false;
        foreach ($active_socket as $key => $socket) {
            if (strpos($key, $device_mac . '_' . $laravel_data['ipport']) !== false) {
                $socket = $active_socket[$device_mac . '_' . $laravel_data['ipport']];
            }
        }
        return $socket;
    }
    // 根据 mac 与 ip 地址来匹配出 socket 链接, 因为 mac 会存在相同的情况
    function pregSocketByMacnIp($laravel_data)
    {
        global $active_socket;
        global  $device_mac;
        var_dump($active_socket);
        $commandPattern = new CommandPattern($laravel_data['command'], 'null', $laravel_data['payload']);
        $device_mac = $commandPattern->getDeviceMac();
        // 发现还是存在请求端口改变的情况,目前处理是舍去端口来做 socket 匹配.
        // 解决方案:要不干脆自动给每个请求指定一个以毫秒时间戳的数值作为端口好了呢?
        if (isset($active_socket[$device_mac . '_' . $laravel_data['ipport']]))
        {
            return $active_socket[$device_mac . '_' . $laravel_data['ipport']];
        }
        return false;

    }
