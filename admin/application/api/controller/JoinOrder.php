<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Validate;
use think\Session;
use app\data\model\JoinOrder as JoinOrderAll;

/**
 * 角色加盟订单
 * Class JoinOrder
 * @package app\api\controller
 */
class JoinOrder extends Controller
{
    /**
     * 城市合伙人订单
     * @author fyk
     * @return \think\Response
     */
    public function city_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['grade', 'require|unique:JoinOrder', '城市id不能为空|该城市已申请'],
            ['con','require|max:100','优势介绍必须|名称最多不能超过100个字符'],
            ['num','require','数量必须'],
            ['price','require','金额必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $role_type = 2;

        $city = new JoinOrderAll();

        $data = $city->order_add($role_type,$user_id,'',$param['num'],$param['price'],'',$param['grade'],$param['con']);

        $order_id = $data->id;
        return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);
    }

    /**
     * 会员订单
     * @author fyk
     * @return \think\Response
     */
    public function member_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['grade', 'require|unique:JoinOrder', '城市id不能为空|该城市已申请'],
            ['con','require|max:100','优势介绍必须|名称最多不能超过100个字符'],
            ['num','require','数量必须'],
            ['price','require','金额必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $role_type = 2;

        $city = new JoinOrderAll();

        $data = $city->order_add($role_type,$user_id,'',$param['num'],$param['price'],'',$param['grade'],$param['con']);

        $order_id = $data->id;
        return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);
    }

    /**
     * 加盟商订单
     * @author fyk
     * @return \think\Response
     */
    public function join_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['grade', 'require|unique:JoinOrder', '城市id不能为空|该城市已申请'],
            ['con','require|max:100','优势介绍必须|名称最多不能超过100个字符'],
            ['num','require','数量必须'],
            ['price','require','金额必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if($user_id){
            $user_id = Session::get("uid");
        }else{
            $user_id = $param["user_id"];
        }
        $role_type = 2;

        $city = new JoinOrderAll();

        $data = $city->order_add($role_type,$user_id,'',$param['num'],$param['price'],'',$param['grade'],$param['con']);

        $order_id = $data->id;
        return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
