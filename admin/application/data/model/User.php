<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/12
 * Time: 9:45
 */
namespace app\data\model;
use think\Model;
use think\Session;
class User extends Model
{
    /**
     * 用户model
     * @var string
     */
    protected $table = "user";
    protected $resultSetType = 'collection';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

//    public function getGradeAttr($val)
//    {
//        switch ($val){
//            case 1:
//                return '金牌';
//                    break;
//            case 2:
//                return '钻石';
//                break;
//            case 3:
//                return '皇冠';
//                break;
//            default:
//                return '普通会员';
//                break;
//        }
//    }

    //新增
    public function add($param)
    {
        $user = new User;
        $user->save([
            'phone' => $param['phone'],
            'password' => $param['cipher'],
            'invitation' => $param['my_code'],
            'other_code' => $param['invitation'],
            'salt' => $param['salt'],
            'ip' => $param['ip'],
            'province' => $param['region'],
            'province_id' => $param['pid'],
            'city_id' => $param['cid'],
            'created_at' => time(),
        ]);
        return $user  !== false ? $user : false;
    }

    //修改密码
    public function editPassword($tel, $password)
    {
        return $this->save([
            'password' => $password,
        ],['phone' => $tel,]);
    }

    //修改手机号
    public function edit_tel($uid, $phone)
    {
        return $this->save([
            'phone' => $phone,
        ],['id' => $uid,]);
    }

    //获取是否有验证码信息
    public function invitation($my_invitation)
    {
        return self::get(['invitation'=>$my_invitation]) ? self::get(['invitation'=>$my_invitation])->toArray() : returnJson(0,'邀请码有误');
    }

    //获取个人信息
    public function user_index($uid)
    {
        return self::get(['id'=>$uid]) ? self::get(['id'=>$uid])->toArray() : returnJson(0,'数据有误');
    }

    //获取是否有该手机号
    public static function phone($tel)
    {
        return self::get(['phone'=>$tel]) ? self::get(['phone'=>$tel])->toArray() : returnJson(0,'账号或手机号不存在, 请先注册');
    }

    //用户个人信息
    public function user_detail($uid)
    {
        return self::get(['id'=>$uid]) ? self::get(['id'=>$uid])->toArray() : returnJson(0,'数据有误');
    }

    //更新
    public function edit($param)
    {
        $user = new User;
        $user ->save([
            'realname'=>$param['name'],
            'id_card'=>$param['id_card'],
            'id_card_just'=>$param['id_card_just'],
            'id_card_back'=>$param['id_card_back'],
            'add_province'=>$param['province'],
            'add_city'=>$param['city'],
            'add_area'=>$param['area'],
            'address'=>$param['address'],
            'enterprise_id'=>$param['enterprise_id'],
            'sex'=>$param['sex'],
            'img'=>$param['img'],
            'other_code'=>$param['invitation'],
            'updated_at'=>time()
        ],['id' =>$param["uid"]]);

        return $user  !== false ? $user : false;
    }

    //更新openid
    public function upd($open_id,$msg)
    {
        $user = new User;
        $data = $user ->save(['open_id'=>$open_id,],['id' =>$msg]);

        return $data  !== false ? $data : false;
    }
}
