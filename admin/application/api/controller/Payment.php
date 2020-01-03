<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/25
 * Time: 15:52
 */
namespace app\api\controller;
use app\data\model\UserFund;
use app\data\model\UserGrade;
use app\data\model\Payoff;
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
            case 1://软件定制
                $ratio = 1;
                $data =(new Payoff())->pay($param['order_id'], $param['money'], $param['pay_type'], $param['password'], $param['unionpay'], $ratio);

                return $data;

        }
    }
}
