<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/14
 * Time: 15:06
 */
namespace app\api\controller;

use app\data\model\Extension;
use app\data\model\PromotionOrder;
use app\data\model\WechatPay;
use think\Request;
use think\Session;
use think\Db;
use think\Validate;
/**
 * AI推广引擎
 * Class Manuscript
 * @package app\api\controller
 */
class Manuscript extends Base
{
    public function demand_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $type = $param['role_type'];
        switch ($type) {
            case 1://委托代写
                $validate = new Validate([
                    ['title', 'require', '标题不能为空'],
                    ['object', 'require', '对象必须'],
                    ['num', 'require', '字数类型必须'],
                    ['tid', 'require', '套餐id不能为空'],
                    ['ask', 'require', '代写要求必须'],
                    ['price', 'require', '支付金额必须'],
                    ['grade', 'require', '申请等级不能为空'],
                    ['url', 'require', '参考链接必须'],
                    ['resume', 'require', '我的素材必须'],
                    ]);
                if (!$validate->check($param)) {
                    returnJson (0, $validate->getError());exit();
                }
                $user_id = Session::get("uid");
                if ($user_id) {
                    $user_id = Session::get("uid");
                } else {
                    $user_id = $param["user_id"];
                }
                //判断优惠券
                if(empty($param['yid'])){
                    $param['yid'] = '';
                }
                //开启事务
                Db::startTrans();
                try {
                    $city = new PromotionOrder();

                    $data = $city->order_add($type,  $user_id,$param['title'],$param['object'],$param['num'],$param['yid'],
                        $param['tid'],$param['ask'],$param['price'],$param['grade'],'',$param['resume'],$param['url']);
                    $order_id = $data->id;

                    Db::commit();

                    return $data ? returnJson(1, '提交成功', $order_id) : returnJson(0, '提交失败', $order_id);

                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return false;
                }
                break;
            default://自有稿件
                $validate = new Validate([
                    ['title', 'require', '标题不能为空'],
                    ['object', 'require', '对象必须'],
                    ['resume', 'require', '我的素材必须'],
                    ['con', 'require', '阅览必须'],
                    ['tid', 'require', '套餐id不能为空'],
                    ['price', 'require', '支付金额必须'],
                    ]);
                if (!$validate->check($param)) {
                    returnJson (0, $validate->getError());exit();
                }
                $user_id = Session::get("uid");
                if ($user_id) {
                    $user_id = Session::get("uid");
                } else {
                    $user_id = $param["user_id"];
                }
                //判断优惠券
                if(empty($param['yid'])){
                    $param['yid'] = '';
                }
                //开启事务
                Db::startTrans();
                try {
                    $city = new PromotionOrder();

                    $data = $city->order_add($type,  $user_id,$param['title'],$param['object'],'', $param['yid']
                        ,$param['tid'],'',$param['price'],'',$param['con'],$param['resume'],'');

                    $order_id = $data->id;

                    Db::commit();

                    return $data ? returnJson(1, '提交成功', $order_id) : returnJson(0, '提交失败', $order_id);

                } catch (\Exception $e) {
                    // 回滚事务
                    Db::rollback();
                    return false;
                }
                break;
            }
    }

    /**
     * AI套餐列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function set_meal()
    {
        $where['status'] = 1;
        $field = 'id,name,price,money,con';
        $data = ( new Extension() ) -> where($where) -> field($field) ->order('sort asc') ->select() ->toArray();

        return $data ? returnJson(1, '获取成功',$data) : returnJson(0, '获取失败',$data);
    }


    /**
     * 支付订单
     * @author fyk
     * @return array|string|\think\response\Json
     */
    public function get_pay()
    {
        $request = Request::instance();
        $param = $request->param();
        $type = $param['type']; //1微信支付，2支付宝支付
        $id = $param['order_id'];
        switch($type) {
            case 1:
                // 查询订单信息
                $url = 'https://manage.siring.com.cn/api/Manuscript/app_notice';
                $order = db('promotion_order')->getById($id);

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
     * 店铺支付成功微信回调demo
     * @return mixed
     */
    public function app_notice(){

        //初始化微信sdk
        $wxConf = config('wechat');

        $app = new Application($wxConf);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号transaction_id" 或者 "商户订单号out_trade_no"
            $rstArr = json_decode($notify,true);

            $where = array('no'=>$rstArr['out_trade_no']);

            $orderArr = Db::table('promotion_order')->where($where)->field('id,user_id,payment,status,no')->find();
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

                    //订单表
                    $order_data = Db::table('promotion_order')->where($where)->update(array('payment' => 2,'status' => 2, "pay_time" => time()));

                    return  $order_data ? true : false;

                });

            }
            return $result  ? returnJson(1,'支付成功') : returnJson(0,'支付失败');
        });
        // 将响应输出
        return $response;
    }

}
