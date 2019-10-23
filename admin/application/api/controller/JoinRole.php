<?php

namespace app\api\controller;

use app\data\model\Provinces;
use think\Request;

/**
 * 角色加盟
 * Class JoinRole
 * @package app\api\controller
 */
class JoinRole extends Base
{
    /**
     * 城市合伙人省份列表
     * @author fyk
     * @return \think\Response
     */
    public function province_list()
    {
        $province = new Provinces();
        $data = $province->province_index();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 城市合伙人城市列表
     * @author fyk
     * @return \think\Response
     */
    public function city_list()
    {
        $request = Request::instance();
        $param = $request->param();

        $city = new Provinces();

        $data = $city->city_index($param);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 城市合伙人等级费用
     * @author fyk
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function grade_list()
    {
       $grade = new \app\data\model\JoinRole();

       $data = $grade->grade_index();

       return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
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
