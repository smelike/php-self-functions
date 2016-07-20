<?php

	function sendMessageByCurl() 
	{

		$post = array('report' => json_encode($data));
        	$request_url = "http://example.com";
        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $request_url);
        	curl_setopt($ch, CURLOPT_HEADER, 0);
        	curl_setopt($ch, CURLOPT_POST, true);
		// 只能传输字符串
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        	$ret = curl_exec($ch);
        	// 最好做一个日志记录，用作成功与失败比例的统计
        	$arr_log = array('datetime' => date('Y-m-d H:i:s'), 'data' => bin2hex($data) , 'return' => var_export($ret, true));
        	file_put_contents('./udp_laravel_log' , join("\t", $arr_log) . "\r\n", FILE_APPEND);
        	curl_close($ch);
        	return $ret;
	}


