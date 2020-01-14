<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/2
 * Time: 11:55
 */
namespace app\data\model;

use think\Model;

/**
 * 支付公共接口
 * Class PayMent
 */
class Payoff extends Model
{
    protected $table="order";
    protected $resultSetType = 'collection';
    /**
     * 支付流程
     * @author fyk
     * @param $id
     * @param $money
     * @param $pay_type 1支付宝支付，2微信支付，3银联卡支付，4余额支付
     * @param $password
     * @param $unionpay
     * @return array|mixed|string|\think\response\Json
     * @throws \think\Exception
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function pay($id,$money,$pay_type,$password,$unionpay,$ratio)
    {
        $data = self::get($id);
        if(!$data) returnJson(0,'订单有误');
        if($data['payment'] == 2) returnJson(0,'当前订单已支付');
        //查询等级
        $user = UserGrade::get(['user_id'=>$data['user_id']]);

        //查询比例
        $grade = JoinRole::member_details($user['grade']);
        //算出金额
        $pay_money = $data['money'] * ($grade['discount']/100) * $ratio;
        //比较
        // if($money != $pay_money) returnJson(0,'系统有误');

        switch ($pay_type){
            case 1://支付宝支付

                $pay = 0.01 ;//先测试1分钱
                $title = '余额充值' ;
                $notify_url = 'https://manage.siring.com.cn/api/Callback/balance_notify'; // 异步通知 url，*强烈建议加上本参数*
                $return_url = 'https://manage.siring.com.cn/api/Callback/balance_return'; // 同步通知 url，*强烈建议加上本参数*
                $res = ( new Alipay()) ->get_alipay($notify_url,$return_url,$data['no'],$pay,$title);
                //生成支付码
                $imgData = 'http://qr.topscan.com/api.php?text='. $res['qr_code'];

                self::save(['alipay' => $imgData],['id' => $id]);

                return json(['code'=>1,'msg'=>'发起支付成功','imgData'=>$imgData]);exit();
                break;
            case 2://微信支付

                // 回调地址
                $url = 'https://manage.siring.com.cn/api/Callback/balance_notice';

                $pay = 1;//先测试1分钱

                $title = '余额充值';
                $res = (new WechatPay())->pay($title,$data['no'], $pay, $url);

                return $res; exit();


                break;

            case 3://银联卡支付

                $this->startTrans();
                try {
                    $data_need = [
                        'pay_type'=>3,
                        'payment'=> 2,
                        'unionpay'=> $unionpay,
                    ];
                    self::where('id', $id)->update($data_need);

                    $off = (new Offline())->get_add($data['no'],$data['user_id'],$unionpay);

                    $this->commit();

                    return $off ? returnJson(1, '提交成功，请等待审核', $off) : returnJson(0, '提交失败', $off);


                } catch (\Exception $e) {

                    $this->rollback();

                    returnJson(0,'事务失败');exit();
                }
                break;
            case 4://余额支付

                // 判断密码是否正确
                $fund = UserFund::user($data['user_id']);
                if($fund['money'] < $pay_money )returnJson(0,'余额不足请充值');
                //pp($fund);die;
                if (password_verify($password ,$fund['pay_password'])) {
                    $this->startTrans();
                    try {
                        //减去余额
                        $re = (new UserFund())::where('user_id', $data['user_id'])->setDec('money', $pay_money);
                        //修改订单表
                        $data_need = [
                            'pay_type'=>4,
                            'payment'=> 2,
                            'pay_time'=> time(),
                            'need_status'=> 4,
                        ];
                        self::save($data_need,['id' => $id]);
                        //订单统计表添加
                        $role_type = 4;
                        $budget_type = 1;
                        $income = '';//收入金额
                        (new AllOrder())->allorder_add($role_type,$budget_type,$data,$pay_money,$income);

                        $this->commit();

                        return $re ? returnJson(1, '支付成功', $re) : returnJson(0, '支付失败', $re);

                    } catch (\Exception $e) {

                        $this->rollback();

                        returnJson(0,'事务失败');exit();
                    }
                }else{
                    returnJson(0, '支付密码错误');
                }
                break;
            default:
                returnJson(0,'参数有误');
        }

    }


}
