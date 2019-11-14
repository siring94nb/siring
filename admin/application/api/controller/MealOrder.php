<?php

namespace app\api\controller;


use app\data\model\MealOrder as Meal;
use app\data\model\Offline;
use app\data\model\WechatPay;
use think\Request;
use think\Session;
use think\Db;
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
            $postData['member_account']=$postData['user_id'];
            unset($postData['user_id']);
            $postData['pay_time']=strtotime($postData['pay_time']);
            $detail['bank_name']=$postData['bank_name'];
            $detail['bank_number']=$postData['bank_number'];
            $detail['comment']=$postData['comment'];
            $detail['account_number']=$postData['account_number'];
            $postData['pay_detail']=json_encode($detail);
            unset($postData['bank_name']);
            unset($postData['bank_number']);
            unset($postData['comment']);
            unset($postData['account_number']);
            $meal=new Meal();
            $res=$meal->allowField(true)->create($postData)->toArray();
            if($res){
                //下单成功
                $re=$this->meal_order_pay($res['id'],$postData['pay_type'],$postData['order_amount']);
                return  $re;
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
     * param   id    订单id
     * param   type    支付方式
     * param   pay     支付金额
     */
    public function meal_order_pay($id,$type,$pay)
    {
         //  1 支付宝支付  2  微信     3 银行转账  4  余额
        switch($type) {
            case 1:    //支付宝
                returnJson(0, '暂未支付宝开通');
            return $res;exit();
                break;  
            case 2:     //微信支付
                 // 查询订单信息
            $url = 'https://manage.siring.com.cn/api/MealOrder/hy_model_notice';
            $order = Db::table('model_order')->getById($id);
            $pay = 1;//先测试1分钱
            if (!$order)returnJson(0, '当前订单不存在');
    //        if($order['status'] = 2)returnJson(0,'当前订单已支付');
                $title = '测试行业模板支付';
                $wechatpay = new WechatPay();
                $res = $wechatpay->pay($title,$order['order_number'], $pay, $url);
                return $res;
                break;
            case 3 :    //银行转账 
                //添加审核记录
                $order = Db::table('model_order')->getById($id);
                $data['create_time']=time();
                $data['order_number']=$order['order_number'];
                $data['member_account']=$order['member_account'];
                $data['pay_type']='Saas套餐费用';
                $data['bank_name']=1111;      //银行名称
                $detail=json_decode($order['pay_detail'],true);
                halt($detail);
                $data['bank_number']=$order['bank_number'];    //银行卡号
                $data['order_number']=$order['order_number'];
                $data['pay_money']=$order['order_amount'];
                $data['comment']=11;
                $data['order_status']=1;
                $data['account_number']=1111;
                $data['chart_name']='model_order';    //所在的数据表的名称
                $offline=Offline::create($data)->toArray();
                if($offline){
                    return '支付成功';
                }else{
                    return '支付失败';
                }
                break;
            case  4 :    //余额
                //扣除用户余额
                $order = Db::table('model_order')->getById($id);
                $re=Db::table('user')->where('user_id',$order['member_account'])->setDec('money',$pay);
                if($re){
                    return '支付成功';
                }else{
                    return '支付失败';
                }
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
            if ($orderArr['order_status'] == 2) {
                returnJson(0,'订单已支付'); // 已经支付成功了就不再更新了
            }
            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $result = Db::transaction(function()use ( $orderArr,$where ){
                    //模板订单表
                    $order_data = Db::table('model_order')->where($where)->update(array('order_status' => 2, "pay_time" => time()));

                    return $order_data ? true : false;

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