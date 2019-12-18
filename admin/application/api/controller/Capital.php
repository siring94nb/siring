<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/16
 * Time: 17:21
 */
namespace app\api\controller;
use app\data\model\AllOrder;
use app\data\model\InvestmentProject;
use app\data\model\Invoice;
use app\data\model\Recharge;
use app\data\model\SoftOrder;
use app\data\model\MealOrder;
use app\data\model\PromotionOrder;
use app\data\model\UserFund;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;

/**
 * 资金明细
 * @author fyk
 * Class Capital
 * @package app\api\controller
 */
class Capital extends Base
{
    /**
     * 资金明细
     */
    public function capital_detailed()
    {
        $request = Request::instance();
        $param = $request->param();


        $where = [];
        if(!empty($param['budget_type'])){
            $where['budget_type'] = $param['budget_type'];
        }
        if(!empty($param['role_type'])){
            $where['role_type'] = $param['role_type'];
        }
        if(!empty($param['start_time'])){
            $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
            $where['created_at'] = ['gt',$param['start_time']];
        }
        if(!empty($param['end_time'])){
            $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
            $where['created_at'] = ['lt',$param['end_time']];
        }
        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = 'id,role_type,budget_type,phone,income,money,money,pay_type,created_at';
        $order = 'id desc';

        $user = new AllOrder();
        $list = $user -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list ? returnJson(1,'获取成功',$list) : returnJson(0,'获取失败',$list);
    }

    /**
     * 剩余开票金额
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function invoice_amount()
    {
        $uid = Session::get("uid");
        $data =   (new UserFund())->where('user_id',$uid)->find();

        return $data ? returnJson(1,'获取成功',$data['money_invoice']) : returnJson(0,'暂无余额',$data['money_invoice']);
    }

    /**
     * 开票
     */
    public function my_invoice()
    {
        $user_id = Session::get("uid");
        if($user_id){
            $request = Request::instance();
            $param = $request->param();
            $validate = new Validate([
                ['price', 'require', '开票金额必须'],
                ['type', 'require', '发票类型必须'],
                ['status', 'require', '发票样式必须'],
                ['rise', 'require', '发票抬头必须'],
                ['invoiceLine', 'require', '发票种类必须'],
                ['address', 'require', '地址必须'],
            ]);
            if (!$validate->check($param)) {
                returnJson(0, $validate->getError());exit();
            }
            if (empty($param['duty'])) {
                $param['duty'] = '';
            }
            //判断开票金额
            $user_fund = (new UserFund())::where('user_id',$user_id)->find();
            if ($user_fund['money_invoice'] < $param['price']) {
                returnJson(0,'开票金额不足');exit();
            }
            $param['user_id'] = $user_id;
            $result = Db::transaction(function()use ( $param ){
                //发票
                $invoice = new Invoice();
                $data = $invoice->add_invoice($param['user_id'],$param['type'],$param['status'],'',$param['rise'],$param['duty'],$param['price'],'',$param['address']);

                //资金表
                $user_fund_data = (new UserFund())::where('user_id',$param['user_id'])->find();
                $money = $user_fund_data['money_invoice'] - $param['price'];
                $user_fund_save = (new UserFund())::where('id',$user_fund_data['id'])->update(['money_invoice'=>$money]);
                return $data  && $user_fund_save ? true : false;
            });
            return $result ? returnJson(1,'开票成功') : returnJson(0,'开票失败');
        }
        returnJson(0,'登录失效，请重新登录');exit();

    }

    /**
     * 充值订单
     * @return bool|void
     */
    public function recharge()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['type', 'require', '类型不能为空'],
            ['price','require','充值金额不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if(!$user_id){
            returnJson(0,'该用户未登录');exit();
        }
        if(empty($param['coupon'])){
            $param['coupon'] = '';
        }
        //开启事务
        Db::startTrans();
        try{
            $recharge = new Recharge();

            $data = $recharge->order_add($param['type'],$user_id,$param['price'],$param['coupon']);

            $order_id = $data->id;

            Db::commit();

            return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
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
                $url = 'https://manage.siring.com.cn/api/Capital/app_notice';
                $order = db('recharge_order')->getById($id);

                $pay = 1;//先测试1分钱
                if (!$order)returnJson(0, '当前订单不存在');
                //        if($order['status'] = 2)returnJson(0,'当前订单已支付');

                $title = '余额充值';
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
     * 支付成功微信回调demo
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

            $orderArr = Db::table('join_order')->where($where)->field('id,user_id,payment,status,no')->find();
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
                    //用户表
                    $user = Db::table('user')->where('id',$orderArr['user_id'])->update(array('type' => 2));
                    //订单表
                    $order_data = Db::table('join_order')->where($where)->update(array('payment' => 2,'status' => 2, "pay_time" => time()));

                    return $user && $order_data ? true : false;

                });

            }
            return $result  ? returnJson(1,'支付成功') : returnJson(0,'支付失败');
        });
        // 将响应输出
        return $response;
    }



}
