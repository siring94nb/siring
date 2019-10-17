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
//    protected $hidden = ['created_at','updated_at'];
    //新增
    public function add($nickname,$username,$phone,$password,$salt,$problem,$answer,$status,$type,$east,$western,$power)
    {
        return $this->save([
            'role_type' => $nickname,
            'user_id' => $username,
            'pay_type' => $phone,
            'no' => $password,
            'money' => $salt,
            'payment' => $problem,
            'status' => $answer,
            'grade' => $status,
            'created_at' => time(),

        ]);
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