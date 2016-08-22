<?php

var_dump(03 != 3);	//bool(false)
var_dump('03' != 3);	// bool(false)
var_dump('3' != 3);	// bool(false)
var_dump(3 != 3); 	// bool(false)
var_dump(4 != 3);	// bool(true)

// conclusion: != 只是比较左右两边参数的值大小 
