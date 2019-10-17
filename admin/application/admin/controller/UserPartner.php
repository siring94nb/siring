<?php

namespace app\admin\controller;

use think\Request;
use think\Validate;
use app\model\User;
class UserPartner extends Base
{
    /**
     * 合伙人列表
     * @author fyk
     * @return \think\Response
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 2 ;

        $partner = new \app\model\User();

        $data = $partner->user_list($param);

        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

    /**
     * 新增
     * @author fyk
     * @return \think\Response
     */
    public function add()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'phone' => 'require|regex:\d{11}|unique:user',
            'realname'=>'require',
            'remark'=>'require',
            'img'=>'require',
        ];
        $message = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'phone.unique' => '该用户已存在',
            'realname.require'=>'姓名不能为空',
            'remark.require'=>'备注不能为空',
            'img.require'=>'头像不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }
        //判断密码
        if(!empty($param['password'])){
            if(empty($param['password_confirm'])){
                return $this -> buildFailed( 1006 , '请输入确认密码' );
            }
            if($param['password'] != $param['password_confirm']){
                return $this -> buildFailed( 1007 , '两次密码不一致' );
            }
            $password = $param['password'];
        }else{
            $password = '123456';
        }
        $param['type'] = 2;
        //验证
        $param['salt'] = substr(uniqid(rand()),-6);
        //生成密码
        $param['cipher'] = password_hash($password,PASSWORD_DEFAULT);

        //调取生成个人邀请码
        $param['my_code'] = create_invite_code();

        // 储存
        $user = new \app\model\User();
        $res = $user -> user_add( $param['type'],$param['cipher'],$param['salt'],$param['realname']
            ,$param['phone'],$param['remark'],$param['img'],$param['my_code']);

        return $res  ?   $this -> buildSuccess( [] , '新增成功' ) :  $this -> buildFailed( 1001 , '新增失败' );
    }

    /**
     * 修改
     * @author fyk
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
            'phone' => 'require|regex:\d{11}|unique:user',
            'realname'=>'require',
            'remark'=>'require',
            'img'=>'require',
        ];
        $message = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'phone.unique' => '该用户已存在',
            'realname.require'=>'姓名不能为空',
            'remark.require'=>'备注不能为空',
            'img.require'=>'头像不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }
        //判断密码
        if(!empty($param['password'])){
            if(empty($param['password_confirm'])){
                return $this -> buildFailed( 1006 , '请输入确认密码' );
            }
            if($param['password'] != $param['password_confirm']){
                return $this -> buildFailed( 1007 , '两次密码不一致' );
            }
        }
        $param['type'] = 2;
        //验证
        $param['salt'] = substr(uniqid(rand()),-6);
        //生成密码
        if(!empty($param['password'])){
            $param['password'] = password_hash($param['password'],PASSWORD_DEFAULT);

            $user = new \app\model\User();
            $res = $user -> user_upd( $param['id'],$param['type'],$param['password'],$param['salt'],$param['realname']
                ,$param['phone'],$param['remark'],$param['img']);

            return $res  !== false ?   $this -> buildSuccess( [] , '修改成功' ) :  $this -> buildFailed( 1001 , '修改失败' );
        }

        // 储存
        $user = new \app\model\User();
        $res = $user -> user_edit( $param['id'],$param['type'],$param['salt'],$param['realname']
            ,$param['phone'],$param['remark'],$param['img']);

        return $res  !== false ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );

    }



    /**
     * 删除
     * @author fyk
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        $id = $this->request->post('id');

        $res = User::user_del($id);

        return $res  !== false ?   $this -> buildSuccess( [] , '删除成功' ) :  $this -> buildFailed( 1001 , '删除失败' );
    }
}
