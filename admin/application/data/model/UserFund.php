<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/1
 * Time: 16:30
 */
namespace app\data\model;
use think\Model;
class UserFund extends Model
{

    protected $table = "user_fund";
    protected $resultSetType = 'collection';

    //用户个人余额信息
    public static function user($uid)
    {
        return self::get(['user_id'=>$uid]) ? self::get(['user_id'=>$uid])->toArray() : returnJson(0,'数据有误');
    }

    /**
     * lilu
     * 配置/修改用户的支付密码
     * param  user_id   用户id
     */
    public function set_user_pay_password($user_id,$password)
    {
        $re=self::update(['user_id'=>$user_id,'pay_password'=>$password]);
        return   $re  ?  $re    :  returnJson(0,'数据有误');
    }

}
