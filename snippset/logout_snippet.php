<?php
    
    // 初始状态
    public function logout(Request $request)
    {
        if ($request->has('token'))
        {
            $token = $request->input('token');
            $arr_user = DB::table('user')->where('token', $token)->first();

            $error = empty($arr_user) ? 1 : 0;
            $msg = empty($arr_user) ? ' Token 不匹配' : '';

            if ($arr_user) {
                $logout_token = ['token' => uniqid('logout_')];
                $return = DB::table("user")->where('token', $token)->update($logout_token);
                $error = empty($return) ? 1 : 0;
                $msg = empty($return) ? '退出失败,稍后再试' : '成功退出';
            }
            $arr_error = ['error' => $error, 'msg'   => $msg];
        } else {
            $arr_error = ['error' => 1, 'msg' => 'Token 不能为空'];
        }

        return $this->responseJson($arr_error);
    }

    // 优化之后的代码，将 token 的验证提取出来作为公共的函数，方便以后的服用

   private function verifyToken($request, &$arr_user, &$arr_error)
    {
        if ($request->has('token'))
        {
            $arr_user = DB::table('user')->where('token', $request->input('token'))->first();
            $arr_error = [
                'error' => empty($arr_user) ? 1 : 0,
                'msg' => empty($arr_user) ? ' Token 不匹配' : ''
            ];
        } else {
            $arr_error = ['error' => 1, 'msg' => 'Token 不能为空'];
        }
    }
    public function logout(Request $request)
    {
        $arr_user = $arr_error = '';

        $this->verifyToken($request, $arr_user, $arr_error);
        if ($arr_user)
        {
            $logout_token = ['token' => uniqid('logout_')];
            $return = DB::table("user")->where('token', $request->input("token"))->update($logout_token);
            $error = empty($return) ? 1 : 0;
            $msg = empty($return) ? '退出失败,稍后再试' : '成功退出';
        }
        $arr_error = ['error' => $error, 'msg'   => $msg];

        return $this->responseJson($arr_error);
    }
