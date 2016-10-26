<?php

    // disnest if,just use && logic
    public function index($customerId = 0)
    {
        $customerId = (int) $customerId;
        $arr_return = [];

        if ($customerId) {
            $comments = DB::table('comment')->where('customerId', $customerId)->get();
        }

        if ($customerId && $comments) {
            $arr_return = ['msg' => $comments];
        }

        return $this->responseJson($arr_return);
    }


    // nest if logic, it seems so disgusting.

    public function index($customerId = 0)
    {
        $customerId = (int) $customerId;
        $arr_return = [];

        if ($customerId) {
            $comments = DB::table('comment')->where('customerId', $customerId)->get();
            if ($comments) {
                $arr_return = ['msg' => $comments];
            }
        }

        return $this->responseJson($arr_return);
    }
