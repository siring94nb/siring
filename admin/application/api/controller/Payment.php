<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/25
 * Time: 15:52
 */
namespace app\api\controller;
use app\data\model\UserFund;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;

class Payment extends Base
{
    /**
     * 用户优惠卷接口
     */
    public function coupou()
    {
        $uid = Session::get("uid");
        if($uid){
            $data = (new \app\data\model\UserDiscount())->dis_list(1,$uid);//目前全部返回未使用优惠卷
            foreach ($data as $k =>$v){
                $data[$k]['name'] = $v['discount']['name'];
                $data[$k]['rule'] = $v['discount']['rule'];
                unset($data[$k]['discount']);
            }

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

        }else{
            returnJson(0,'请登录');
        }
    }


    /**
     * 用户余额
     */
    public function balance()
    {
        $uid = Session::get("uid");
        if($uid){
            $data = UserFund::user($uid);
            $res = $data['money'];

            return $res ? returnJson(1,'获取成功',$res) : returnJson(0,'获取失败',$res);

        }else{
            returnJson(0,'请登录');
        }
    }
}
