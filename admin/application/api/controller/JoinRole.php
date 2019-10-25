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
     * 等级会员费用
     * @author fyk
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function member_list()
    {
        $grade = new \app\data\model\JoinRole();

        $data = $grade->member_index();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 等级会员费用
     * @author fyk
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function join_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $grade = new \app\data\model\JoinRole();

        $data = $grade->join_index($param['policy']);

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 收益预测
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function profit()
    {
        $request = Request::instance();
        $param = $request->param();
        $grade = new \app\data\model\JoinRole();

        $data = $grade -> where('type',$param['type'])->field('id,title,money,policy,forecast')->select();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
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
