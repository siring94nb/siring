<?php

namespace app\api\controller;

use app\data\model\WechatPay;
use think\Controller;
use think\Request;
use think\Validate;
use think\Session;
use think\Db;
use app\data\model\JoinOrder as JoinOrderAll;
use think\Config;
use EasyWeChat\Foundation\Application;

/**
 * 角色加盟订单
 * Class JoinOrder
 * @package app\api\controller
 */
class JoinOrder extends Base
{
    /**
     * 城市合伙人订单
     * @author fyk
     * @return \think\Response
     */
    public function city_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['grade', 'require|unique:JoinOrder', '城市id不能为空|该城市已申请'],
            ['con','require|max:100','优势介绍必须|名称最多不能超过100个字符'],
            ['num','require','数量必须'],
            ['price','require','金额必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $role_type = 2;
        //开启事务
        Db::startTrans();
        try{
        $city = new JoinOrderAll();

        $data = $city->order_add($role_type,$user_id,'',$param['num'],$param['price'],'',$param['grade'],$param['con']);

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
     * 会员订单
     * @author fyk
     * @return \think\Response
     */
    public function member_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['grade', 'require', '套餐id不能为空'],
            ['num','require','数量必须'],
            ['price','require','金额必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $role_type = 1;
        //开启事务
        Db::startTrans();
        try{
        $city = new JoinOrderAll();

        $data = $city->order_add($role_type,$user_id,'',$param['num'],$param['price'],'',$param['grade'],'');

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
     * 加盟商订单
     * @author fyk
     * @return \think\Response
     */
    public function join_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['skill', 'require', '技能不能为空'],
            ['language', 'require', '开发语言不能为空'],
            ['con','require|max:100','优势介绍必须|名称最多不能超过100个字符'],
            ['num','require','数量必须'],
            ['price','require','金额必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $info = [
            "skill"=>$param['skill'],
            "language"=>$param['language'],
        ];
        $dev = json_encode($info);

        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }

        $role_type = 3;
        //开启事务
        Db::startTrans();
        try{
        $city = new JoinOrderAll();

        $data = $city->order_add($role_type,$user_id,'',$param['num'],$param['price'],$dev,'',$param['con']);

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
     * 店铺支付成功微信回调demo
     * @throws \EasyWeChat\Core\Exceptions\FaultException
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
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
