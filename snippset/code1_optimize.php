<?php

	// Before optimise
	// device's status 

	$arr_return = $this->deviceStatus($arr_device['deviceid']); 

	if (isset($arr_return['error'])) {    
 		$arr_device['ipport'] = $arr_return['work']->ipport;
	 } else {     
		echo 'losse';     
		return $arr_return; 
	}


	private function deviceStatus($dev_id) {     
		
		$working = DB::table('device_status')->where('device_id', $dev_id)->first();      
		
		if($working AND ($working->status === 2)) {
         		return response()->json(['err_code'=>'1111','err_msg'=>'当前设备正在被使用，请稍后！']);
		}      
		
		return array('error' => ‘’,'work' => $working); 
	}


	// After optimise
	// device's status 
	$arr_return = $this->deviceStatus($arr_device['deviceid']); 
	if ($arr_return['error']) {
		return $arr_return['error_json'];
	} 
	
	$arr_device['ipport'] = $arr_return['work']->ipport;

	private function deviceStatus($dev_id) {
		 $working = DB::table('device_status')->where('device_id', $dev_id)->first();      
		 if($working AND ($working->status === 2)) {
	        	$error_json = response()->json(['err_code'=>'1111','err_msg'=>'当前设备正在被使用，请稍后！']);     
		 }      
		
		 return array(
			'error' => isset($error_json) ? '' : '10000',
			'error_json'  => isset($error_json) ? '' : $error_json,
			'work' => empty($working) ? '' : $working
		);
	}

