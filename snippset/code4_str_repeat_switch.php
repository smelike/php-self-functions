<?php
	
	// Beforem optimized
	public function appendPad()
	{	
        	$len = strlen($state);
-        	switch($len){
-            		case 0:
-               	 	$state = '00000000';
-                		break;
-            		case 1:
-                		$state = '0000000'.$state;
-                	break;
-            		case 2:
-                		$state = '000000'.$state;
-                	break;
-            		case 3:
-                		$state = '00000'.$state;
-                	break;
-            		case 4:
-                		$state = '0000'.$state;
-                	break;
-            		case 5:
-                		$state = '000'.$state;
-                	break;
-            		case 6:
-                		$state = '00'.$state;
-                	break;
-            		case 7:
-                		$state = '0'.$state;
-                	break;
-            		default:
-                	break;
	 }
         return $state;
     }

	// After optimized
	public function appendPad($state)
	{
		$len = strlen($state);
		$fix = 8;

        	if ($len < 8) {
           		 $state = str_repeat('0', $fix - $len) . $state;
         	}
		return $state;
	}
