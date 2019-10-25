<?php

namespace app\api\controller;

use app\data\model\UserGrade;
use think\Request;
use app\data\model\User as UserAll;
use think\Validate;
use think\Controller;
use think\captcha\Captcha;
use think\Session;
use think\Db;
/**
 * Class User登录 注册
 * @package app\api\controller
 * @time 2019/10/10
 */
class User extends Base
{
    /**
     * 获取验证码
     * @return array
     * @author fyk
     */
    public function code()
    {

        $request = Request::instance();
        $data = $request->param();
        // 验证
        $rules = [
            'phone' => 'require|regex:\d{11}',
        ];
        $msg = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
        ];
        $valid = new Validate($rules, $msg);
        if (!$valid->check($data)) {
            return json(['code' => 0,'msg' => $valid->getError()]);
        }

        $mobileCode = rand(100000, 999999);
        $mobile = $data['phone'];
        //存入session中
        if (strlen($mobileCode)> 0){
            Session::set('mobileCode',$mobileCode);
            Session::set('mobile',$mobile);
        }
        $content = "【Siring思锐】尊敬的用户，您本次验证码为{$mobileCode}，(一站式移动互联网开发-运营-推广-API赋能-平台验证码，十分钟内有效)";
        $output = sendMessage($content,$mobile);

        return $output  ? returnJson(1,'发送成功') : returnJson(0,'发送失败');
    }

    /**
     * 注册
     * @return array
     * @author fyk
     * Db::transaction
     */
    public function register(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'phone' => 'require|regex:\d{11}|unique:user',
            'password'=>'require|alphaNum|confirm|length:6,16',
//            'code'=>'require',
        ];
        $message = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'phone.unique' => '该用户已存在,请前往登录,如有问题请联系管理员',
            'password.require'=>'密码不能为空',
            'password.length' => '密码长度必须在6~16位之间',
            'password.confirm' => '两次密码输入不一致',
//            'code.require'=>'验证码不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }

//        if (Session::get('mobileCode') != $param['code']) {
//            return json(['code'=>0,'msg'=>$param['code']."验证码不正确"]);
//        }
        //判断邀请码
        if(empty($param['invitation'])){
            $param['invitation'] = '';
        }else{
            $user = new UserAll();
            $user->invitation($param['invitation']);
        }

        //验证
        $param['salt'] = substr(uniqid(rand()),-6);
        //生成密码
        $param['cipher'] = password_hash($param['password'],PASSWORD_DEFAULT);

        //调取生成个人邀请码
        $param['my_code'] = create_invite_code();

        // 储存
        $result = Db::transaction(function()use ( $param ){
            //用户表
            $user = new UserAll();
            $data = $user->add($param);
            $uid = $data->id;
            //等级表
            $user_grade = new UserGrade();
            $user_data = $user_grade->add($uid);

            return $data && $user_data ? true : false;

        });


        return $result  ? returnJson(1,'注册成功') : returnJson(0,'注册失败');

    }

    /**
     * 登录
     * @return array
     * @author fyk
     */

    public function login()
    {
        $request = Request::instance();
        $data = $request->param();
        // 验证
        $rules = [
            'phone' => 'require|regex:\d{11}',
            'password' => 'alphaNum|require|length:6,16',
//            'captcha|验证码'=>'require|captcha'
        ];
        $msg = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'password.require' => '密码不能为空',
            'password.length' => '密码长度必须在6~16位之间'
        ];
        $valid = new Validate($rules, $msg);
        if (!$valid->check($data)) {
            return json(['code' => 0,'msg' => $valid->getError()]);
        }
        // 查询判断
        $user = UserAll::phone($data['phone']);
        if($user['status'] == 2 && $user['delect_at'] !== null )returnJson(0,'该账号已禁止，请联系管理员处理');

        // 判断密码是否正确
        if (password_verify($data['password'] ,$user['password'])) {
            //更新openID
            if(!empty($data['open_id'])){
                db('user') ->where('id',$user['id']) ->update(['openid'=>$data['open_id']]);
            }
                Session::set('uid',$user['id']);
                Session::set('user_salt',$user['salt']);

            $res['user_id'] = $user['id'];
            return json(['code'=>1,'msg'=>'登录成功','data'=>$res]);
        }else {
            return json(['code'=>0,'msg'=>'密码错误']);
        }

    }


    /**
     * 验证码
     * @return array
     * @author fyk
     */
    public function vs_code(){
        //引用
        $captcha = new Captcha();
        $captcha->fontSize = 30;
        $captcha->length   = 4;
        $captcha->useNoise = false;
        return $captcha->entry();
    }

    /**
     * 忘记密码
     * @return array
     * @author fyk
     */
    public function forget(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'phone' => 'require|regex:\d{11}',
            'password'=>'require|alphaNum|confirm|length:6,16',
            'code'=>'require',
        ];
        $message = [
            'phone.require' => '请输入手机号',
            'phone.regex' => '手机号格式不正确',
            'password.require'=>'密码不能为空',
            'password.confirm' => '两次密码输入不一致',
            'password.length' => '密码长度必须在6~16位之间',
            'code.require'=>'验证码不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }

        if (Session::get('mobileCode') != $param['code']) {
            return json(['code'=>0,'msg'=>$param['code']."验证码不正确"]);
        }

        $password = password_hash($param['password'],PASSWORD_DEFAULT);

        // 储存
        $user = new UserAll();
        $result = $user->editPassword($param['phone'],$password);

        return $result !== false ? returnJson(1,'修改密码成功') : returnJson(0,'修改密码失败');

    }

    /**
     * 修改手机号
     * @return array
     * @author fyk
     */
    public function edit_phone(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'user_id' => 'require',
            'new_phone' =>'require|regex:\d{11}',
            'new_code'=>'require',
            'password'=>'require',
        ];
        $message = [
            'new_phone.require' => '请输入新手机号',
            'new_phone.regex' => '新手机号格式不正确',
            'new_code.require'=>'新手机验证码不能为空',
            'password.require'=>'原密码不能为空',
        ];
        //验证
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return json(['code' => 0,'msg' => $validate->getError()]);
        }

        if (Session::get('mobileCode') != $param['new_code']) {
            return json(['code'=>0,'msg'=>$param['new_code']."验证码不正确"]);
        }
        $user = db('user') ->where('id',$param['user_id']) ->find();
        if ($user['phone'] === $param['new_phone']) {
            return json(['code'=>0,'msg'=>$param['new_phone']."该手机已注册"]);
        }
        if (password_verify($param['password'] ,$user['password'])) {
            // 储存
            $user = new UserAll();
            $result = $user->edit_tel($param['user_id'],$param['new_phone']);

            $res = $result ? ['code' => 1,'msg' => '修改手机号成功'] : ['code' => 0,'msg' => '修改手机号失败'];
            return json($res);

        }else {
            return json(['code'=>0,'msg'=>'密码错误']);
        }



    }


}
