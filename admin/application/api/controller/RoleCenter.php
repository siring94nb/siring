<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\data\model\User;
use think\Session;

class RoleCenter extends Controller
{
    /**
     *
     */
    public function city_partner()
    {

        $uid = Session::get("uid");

        $user_data = User::whrer('id',$uid)->find()->toarray();

        if($user_data['type'] = 2){

        }else{
            returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');
        }


    }

    /**
     *城市合伙人会员总计
     */
    public function city_total()
    {

        $uid = Session::get("uid");

        $user_data = User::whrer('id',$uid)->find()->toarray();

        $data['user_total'] = User::where('other_code',$user_data['invitation']) ->count();//城市累计会员总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);


    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
