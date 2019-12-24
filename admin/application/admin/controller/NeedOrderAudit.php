<?php
namespace  app\admin\controller;


use app\data\model\NeedOrder;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;
use app\util\ReturnCode;

/**
 * @author fyk
 * 订单审核
 * Class NeedOrderAudit
 * @package app\admin\controller
 */
class NeedOrderAudit extends Base
{

    /**
     * 审核列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();

        $where =[];
        $where['examine'] = null;
        $where['examine_type'] = null;
        if(!empty($param['title'])){
            $where['need_order|need_phone'] = $param['title'];
        }
        if(!empty($param['start_time'])){
            $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
            $where['created_at'] = ['gt',$param['start_time']];
        }
        if(!empty($param['end_time'])){
            $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
            $where['created_at'] = ['lt',$param['end_time']];
        }
        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'id,need_order,need_name,need_category,need_terminal,need_money,need_order_money,create_time,examine,examine_type,need_surplus,work_day,status,need_info_c';
        $order = 'id desc';

        $list = (new NeedOrder())->field($field) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $this->buildSuccess([
            'list' => $list['data'],
            'count' => $list['total'],
        ]);
    }

    /**
     * 审核详情
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function need_orderAudit_detail()
    {
        $request=Request::instance();
        $postData=$request->param();
        if (!$postData['id'])returnJson(0, '当前id不能为空');
        //获取详情
        $need_detail= NeedOrder::get($postData['id'])->toArray();

        return $need_detail  ? $this->buildSuccess(['data'=>$need_detail,]) : $this->buildFailed(0,'获取失败');

    }

    /**
     * 审核修改
     * @return array
     */
    public function orderAudit_upd()
    {
        $request=Request::instance();
        $postData=$request->param();
        $validate = new Validate([
            ['id', 'require', '主键id不能为空'],
            ['examine', 'require', '2为通过，3为不通过'],
            ['examine_opinion', 'require', '审核意见不能为空'],
        ]);
        if (!$validate->check($postData)) {
            returnJson(0, $validate->getError());exit();
        }
        $res = NeedOrder::where('id',$postData['id'])->strict(false)->update($postData);
        if($res !== false){
            //修改需求订单的状态
            $re = NeedOrder::where('id',$postData['id'])->update(['examine_type'=>1,'examine'=>$postData['examine']]);

            return $re !== false ? $this->buildSuccess(1,'意见提交成功') : $this->buildFailed(0,'意见提交失败');

        }else{
            return $this->buildFailed(ReturnCode::DB_READ_ERROR,'提交失败');
        }

    }

}
