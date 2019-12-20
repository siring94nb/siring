<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/12
 * Time: 14:41
 */
namespace app\api\controller;
use app\data\model\InvestmentProject;
use app\data\model\SoftOrder;
use app\data\model\MealOrder;
use app\data\model\PromotionOrder;
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
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }

        $user = new \app\data\model\User();
        $data = $user->user_detail($user_id);
        //pp($data);die;
        $user_fund =  UserFund::user($user_id);
        $data['money'] = $user_fund['money'];
        unset($data['password'],$data['salt'],$data['remark'],$data['status'],$data['open_id'],$data['created_at'],$data['end_time'],$data['delect_at']);
        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 我的订单
     */
    public function my_order()
    {
        $request = Request::instance();
        $param = $request->param();

        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }


        $data['total_customized'] =  SoftOrder::where('user_id',$user_id)->count();//软件定制总数
        $data['total_xcx'] =  MealOrder::where('member_account',$user_id)->count();//小程序订单总数
        $data['total_promotion'] =  PromotionOrder::where('user_id',$user_id)->count();//AI订单总数
        $data['total_investment'] =  SoftOrder::where('user_id',$user_id)->count();//投融订单总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     *待付款订单
     */
    public function pending_payment()
    {
        $request = Request::instance();
        $param = $request->param();

        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }


        $data['total_customized'] =  SoftOrder::where(['user_id'=>$user_id,'payment'=>1])->count();//软件定制总数
        $data['total_xcx'] =  MealOrder::where(['member_account'=>$user_id,'order_status'=>1])->count();//小程序订单总数
        $data['total_promotion'] =  PromotionOrder::where(['user_id'=>$user_id,'payment'=>1])->count();//AI订单总数
        $data['total_investment'] =  InvestmentProject::where(['uid'=>$user_id,'pay_status'=>1])->count();//投融订单总数
        $data['total'] = $data['total_customized'] + $data['total_xcx'] + $data['total_promotion'] + $data['total_investment'];//总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     *待处理订单
     */
    public function pending_disposal()
    {
        $request = Request::instance();
        $param = $request->param();

        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }


        $data['total_customized'] =  SoftOrder::where(['user_id'=>$user_id,'payment'=>2])->count();//软件定制总数
        $data['total_xcx'] =  MealOrder::where(['member_account'=>$user_id,'order_status'=>2])->count();//小程序订单总数
        $data['total_promotion'] =  PromotionOrder::where(['user_id'=>$user_id,'payment'=>2])->count();//AI订单总数
        $data['total_investment'] =  InvestmentProject::where(['uid'=>$user_id,'pay_status'=>2])->count();//投融订单总数
        $data['total'] = $data['total_customized'] + $data['total_xcx'] + $data['total_promotion'] + $data['total_investment'];//总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     *待处理后续服务订单
     */
    public function after_service()
    {
        $request = Request::instance();
        $param = $request->param();

        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }


        $data['total_customized'] =  SoftOrder::where(['user_id'=>$user_id,'payment'=>2])->where('status','<>',1)->count();//软件定制总数
        $data['total_xcx'] =  MealOrder::where(['member_account'=>$user_id,'order_status'=>2])->where('status','<>',1)->count();//小程序订单总数
        $data['total_promotion'] =  PromotionOrder::where(['user_id'=>$user_id,'payment'=>2])->where('status','<>',2)->count();//AI订单总数
        $data['total_investment'] =  InvestmentProject::where(['uid'=>$user_id,'pay_status'=>2])->where('status','<>',2)->count();//投融订单总数
        $data['total'] = $data['total_customized'] + $data['total_xcx'] + $data['total_promotion'] + $data['total_investment'];//总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }


}
