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
            $postData['order_number']='HY'.date('Ymdhis').rand(000000,999999);
            $postData['create_time']=time();
            $postData['meal_end_time']=time()+$postData['meal_end_time']*2*365*24*60*60;
            $postData['order_status']=1;    //  1   未付款
            $res=Meal::create($postData)->toArray();
            if($res){
                return  json(['1','下单成功','data'=>$res['id']]);
            }else{
                return   json(['0','下单失败']);
            }
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
        $type = $param['type'];    //  1微信支付  2支付宝支付   3银行转账
        $id = $param['order_id'];
        switch($type) {
            case 1:    //微信支付
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
                break;  
            case 2:     //支付宝
                returnJson(0, '暂未支付宝开通');
                break;
            case 3 :    //银行转账 



                break;
        }
        
    }

    /**
     * lilu
     * 微信行业模板订单支付回调
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function hy_model_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);

            $where = array('order_number'=>$rstArr['out_trade_no']);

            $orderArr = Db::table('model_order')->where($where)->field('*')->find();
            if (empty($orderArr)) {
                // 如果订单不存在
                returnJson(0,'订单不存在');
            }
            if ($orderArr['payment'] == 2) {
                returnJson(0,'订单已支付'); // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $result = Db::transaction(function()use ( $orderArr,$where ){
                    //模板订单表
                    $order_data = Db::table('meal_order')->where($where)->update(array('payment' => 2,'status' => 2, "pay_time" => time()));

                    return $user && $order_data ? true : false;

                });

            }
            return $result  ? returnJson(1,'支付成功') : returnJson(0,'支付失败');
        });
        // 将响应输出
        return $response;
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