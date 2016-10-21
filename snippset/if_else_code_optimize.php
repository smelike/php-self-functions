
<?php

// datetime: September/05/2016 Monday 12:35 AM
// IF - ELSE structure's optimize
// PROCESS: 以 else 的情况作为错误开头, 直接在 if 情况去修改 $arr_error
// RESULT: 结果代码看起来更简洁

// Before optimize
private function resetpwdVerify($request, $arr_user)
{

    if ($request->input('old') != $arr_user->password) {
        $arr_error = ['error' => 1, 'msg' => '旧密码错误'];
    } else {
        if ($request->has('new'))
        {
            $where = [['token', '=', $request->input('token')], ['password', '=', $request->input('old')]];
            $ret = DB::table('user')->where($where)->update(['password' => $request->input('new')]);
            $arr_error = ['error' => empty($ret) ? 1 : 0, 'msg' => empty($ret) ? '新密码设置失败' : '新密码设置成功'];
        } else {
            $arr_error = ['error' => 1, 'msg' => '新密码不能为空'];
        }
    }
    return $arr_error;
}

// After optimmize
private function resetpwdVerify($request, $arr_user)
{
    $arr_error = ['error' => 1, 'msg' => '旧密码错误'];
    if ($request->input('old') == $arr_user->password) {

        $arr_error = ['error' => 1, 'msg' => '新密码不能为空'];
        if ($request->has('new'))
        {
            $where = [['token', '=', $request->input('token')], ['password', '=', $request->input('old')]];
            $ret = DB::table('user')->where($where)->update(['password' => $request->input('new')]);
            $arr_error = ['error' => empty($ret) ? 1 : 0, 'msg' => empty($ret) ? '新密码设置失败' : '新密码设置成功'];
        }
    }
    return $arr_error;
}


