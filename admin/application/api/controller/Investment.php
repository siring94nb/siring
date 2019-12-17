<?php

namespace app\api\controller;

use app\data\model\InvestmentClass;
use app\data\model\InvestmentProject;
use app\data\model\InvestmentSet;
use think\Controller;
use think\Request;
use think\Validate;
use think\Session;
use think\Db;
class Investment extends Base
{
    /**
     * 行业领域
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function industry_field()
    {
        $data = (new InvestmentClass())->select();

        return $data ? returnJson(1,'获取成功',$data) :  returnJson(0,'获取失败',$data);
    }

    /**
     * 我要融资
     * @return bool|void
     */
    public function finance_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['title', 'require', '项目名称不能为空'],
            ['cid','require','行业领域必须'],
            ['reward','require','打赏金额必须'],
            ['location', 'require', '项目定位不能为空'],
            ['bright','require','项目亮点必须'],
            ['revenue','require','营收模式必须'],
            ['user_data', 'require', '用户数据不能为空'],
            ['valuation','require','融资阶段必须'],
            ['background','require','创始人资料必须'],
            ['advantage', 'require', '核心优势必须'],
            ['bp_url','require','商业计划书必须'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }
        $user_id = Session::get("uid");
        if($user_id){
            $param['uid'] = Session::get("uid");
        }else{
            $param['uid'] = $param["user_id"];
        }

        //开启事务
        Db::startTrans();
        try{
            $investment = new InvestmentProject();
            $data = $investment->investment_add($param);

            $order_id = $data->id;

            Db::commit();

            return $data ? returnJson(1,'提交成功',$order_id) : returnJson(0,'提交失败',$order_id);

        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }


    }

    /**
     * 分类费用
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function industry_cost()
    {

        $data = InvestmentSet::industry_index();

        return $data ? returnJson(1,'获取成功',$data) :  returnJson(0,'获取失败',$data);
    }


    /**
     * 投融列表
     * @throws \think\exception\DbException
     */
    public function industry_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $good = new InvestmentProject();

        $uid = Session::get("uid");

        if($uid){

            $uid = Session::get("uid");
            $data = $good->user_investment_list($param,$uid);


            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }
        $data = $good->investment_list($param);



        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

    }

    /**
     * 项目详情
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function project_details()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id', 'require', '项目主键id不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        $project = new InvestmentProject();

        $data = $project->details($param);

        return $data ? returnJson(1,'获取成功',$data) :  returnJson(0,'获取失败',$data);
    }

    /**
     * 控制台-我的投融列表
     * @throws \think\exception\DbException
     */
    public function console_list()
    {
        $request = Request::instance();
        $param = $request->param();
        $good = new InvestmentProject();

        $uid = Session::get("uid");

        if($uid){

            $uid = Session::get("uid");
            $data = $good->investment_project_list($param,$uid);


            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
        }

        return  returnJson(0,'请登录');
    }


}
