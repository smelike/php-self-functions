<?php


// HTTP/1.0 200 OK Cache-Control: no-cache Content-Type: application/json {"status":1,"msg":{},"errmsg":"\u5206\u7ec4 ID \u4e0d\u80fd\u4e3a\u7a7a"}
if (!request->hs('groupid'))
{
	$ret = $this->responseJson(array('errmsg' => '分组 ID 不能为空'));
	exit($ret);
}


// {"status":1,"msg":{},"errmsg":"\u5206\u7ec4 ID \u4e0d\u80fd\u4e3a\u7a7a"}
if (!$request->has('groupid'))
{
       return $this->responseJson(array('errmsg' => '分组 ID 不能为空'));
}
