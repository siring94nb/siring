<?php

namespace app\api\controller;

use app\data\model\InvestmentClass;
use app\data\model\InvestmentProject;
use think\Controller;
use think\Request;
use think\Validate;
use think\Session;
use think\Db;
class Investment extends Controller
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
