<?php

	// Before optimize
        private function verifyToken($request, &$arr_user, &$arr_error)
        {
            if ($request->has('token'))
            {
                $arr_user = DB::table('user')->where('token', $request->input('token'))->first();
                if (empty($arr_user)) {
                    $arr_error = ['error' => 1, 'msg' => '不存在的 Token'];
                }
            } else {
                $arr_error = ['error' => 1, 'msg' => 'Token 不能为空'];
            }
        }

	// After optimize
	private function verifyToken($request)
        {
            $arr_error = ['status' => 1, 'msg' => 'Token 不能为空'];

            if ($request->has('token'))
            {
                $arr_user = DB::table('user')->where('token', $request->input('token'))->first();
                empty($arr_user)  ?  $arr_error['msg'] = '不存在的 Token' : "";
            }

            return empty($arr_user) ? $arr_error : $arr_user;
        }

