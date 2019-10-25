<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 17:36
 */

namespace app\admin\controller;

use app\model\SearchHot;
use app\model\User;
use app\model\UserFund;
use app\model\UserDetails;
use app\model\UserGrade;
use think\Config;
use think\Db;
use think\Request;
use app\util\ReturnCode;

class UserManage extends Base{
/**
     * 获取会员列表
     * @return array
     * @throws \think\exception\DbException
     * @author fyk
     * @time 2019/2/28
     */

    public function index( Request $request ){

        $request = Request::instance();
        $param = $request->param();

        $title = $request -> get( 'title' , '' );
        $keyword = $request -> get( 'keywords' , '' );
        $limit = $request -> get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $start = $request -> get('page', 1);
        $where = array();
        $where['type'] = 1;
        $where['status'] = 1;

        if( $title ){
            $where['phone|realname'] = array( 'like' , '%'.$title.'%' );
        }
        if( $keyword ){
            $where['phone'] = $keyword;
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

        $field = 'id,invitation,other_code,sex,status,realname,phone,grade,img,remark,created_at,end_time';
        $order = 'id desc';

        $user = new User();
        $list = $user -> field( $field ) -> where( $where ) -> order( $order )
                -> paginate( $limit , false , array( 'page' => $start ) ) -> toArray();

        return $this -> buildSuccess( array(
                'list' => $list['data'],
                'count' => $list['total'],
        ) );
    }
    /**
     * 用户添加
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author fyk
     * @time 2019/2/28
     */

    public function Add( Request $request ){
        $param = $request -> param();

        if( !$param['realname'] ){
            return $this -> buildFailed( 1001 , '姓名不能为空' );
        }

        if( !$param['phone'] ){
            return $this -> buildFailed( 1002 , '手机号码不能为空' );
        }

        $reg = '/^1\d{10}$/';
        if( !preg_match( $reg , $param['phone'] ) ){
            return $this -> buildFailed( 1003 , '手机号码格式不正确' );
        }

        //判断手机号是否重复
        $user = new User();
        $where['type'] = 1;
        $where['phone'] = $param['phone'];
        $ret = $user -> where( $where ) -> find();
        if( $ret ){
            return $this -> buildFailed( 1004 , '手机号已被使用' );
        }

        //判断密码
        if(!empty($param['password'])){
            if(empty($param['con_password'])){
                return $this -> buildFailed( 1006 , '请输入确认密码' );
            }
            if($param['password'] != $param['con_password']){
                return $this -> buildFailed( 1007 , '两次密码不一致' );
            }
            $password = $param['password'];
        }else{
            $password = '123456';
        }

        if(!isset($param['remark'])){
            $param['remark'] = '';
        }

        //开始写入数据
        $salt = mt_rand( 100000 , 999999 );
        $insert_user_data = array(
            'realname' => $param['realname'],
            'img' => $param['img'],
            'phone' => $param['phone'],
            'remark' =>$param['remark'],
            'password' => md5($password),
            'type' =>  1,
            'salt' => $salt,
            'created_at' => date( 'Y-m-d H:i:s' )
        );

        $res = Db::transaction( function() use ( $insert_user_data ){

            $res1 = (new User()) -> insertGetId( $insert_user_data );

            $res2 = (new UserGrade()) -> insert(['user_id'=>$res1]);

            return $res1 && $res2 ? true : false;
        });

        if( $res ){
            return $this -> buildSuccess( array() , '用户新增成功' );
        }else{
            return $this -> buildFailed( 1005 , '用户新增失败' );
        }
    }
    /**
     * 用户修改
     * @return array
     * @throws \think\exception\DbException
     * @author fyk
     * @time 2019/3/1
     */
    public function Edit( Request $request ){
        $param = $request -> param();

        $id = $param['id'];
        if( !$id ){
            return $this -> buildFailed( '1001' , 'id不存在' );
        }

        if( !$param['realname'] ){
            return $this -> buildFailed( 1002 , '昵称不能为空' );
        }

        if( !$param['phone'] ){
            return $this -> buildFailed( 1003 , '手机号码不能为空' );
        }

        $reg = '/^1\d{10}$/';
        if( !preg_match( $reg , $param['phone'] ) ){
            return $this -> buildFailed( 1004 , '手机号码格式不正确' );
        }

        //判断手机号是否重复
        $user = new User();
        $where['type'] = 1;
        $where['phone'] = $param['phone'];
        $where['id'] = array( 'neq' , $id );
        $ret = $user -> where( $where ) -> find();
        if( $ret ){
            return $this -> buildFailed( 1005 , '手机号已被使用' );
        }

        //判断密码
        if(!empty($param['password'])){
            if(empty($param['con_password'])){
                return $this -> buildFailed( 1006 , '请输入确认密码' );
            }
            if($param['password'] != $param['con_password']){
                return $this -> buildFailed( 1007 , '两次密码不一致' );
            }
        }

         if(!isset($param['remark'])){
             $param['remark'] = '';
         }
        //开始更新数据
        $update_user_data = array(
            'realname' => $param['realname'],
            'img' =>$param['img'],
            'phone' => $param['phone'],
            'remark' =>$param['remark'],
            'type' => 1,
        );
        if(!empty($param['password'])){
            $update_user_data['password'] = md5($param['password']);
        }

        $res = Db::transaction( function() use ( $update_user_data , $id ){
            $res1 = (new User()) -> where( 'id = '.$id ) -> update( $update_user_data );
            if( $res1 !== false ){
                return true;
            }else{
                return false;
            }
        });

        if( $res !== false ){
            return $this -> buildSuccess( array() , '用户修改成功' );
        }else{
            return $this -> buildFailed( 1006 , '用户修改失败' );
        }
    }

    /**
     * 用户删除
     * @return array
     * @throws \think\exception\DbException
     * @author fyk
     * @time 2019/3/1
     */

    public function Delete(){
        $id = $this -> request -> post( 'id' , 0 );

        $res = User::get( $id ) -> update(['delect_at'=>time()]);
        if( $res ){
            return $this -> buildSuccess( array() , '用户删除成功' );
        }else{
            return $this -> buildFailed( 1001 , '用户删除失败' );
        }
    }
}
