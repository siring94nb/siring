<?php

namespace  app\api\controller;


use app\data\model\Category;
use app\data\model\Good;
use app\data\model\NeedOrder as Need;
use app\data\model\NeedScore;
use app\data\model\Special;
use app\data\model\UserGrade;
use app\data\model\WechatPay;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;


class  NeedOrder  extends  Base
{

    /**
     * 需求定制订单
     * @author 李禄
     * @return \think\Response
     */
    public function need_order_add()
    {
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['need_name', 'require', '需求名称不能为空'],
            ['need_category', 'require', '分类不能为空'],
            ['need_budget_down', 'require', '低价预算不能不好空'],
            ['need_budget_up', 'require', '高价预算不能不好空'],
            ['need_phone', 'require', '手机必须'],
            ['need_desc', 'require', '需求描述必须'],
            // ['need_file','require','附件必须'],
        ]);
        if (!$validate->check($param)) {
            returnJson(0, $validate->getError());
            exit();
        }
        $user_id = Session::get("uid");
        if ($user_id) {
            $user_id = Session::get("uid");
        } else {
            $user_id = '16';
            // $user_id = $param["user_id"];
        }
        //开启事务
        Db::startTrans();
        try {
            $param['create_time'] = time();
            $param['need_order'] = 'DZ' . date('Ymdhis') . mt_rand('111111', '999999');
            $param['need_terminal'] = json_encode($param['need_terminal']);
            $data = Need::create($param)->toArray();
            $order_id = $data['id'];
            Db::commit();
            return $data ? returnJson(1, '提交成功', $order_id) : returnJson(0, '提交失败', $order_id);
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }

    /**
     * lilu
     * 定制需求列表
     * user_id
     */
    public function need_order_list()
    {
        $param['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT'));
        $param['page'] = $this->request->get('page', 1);
        $param['title'] = $this->request->get('title', '');
        $param['order_status'] = $this->request->get('order_status', '');
        $param['start_time'] = $this->request->get('start_time', '');
        $param['end_time'] = $this->request->get('end_time', '');
        $request = Request::instance();
        $postData = $request->param();
        if ($postData) {
            $need = new Need();
            $param['user_id'] = $postData['user_id'];
            $data = $need->get_need_order($param,1);
            return $data ? returnJson(1, '获取成功', $data) : returnJson(0, '获取失败');
        } else {
            returnJson(0, '获取失败');
            exit();
        }
    }

    /**
     * lilu
     * 中止项目/确认需求
     * param  status   需求状态
     * param  user_id  客户id
     * param  id       需求订单id
     */
    public function change_status()
    {
        //获取参数
        $request = Request::instance();
        $postData = $request->param();
        $need = new Need();
        if ($postData) {
            if ($postData['status'] == '0') {
                //中止需求
                $res = $need->where('id', $postData['id'])->update(['need_status'=>8]);
            } else {
                //进行下一步  need_status=8
                $res = $need->where('id', $postData['id'])->update(['need_status' => $postData['status']]);
            }
            return $res ? returnJson(1, '操作成功', $res) : returnJson(0, '操作失败');
        } else {
            returnJson(0, '获取参数失败');
            exit();
        }
    }

    /**
     * lilu
     * 需求确认修改
     */
    public function confirm_need_order()
    {
        //获取参数
        $request = Request::instance();
        $postData = $request->param();
        //必填字段验证
        $validate = new Validate([
            ['need_name', 'require', '需求名称不能为空'],
            ['need_category', 'require', '分类不能为空'],
            ['need_budget_down', 'require', '低价预算不能不好空'],
            ['need_budget_up', 'require', '高价预算不能不好空'],
            ['need_phone', 'require', '手机必须'],
            ['need_desc', 'require', '需求描述必须'],
            // ['need_file','require','附件必须'],
        ]);
        if (!$validate->check($postData)) {
            returnJson(0, $validate->getError());
            exit();
        }
        if ($postData) {
            $need=new Need();
            $re=$need->update($postData);
            return $re ?  returnJson(1,'操作成功') : returnJson(0,'操作失败');
        } else {
            returnJson(0, '获取参数失败');
        }
    }

    /**
     * lilu
     * 获取定制需求内容
     * id
     * status
     */
    public function need_order_detail()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            //获取详情
            $need_detail = Need::get($postData['id'])->toArray();
            return $need_detail ?  returnJson(1,'操作成功',$need_detail) : returnJson(0,'操作失败');
        }else{
            returnJson(0, '获取参数失败');
        }
    }

    /**
     * lilu
     * 前端-用户修改协议
     */

    /**
     * @author fyk
     * 评价
     * @throws \think\exception\DbException
     */
    public function need_comment()
    {
        $request = Request::instance();
        $param = $request->param();

        $validate = new Validate([
            ['order_id', 'require|unique:NeedScore', '订单号不能为空|该订单已评价'],
            ['satisfied', 'require|number', '满意度不能为空'],
            ['satisfy', 'require|number', '功能满足不能为空'],
            ['reliable', 'require|number', '可靠性不能为空'],
            ['easy', 'require|number', '易用性不能为空'],
            ['beautiful', 'require|number', '美观性不能为空'],
            ['serve', 'require|number', '总体服务不能为空'],
            ['knowledge', 'require|number', '知识水平不能为空'],
            ['response', 'require|number', '响应速度不能为空'],
            ['complaint', 'require|number', '投诉处理不能为空'],
            ['sale', 'require|number', '售后服务不能为空'],
        ]);
        if (!$validate->check($param)) {
            returnJson(0, $validate->getError());exit();
        }
        $order = Need::get(['need_order'=>$param['order_id']]);
        if(!$order)returnJson(0,'订单有误');

        $param['user_id'] = $order['user_id'];
        unset($param['id']);
        $need = new NeedScore($param);
        $res = $need->allowField(true)->save();

        return $res  ? returnJson(1,'提交成功') : returnJson(0,'提交失败');

    }

    /**
     *
     */
    public function get_pay($type,$id,$money,$pay_type)
    {
        switch ($type){
            case 1:
                $data = (new Need())->pay($id,$money,$pay_type);

                return $data  ? returnJson(1,'成功') : returnJson(0,'失败');
                break;
            case 2:

                break;
            case 3:

                break;
            default:
                returnJson(0,'参数有误');

        }


    }

}
