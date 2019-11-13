<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/12
 * Time: 14:41
 */
namespace app\api\controller;
use app\data\model\SoftOrder;
use app\data\model\MealOrder;
use app\data\model\UserFund;
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
            $user_id = $param["user_id"];
        }

        $user = new \app\data\model\User();
        $data = $user->user_detail($user_id);
        //pp($data);die;
        $user_fund =  UserFund::user($user_id);
        $data['money'] = $user_fund['money'];
        unset($data['password'],$data['salt'],$data['remark'],$data['status'],$data['open_id'],$data['other_code'],$data['created_at'],$data['end_time'],$data['delect_at']);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 我的订单
     */
    public function my_order()
    {
        $request = Request::instance();
        $param = $request->param();

        $user_id = Session::get("user");
        if($user_id){
            $user_id = Session::get("user");
        }else{
            $user_id = $param["user_id"];
        }


        $data['total_customized'] =  SoftOrder::where('user_id',$user_id)->count();//软件定制总数
        $data['total_xcx'] =  MealOrder::where('member_account',$user_id)->count();//小程序订单总数
        $data['total_promotion'] =  SoftOrder::where('user_id',$user_id)->count();//AI订单总数
        $data['total_investment'] =  SoftOrder::where('user_id',$user_id)->count();//投融订单总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }


}
