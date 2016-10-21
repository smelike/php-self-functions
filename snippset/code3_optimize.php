<?php

	// 可以使用三元运算符，就使用。目的减少代码行数
	
	// After optimized
	$return['login_response'] = empty($upd) ? "01" : '00';
                

	// Before optimized
	if(!$upd){
               	$return['login_response'] = '01';       //失败
        }else{
        	$return['login_response'] = '00';       //成功
        }
