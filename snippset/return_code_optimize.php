<?php

	// Before optimize
	public function fun1($request, $arr_rules, $messages) 
	{
		
		$return = $this->commonValidate($request, $arr_rules, $messages);
            	
		if ($return) {
                	return $return;
            	}

            	$ret = $this->verifyLogInfo($request);

            	if ($ret) { return $ret; }
	}

	// After optimize
        public function fun2($request, $arr_rules, $messages)
        {

                $return = $this->commonValidate($request, $arr_rules, $messages$

                if ($return) {
                        $ret = $return;
               } else {
			$ret = $this->verifyLogInfo($request);
		}

                return $ret;
        }

	// After optimize
   	public function fun3($request, $arr_rules, $messages)  
        {

                $return = $this->commonValidate($request, $arr_rules, $messages$
         
                if (empty($return)) {
			$return = $this->verifyLogInfo($request);
               }
		
		return $return;
        }

?>
