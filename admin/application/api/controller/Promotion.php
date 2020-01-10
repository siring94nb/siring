<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/2
 * Time: 11:10
 */
namespace app\api\controller;

use app\data\model\PromotionOrder;
use app\data\model\Provinces;
use think\Controller;
use think\Request;
use think\Session;

/**
 * 控制台-AI推广运营
 * Class Promotion
 * @package app\api\controller
 */
class Promotion extends Base
{

    /**
     * AI推广列表
     * @throws \think\exception\DbException
     */
    public function manuscript_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $good = new PromotionOrder();

        $uid = Session::get("uid");

        if($uid){

            $data = $good->promotion_list($param,$uid);

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }

            return  returnJson(3,'请登录');
    }

    /**
     * AI订单详情
     * @param $order_id
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function promotion_details($order_id)
    {
        $uid = Session::get("uid");
        if($uid){

            $data = (new PromotionOrder())->details($order_id);


            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }

        return  returnJson(3,'请登录');
    }

    /**
     * 订单修改
     */
    public function promotion_upd()
    {
        $user_id = Session::get("uid");

        if ($user_id) {
            //获取参数
            $request = Request::instance();
            $param = $request->param();

            $data = (new PromotionOrder()) ->upd($param);

            return $data !== false ? returnJson(1,'操作成功') : returnJson(0,'操作失败');
        } else {

            return  returnJson(3,'请登录');
        }

    }

    /**
     * 确认状态
     */
    public function promotion_status($order_id,$status)
    {
        $user_id = Session::get("uid");

        if ($user_id) {

            $data = (new PromotionOrder()) ->status($order_id,$status);

            return $data !== false ? returnJson(1,'操作成功') : returnJson(0,'操作失败');
        } else {

            return  returnJson(3,'请登录');
        }
    }

    /**
     * 修改稿件
     * @param $order_id
     * @param $url
     */
    public function manuscripts_upd($order_id,$url)
    {
        $user_id = Session::get("uid");

        if ($user_id) {

            $data = PromotionOrder::update(['project_url'=>$url],['id'=>$order_id]);

            return $data !== false ? returnJson(1,'操作成功') : returnJson(0,'操作失败');
        } else {

            return  returnJson(3,'请登录');
        }
    }


}
