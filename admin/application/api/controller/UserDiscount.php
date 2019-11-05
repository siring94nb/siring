<?php

namespace app\api\controller;

use app\data\model\UserDiscount as UserDiscountAll;
use app\data\model\UserFund;
use think\Controller;
use think\Request;
use think\Session;
class UserDiscount extends Base
{
    /**
     * 用户优惠券列表
     * @author fyk
     * @return \think\Response
     */
    public function discount_list($status = 1)
    {
        $request = Request::instance();
        $param = $request->param();

        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $discount = new UserDiscountAll();
        $data = $discount->dis_list($status,$user_id);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 用户余额
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function user_fund()
    {
        $request = Request::instance();
        $param = $request->param();

        $uid = Session::get("uid");
        if($uid){
            $uid = Session::get("uid");
        }else{
            $uid = $param["user_id"];
        }

        $data = (new UserFund()) ->where('user_id',$uid) ->field('id,user_id,money')->find();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }


}
