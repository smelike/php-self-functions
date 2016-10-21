<?php
	/*
		explode - Split a string by string
		Description
		array explode (string $delimiter, string $string[, int $limit = PHP_INT_MAX])
		
		Parameters
		delimiter
			The boundary string
		string
			The input string
		limit
			If limit is set and positive, the returned array will contain a maximum of limit elements with the last element containing the rest of string.
			If the limit parameters is negative, all components except the last -limit are returned.
			if the limit parameter is zero, then this is treated as 1.
	*/
	
	$scheme = "udp://0.0.0.1:8080";
	
	list($scheme, $address) = explode(":", $scheme, 2);
	
	list($scheme, $address, $port) = explode(":", $scheme, 3);
	
