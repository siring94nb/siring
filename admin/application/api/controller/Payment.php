<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/25
 * Time: 15:52
 */
namespace app\api\controller;
use app\data\model\Order;
use app\data\model\UserFund;
use app\data\model\UserGrade;
use app\data\model\Payoff;
use app\data\model\NeedOrder;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;

/**
 * @author fyk
 * 支付相关数据
 * Class Payment
 * @package app\api\controller
 */
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
            $request = Request::instance();
            $param = $request->param();

            $validate = new Validate([
                ['uid', 'require', '用户Id不能为空'],
            ]);
            if(!$validate->check($param)){
                returnJson (0,$validate->getError());exit();
            }
            $data = (new \app\data\model\UserDiscount())->dis_list(1,$param['uid']);//目前全部返回未使用优惠卷
            foreach ($data as $k =>$v){
                $data[$k]['name'] = $v['discount']['name'];
                $data[$k]['rule'] = $v['discount']['rule'];
                unset($data[$k]['discount']);
            }

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
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

            $res['money'] = $data['money'];
            $res['pay_password'] = $data['pay_password'];
            return $res ? returnJson(1,'获取成功',$res) : returnJson(0,'获取失败',$res);

        }else{
            $request = Request::instance();
            $param = $request->param();

            $validate = new Validate([
                ['uid', 'require', '用户Id不能为空'],
            ]);
            if(!$validate->check($param)){
                returnJson (0,$validate->getError());exit();
            }
            $data = UserFund::user($param['uid']);
            $res['money'] = $data['money'];
            $res['pay_password'] = $data['pay_password'];

            return $res ? returnJson(1,'获取成功',$res) : returnJson(0,'获取失败',$res);
        }
    }

    /**
     * 会员折扣
     */
    public function discount()
    {
        $uid = Session::get("uid");
        if($uid){

            $data = UserGrade::where('user_id',$uid)->field('id,user_id,grade')->find();
            returnArray($data);
            $join = New \app\data\model\JoinRole();
            //查询折扣
            $grade = $join->member_details($data['grade']);
            $res = $grade['discount'];
            return $res ? returnJson(1,'获取成功',$res) : returnJson(0,'获取失败',$res);

        }else{
            $request = Request::instance();
            $param = $request->param();

            $validate = new Validate([
                ['uid', 'require', '用户Id不能为空'],
            ]);
            if(!$validate->check($param)){
                returnJson (0,$validate->getError());exit();
            }
            $data = UserGrade::where('user_id',$param['uid'])->field('id,user_id,grade')->find();

            returnArray($data);
            $join = New \app\data\model\JoinRole();
            //查询折扣
            $grade = $join->member_details($data['grade']);
            $res = $grade['discount'];
            return $res ? returnJson(1,'获取成功',$res) : returnJson(0,'获取失败',$res);
        }
    }

    /**
     * 支付订单
     * @author
     * @return array|mixed|string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function get_pay()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['type', 'require', '支付分类不能为空'],
            ['order_id', 'require', '订单id不能为空'],
            ['money','require','支付金额不能为空'],
            ['pay_type','require','支付方式必须'],
//            ['password','require','余额密码必须'],
//            ['unionpay','require','银行卡支付参数必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        switch ($param['type']) {
            case 1://余额充值
                $ratio = 1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/balance_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/balance_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/balance_notice';//微信
                $title = '余额充值';
                $data =(new Payoff())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);

                return $data;
                break;
            case 2://签订合同
                $ratio = 0.7;//付款比例
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/app_notice';//微信
                $title = '签订合同';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                        $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);

                return $data;
                break;
            case 3://项目上线
                $ratio = 0.1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/app_notice';//微信
                $title = '项目上线';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);

                return $data;
                break;
            case 4://项目验收
                $ratio = 0.1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/app_notice';//微信
                $title = '项目验收支付';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);
                return $data;
                break;
            case 5://原型确认
                $ratio = 0.1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/app_notice';//微信
                $title = '原型确认支付';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);
                return $data;
                break;
            case 6://项目年服务
                $ratio = 1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/app_notice';//微信
                $title = 'AI推广支付';
                $data =(new Payoff())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);

                return $data;
                break;
            case 7://合伙人支付
                $ratio = 1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/partner_notify'; //支付宝异步
                $return_url = 'https://manage.siring.com.cn/api/Callback/partner_return';//支付宝同步
                $wx_url = 'https://manage.siring.com.cn/api/Callback/partner_notice';//微信
                $title = '合伙人订单支付';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);
                return $data;
                break;
            case 8://等级会员
                $ratio = 1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/grade_notify'; //支付宝异步
                $return_url = 'https://manage.siring.com.cn/api/Callback/grade_return';//支付宝同步
                $wx_url = 'https://manage.siring.com.cn/api/Callback/grade_notice';//微信
                $title = '等级会员订单支付';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);
                return $data;
                break;
            case 9://分包商
                $ratio = 1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/sub_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/sub_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/sub_notice';//微信
                $title = '分包商订单支付';
                $data =(new NeedOrder())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);
                return $data;
                break;
            case 10://AI推广支付
                $ratio = 1;
                //单独回调
                $notify_url = 'https://manage.siring.com.cn/api/Callback/software_notify'; //支付宝
                $return_url = 'https://manage.siring.com.cn/api/Callback/software_return';//支付宝
                $wx_url = 'https://manage.siring.com.cn/api/Callback/app_notice';//微信
                $title = 'AI推广支付';
                $data =(new Payoff())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'],
                    $param['unionpay'], $ratio,$title,$notify_url,$return_url,$wx_url);

                return $data;
                break;
            default:
                returnJson(0,'参数有误');

        }
    }

    /**
     * 支付成功回调
     * @throws \think\exception\DbException
     */
    public function pay_status()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['order_id', 'require', '订单id不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        $data =  Order::get($param['order_id']);

        if($data['payment'] == 2){
            returnJson(1,'当前订单已支付');
        }
        returnJson(0,'当前订单未支付');
    }
}
