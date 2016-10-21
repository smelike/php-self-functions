<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/29/16
 * Time: 3:05 PM
 */

// Before optimize
public function delgroup(Request $request)
{
    $data = $request->all(); 
    $groupId = isset($data['groupid']) ? $data['groupid'] : '';

    if($groupId === ''){
        $return = ['status'=>1,'msg'=>'','err_msg'=>'请先选择一个分组'];
        return response()->json($return);
    }

    $lamp = DB::table('group')->where('id',$groupId)->first();
    if(!$lamp){
        $return = ['status'=>'1','msg'=>'','err_msg'=>'分组不存在，请重新操作'];
    }else{
        $ret = DB::table('group')->where('id',$groupId)->delete();
        if(!$ret){
            $return = ['status'=>1,'msg'=>'','err_msg'=>'删除失败'];
        }else{
            $return = ['status'=>0,'msg'=>'删除成功','err_msg'=>''];
        }
    }
    return response()->json($return);
}

// After optimize

public function delgroup(Request $request)
{
    $data = $request->all();
    $groupId = isset($data['groupid']) ? $data['groupid'] : '';
    $return = ['status'=> 1, 'errmsg'=>'请先选择一个分组'];
    if($groupId) {
        $return = ['status'=>'1', 'errmsg'=>'分组不存在，请重新操作'];
        $lamp = DB::table('group')->where('id',$groupId)->first();
        if($lamp) {
            $ret = DB::table('group')->where('id',$groupId)->delete();
            $return = ['status'=>0];
            if(!$ret){
                $return = ['status'=>1 ,'errmsg'=>'删除失败'];
            }
        }
    }
    return $this->responseJson($return);
}
