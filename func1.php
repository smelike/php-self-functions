<?php
/*
	format hexadecimal character to binary character
	if the length is smaller than 4, then append 0 in the beginning.
	
	@datetime: July/20/2016 10:54 AM
	@author: Jamesxu	
	@email: smelikecat@163.com
*/
	function hex2Binary($indata)
    	{
        	$length = strlen($indata);
        	$rev = strrev($indata);
        	$return = '';
        	while($length--)
        	{
            		$tmp = decbin(hexdec($rev[$length]));
            		$less = 4 - strlen($tmp);
            		$append = '';
            		while ($less --) {
              			$append .= 0;
            		}
        	}
        	return $append . $tmp;
    	}
