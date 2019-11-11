<?php

namespace app\api\controller;

use app\data\model\MealOrder as Meal;
use app\data\model\WechatPay;
use think\Request;
use think\Session;
/**
 * lilu
 * 行业模板控制器
 * @package app\api\controller
 */
class MealOrder extends Base
{

    /**
     * lilu
     * 行业模板-下单
     */
    public function   meal_order_add()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $postData['create_time']=time();
            $postData['meal_end_time']=time()+$postData['meal_end_time']*2*365*24*60*60;
            $postData['order_status']=1;    //  1   未付款
            
            halt($postData);
        }else{
            return   json('0','获取参数失败');
        }

    }

    /**
     * lilu
     * 行业模板支付
     * param   order_id    订单id
     * param   type    支付方式
     */
    public function meal_order_pay()
    {
        $request = Request::instance();
        $param = $request->param();
        $type = $param['type']; //1微信支付，2支付宝支付
        $id = $param['order_id'];
        switch($type) {
            case 1:
            // 查询订单信息
            $url = 'https://manage.siring.com.cn/api/JoinOrder/app_notice';
            $order = db('join_order')->getById($id);

            $pay = 1;//先测试1分钱
            if (!$order)returnJson(0, '当前订单不存在');
    //        if($order['status'] = 2)returnJson(0,'当前订单已支付');
            $title = '代理加盟';
            $wechatpay = new WechatPay();
            $res = $wechatpay->pay($title,$order['no'], $pay, $url);

            return $res;exit();
                break;   // 跳出循环
            case 2:
                returnJson(0, '暂未支付宝开通');
                break; // 跳出循环
        }
        
    }

    /**
     * lilu
     * 获取行业模板订单列表
     * param
     */
    public function get_model_list()
    {
        $where['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $where['page'] = $this->request->get('page', 1);
        $title = $this->request->get('title', '');    //订单编号
        $category_id = $this->request->get('category_id', '');
        $goods_recommend_staus = $this->request->get('goods_recommend_staus', '');

    }



}