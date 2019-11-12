<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/12
 * Time: 14:41
 */
namespace app\api\controller;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;

class Console extends Base
{

    /**
     *个人信息
     */
    public function personal_information()
    {
        $request = Request::instance();
        $param = $request->param();
        $user_id = Session::get("user");
        if($user_id){
            $user_id = Session::get("user");
        }else{
            $user_id = $param(["user_id"]);
        }

        $user = new \app\data\model\User();
        $data = $user->user_detail($user_id);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }


}
