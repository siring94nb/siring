<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/16
 * Time: 17:21
 */
namespace app\api\controller;
use app\data\model\AllOrder;
use app\data\model\CashWith;
use app\data\model\UserCard;
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
        $uid = Session::get("uid");
        if($uid){
            $request = Request::instance();
            $param = $request->param();


            $where = [];
            $where['user_id'] = $uid;
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
        returnJson(3,'你当前未登录');
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
        returnJson(3,'登录失效，请重新登录');exit();

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
            returnJson(3,'该用户未登录');exit();
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

    /**
     * 提现接口
     * @return \think\response\Json|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cash_with()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['bank_card', 'require', '银行卡不能为空'],
            ['price','require','提现金额不能为空'],
            ['fund_password','require','密码不能为空'],
            ['code','require','验证码不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if(!$user_id){
            returnJson(3,'该用户未登录');exit();
        }
        if (Session::get('mobileCode') != $param['code']) {
            return json(['code'=>0,'msg'=>$param['code']."验证码不正确"]);
        }
        $user = db('user_fund') ->where('user_id',$user_id)->find();
        if ($user['money'] < $param['price']) {
            returnJson(0,'开票金额不足');exit();
        }
        if (password_verify($param['fund_password'] ,$user['pay_password'])) {

            $recharge = new CashWith();
            $data = $recharge->add($user_id,$param['price'],$param['bank_card']);

            return $data ? returnJson(1,'提交成功') : returnJson(0,'提交失败');
        }else {
            return json(['code'=>0,'msg'=>'密码错误']);
        }

    }

    /**
     * 提现页面详情
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cash_details()
    {
        $user_id = Session::get("uid");
        if(!$user_id){
            returnJson(3,'该用户未登录');exit();
        }
        $user = db('user_fund') ->where('user_id',$user_id)->find();
        if($user['pay_password'] == null){
            returnJson(0,'为了您的资金安全，您需要设置资密码');exit();
        }
        $data = db('user') ->where('id',$user_id)->field('id,phone')->find();
        $data['money'] = $user['money'];

        return $data ? returnJson(1,'成功',$data) : returnJson(0,'失败',$data);
    }

    /**
     * 银行卡列表
     */
    public function bankcard_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $data = (new UserCard()) ->where('user_id',$user_id)->select();

        return $data ? returnJson(1,'成功',$data) : returnJson(0,'失败',$data);
    }

    /**
     * 银行卡新增
     */
    public function bankcard_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['card_number', 'require|number|unique:UserCard', '卡号不能为空|卡号必须为数字|卡号已存在'],
            ['bank_name','require|max:50','银行名称必须|名称最多不能超过500个字符'],
            ['card_name','require','开户名必须'],
            ['bank_branch','require','开户支行必须'],
            ['province','require','省必须'],
            ['city','require','市必须'],
            ['area','require','区必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");

        if($user_id){
            $param['user_id'] = Session::get("uid");
        }else{
            $param['user_id'] = $param["user_id"];
        }
        $card = new UserCard();
        $data = $card->add($param);

        return $data ? returnJson(1,'成功',$data) : returnJson(0,'失败',$data);

    }

    /**
     * 银行卡删除
     */
    public function bankcard_del()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id','require','id必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if(!$user_id){
            returnJson(3,'该用户未登录');exit();
        }

        $data = UserCard::destroy($param['id']);

        return $data ? returnJson(1,'删除成功') : returnJson(0,'删除失败');
    }

    /**
     * 优惠券列表
     * @throws \think\exception\DbException
     */
    public function coupon()
    {
        $request = Request::instance();
        $param = $request->param();


        $where = [];
        if(!empty($param['status'])){
            $where['status'] = $param['status'];
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
        $field = '*';
        $order = 'id desc';

        $list = \app\data\model\UserDiscount::with('discount') -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();
        foreach ($list['data'] as $k=>$v){
            $list['data'][$k]['coupon_name'] = $v['discount']['name'];
            $list['data'][$k]['rule'] = $v['discount']['rule'];
            $list['data'][$k]['type'] = $v['discount']['type'];
            $list['data'][$k]['range'] = $v['discount']['range'];
            $list['data'][$k]['coupon_status'] = $v['discount']['status'];
            $list['data'][$k]['add_time'] = date('Y-m-d H:i:s',$v['discount']['add_time']);
            $list['data'][$k]['end_time'] = date('Y-m-d H:i:s',$v['discount']['end_time']);
            unset($list['data'][$k]['discount']);
        }
        return $list ? returnJson(1,'获取成功',$list) : returnJson(0,'获取失败',$list);
    }


    /**
     * 关联表
     * @return mixed
     */
    public function discount()
    {
        return $this->belongsTo('Discount', 'discount_id', 'id');
    }

}
