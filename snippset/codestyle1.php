<?php

	
	#colleage's code style #
	private function handleCmd($info)
	{
        	$cmd=$info['command'];
        	switch($cmd){
            		case '01':  //登陆
                	$return_payload = $this->devLoginOrLogoff($info);
                	$return = self::FormatreturnPayload($info,$return_payload);
                	return $return;
               	 	break;
            		case '02':  //登出
                	$return_payload = $this->devLoginOrLogoff($info);
                	$return = self::FormatreturnPayload($info,$return_payload);
                	return $return;
                	break;
            		case '04':  //数据上报
                	$return_payload = $this->reportData($info);
                	$return = self::FormatreturnPayload($info,$return_payload);
                	return $return;
                	break;
            		case '05':  //更新启动设备指令  无需返回
                	$return_payload = $this->updateDeviceStart($info);
                	$return = self::FormatreturnPayload($info,$return_payload);
                	return $return;
                	break;
            		default:
                	break;
        	}
    	}
	
	/* james's code style base the last function code
	 * lesss code, readable and so on.	 
	 *
	 */
	private function handleCmd($info)
    	{
        	$cmd = $info['command'];
        	$return_payload = '';
        	
		switch($cmd)
        	{
            		case '01' : //登陆
            		case "02" :
                		$return_payload = $this->devLoginOrLogoff($info);
                	break;

            		case '04':  //数据上报
                		$return_payload = $this->reportData($info);
                	break;

            		case '05':  //更新启动设备指令  无需返回
                		$return_payload = $this->updateDeviceStart($info);
                	break;
        	}
        	$return = self::FormatreturnPayload($info,$return_payload);

        	return $return;
    	}

