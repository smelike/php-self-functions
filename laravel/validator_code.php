<?php

    public function create(Request $request)
    {

        $messages = [
            'tel.required' => '电话号码不能为空',
            'tel.regex'    => '电话号码格式不正确',
            'password.required' => '密码不能为空',
            'password.between' => '密码长度必须为6~20个字符',
            'name.required' => '员工姓名不能为空',
            'name.between' => '姓名长度必须为6~20个字符',
            'position.required' => '权限设置不能为空',
            'position.in' => '权限设置格式不正确'
        ];

        $arr_rules = [
            'tel' => array('required','regex:/^1[3-5]\d{9}$/i'),
            'password' => 'required|between:6,20',
            'name' => 'required|between:2,20',
            'position' => 'required|in:0,5,10'
        ];

        $validator = Validator::make($request->all(), $arr_rules, $messages, array_values($arr_rules));
        $arr_errors = $this->messageBag($validator->errors(), $arr_rules);

        if ($arr_errors) {
            return response()->json(['status' => 1, 'msg'   => $arr_errors]);
        }

        $ret  = $this->insertRecord($request);
        $arr_return = ['status' => $ret ? 0 : 1, 'msg' => $ret ? '成功添加销售员' : '添加销售员失败'];

        return response()->json($arr_return);
    }
