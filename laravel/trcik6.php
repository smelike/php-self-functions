<?php

	$q->whereDate('created_at', date('Y-m-d'));

	$q->whereDay('created_at', date('d'));

	$q->whereMonth('created_at', date('m'));
	
	$q->whereYear('created_at', date('Y'));
	
