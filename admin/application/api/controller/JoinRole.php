<?php

namespace app\api\controller;

use app\data\model\Provinces;
use app\data\model\UserGrade;
use think\Request;
use think\Session;
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
     * 分包商费用列表
     * @author fyk
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function join_class()
    {
        $grade = new \app\data\model\JoinRole();

        $data = $grade->where('type',3)->field('id,title')->select();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 分包商费用
     * @author fyk
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function join_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $grade = new \app\data\model\JoinRole();

        $data = $grade->join_index($param['cid']);
        $res = explode(',',$data['policy']);
        $data['res'] = $res;
       // pp($res);die;
        return $res ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
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
     * 会员折扣
     * @param  int  $id
     * @return \think\Response
     */
    public function discount($id)
    {
//        $id = Session::get('mobileCode');
        $data = UserGrade::where('user_id',$id)->field('id,user_id,grade')->find();
        returnArray($data);
        $grade = $data['grade'];

        $Join = new \app\data\model\JoinRole();
        switch ($grade){
            case 0:
                $res['user_discount'] = 100;

                returnJson(1,'获取成功',$res);exit();

                break;
            case 1:
                $jid = 3;
                $res = $Join->join_user($jid);

                $list['user_discount'] = $res['discount'];
                returnJson(1,'获取成功',$list);exit();
                break;
            case 2:
                $jid = 4;
                $res = $Join->join_user($jid);

                $list['user_discount'] = $res['discount'];
                returnJson(1,'获取成功',$list);exit();
                break;
            case 3:
                $jid = 5;
                $res = $Join->join_user($jid);

                $list['user_discount'] = $res['discount'];
                returnJson(1,'获取成功',$list);exit();
                break;
        }

    }
}
