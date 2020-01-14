<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/04/02
 * Time: 17:36
 */

namespace app\admin\controller;

use app\model\User;
use think\Request;
use think\Db;
use think\Validate;
use app\data\model\UserGrade;
class UserSubcontractor extends Base{

    /**
     * 分包商列表
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function index(){

        $request = Request::instance();
        $param = $request->param();
        $param['is_subpackage'] = 1 ;

        $partner = new \app\model\User();

        $data = $partner->user_list($param);
        foreach ($data['data'] as $k => $v){
            $order = (new \app\data\model\JoinOrder())->join_order_desc($v['sub_id']);
            //查询技能
            $stocks= json_decode( $order['dev'] , true );

            if(!empty($stocks)){
                $name = [];//外层循环为空
                foreach ($stocks as $key => $val){
                    $name[] = implode(",", $val);
                }
                $res = join('/',$name);
                $data['data'][$k]['dev_name'] = $res;
            }else{
                $data['data'][$k]['dev_name'] = "无";
            }


        }
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
        $param['type'] = 3;
        //验证
        $param['salt'] = substr(uniqid(rand()),-6);
        //生成密码
        $param['cipher'] = password_hash($password,PASSWORD_DEFAULT);

        //调取生成个人邀请码
        $param['my_code'] = create_invite_code();
        // 储存
        $result = Db::transaction(function()use ( $param ){
            //用户表
            $user = new \app\model\User();
            $res = $user -> user_add( $param['type'],$param['cipher'],$param['salt'],$param['realname']
                ,$param['phone'],$param['remark'],$param['img'],$param['my_code']);
            $uid = $res->id;
            //等级表
            $user_grade = new UserGrade();
            $user_data = $user_grade->add($uid);

            return $res && $user_data ? true : false;

        });
        // 储存


        return $result  ?   $this -> buildSuccess( [] , '新增成功' ) :  $this -> buildFailed( 1001 , '新增失败' );
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
        $param['type'] = 3;
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
