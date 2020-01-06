<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/6
 * Time: 15:45
 */
namespace app\api\controller;
use app\data\model\Message;
use app\data\model\Order;
use think\Request;
use think\Session;
/**
 * 控制台-saas订单
 * Class Chat
 * @package app\api\controller
 */
class Saas extends Base
{
    /**
     * saas订单列表
     * @throws \think\exception\DbException
     */
    public function saas_list()
    {
        $uid = Session::get("uid");
        if($uid) {
            $request = Request::instance();
            $param = $request->param();
            $type = 8;
            $data = (new Order())->order_list($param,$uid,$type);

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }
        returnJson(3,'你当前未登录');
    }

    /**
     *取消订单
     */
    public function saas_cancel()
    {
        $uid = Session::get("uid");
        if($uid) {
            $request = Request::instance();
            $param = $request->param();

            $data = Order::where('id',$param['order_id'])->update(['payment'=>8]);

            return $data ? returnJson(1,'取消成功',$data) : returnJson(0,'取消失败',$data);
        }
        returnJson(3,'你当前未登录');
    }
}
