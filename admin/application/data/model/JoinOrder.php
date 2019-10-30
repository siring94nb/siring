<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/9
 * Time: 14:11
 */
namespace app\data\model;

use think\Model;

class JoinOrder extends Model
{
    protected $table = "join_order";
    protected $resultSetType = 'collection';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
//    protected $hidden = ['created_at','updated_at'];
//    protected $auto = ['created_at'];
//    protected $update = ['updated_at'];
//    public function setTimeAttr()
//    {
//        return time();
//    }
//
//    public function setTimeUpdateAttr()
//    {
//        return time();
//    }

    //新增订单
    public function order_add($role_type,$uid,$pay_type,$num,$money,$dev,$grade,$con)
    {
        $data = new JoinOrder;
        $data->save([
            'role_type' => $role_type,
            'user_id' => $uid,
            'pay_type' => $pay_type,
            'no' => $this->get_sn(),
            'num' => $num,
            'money' => $money,
            'payment' => 1,
            'status' => 1,
            'dev' => $dev,
            'grade' => $grade,
            'con' =>$con,
            'created_at' => time(),

        ]);

        return $data !== false ? $data : false;
    }

    //生成订单号
    function get_sn() {
        return 'JS'.date('YmdHi').rand(100000, 999999);
    }

    //展示
    public function join_order_list()
    {

        return self::all()->toArray();

    }

//    //当前用户
//    public function user($id)
//    {
//        return self::get(['id'=>$id]);
//    }

    //修改
    public function user_edit($id)
    {
        return self::get(['id'=>$id]);
    }

    //修改前台用户
    public function user_api_edit($username,$phone,$password,$salt,$status,$type,$id)
    {
        return $this->save([
            'username' => $username,
            'phone' => $phone,
            'password' => $password,
            'salt' => $salt,
            'status' => $status,
            'type' => $type,
            'create_time' => time(),

        ],['id' => $id]);
    }

    //修改后台用户
    public function user_admin_edit($nickname,$username,$phone,$password,$salt,$problem,$answer,$status,$type,$east,$western,$power,$id)
    {
        return $this->save([
            'nickname' => $nickname,
            'username' => $username,
            'phone' => $phone,
            'password' => $password,
            'salt' => $salt,
            'problem' => $problem,
            'answer' => $answer,
            'status' => $status,
            'type' => $type,
            'east_longitude' => $east,
            'western_scriptures' =>$western,
            'power' =>$power,
            'create_time' => time(),

        ],['id' => $id]);
    }
    //修改状态
    public function user_status($id,$status)
    {
        return $this->save([
            'status' => $status,
        ],['id' => $id]);
    }

    //删除
    public function user_del($uid)
    {

        return self::destroy($uid);

    }

    //修改头像
    public function img($uid,$img)
    {
        return $this->save([
            'img' => $img,
        ],['id' => $uid]);
    }


    //修改姓名
    public function name($uid,$name)
    {

        return $this->save([
            'username' => $name,
        ],['id' => $uid]);
    }

    //修改位置
    public function seat($uid,$east,$western)
    {
        return $this->save([
            'east_longitude'=>$east,
            'western_scriptures' => $western,
        ],['id' => $uid]);
    }

    //修改场景
    public function edit_scene($uid,$name)
    {
        return $this->save([
            'scene_title' => $name,
        ],['id' => $uid]);
    }
}
