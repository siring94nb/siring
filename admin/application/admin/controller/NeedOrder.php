<?php
namespace  app\admin\controller;


use app\data\model\NeedOrder as Need;
use think\Request;
use think\Db;
use think\Session;
use think\Validate;
use app\util\Tools;
use app\util\ReturnCode;

/**
 * lilu
 * 后端-定制需求订单
 */
class NeedOrder extends Base
{

    /**
     * lilu
     * 获取定制需求订单
     */
    public function need_index()
    {
        $param['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT')); 
        $param['page'] = $this->request->get('page', 1);
        $param['title'] = $this->request->get('title', '');
        $param['order_status'] = $this->request->get('order_status', '');
        $param['start_time'] = $this->request->get('start_time', '');
        $param['end_time'] = $this->request->get('end_time', '');
        $model_order=new Need();
        $data=$model_order->get_need_order($param);
        if(!empty($data['data'])){
            return   $this->buildSuccess([
                'data'=>$data['data'],
                'listCount'=>$data['total']
            ]);
        }else{
            return   $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '操作失败');
        }
    }

    /**
     * lilu
     * 获取定制需求内容
     * id   
     * status
     */
    public function get_need_order_detail()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            //获取详情
            $need_detail=Need::get($postData['id'])->toArray();
            return  $this->buildSuccess([
                'data'=>$need_detail,
            ]);
        }else{
            return $this->buildFailed(ReturnCode::DB_READ_ERROR,'操作失败');
        }
    }

    /**
     * lilu
     * 上传报价单
     * param   id   需求订单id
     * param   proposal 报价单
     */
    public function upload_proposal()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $res=$this->need->update(['id'=>$postData['id'],'proposal'=>$postData['proposal']]);
            return $res ?  $this->buildSuccess([]) : $this->buildFailed(ReturnCode::DB_READ_ERROR,'上传失败');
        }else{
           return $this->buildFailed(ReturnCode::DB_READ_ERROR,'缺少必须参数');
        }
    }

    /**
     * lilu
     * 平台确认提交
     * param  work_time    工作日
     * param  need_money   合同金额
     * param  id           需求订单id
     */
    public function offer_sure()
    {
        $request=Request::instance();
        $postData=$request->param();
        $validate = new Validate([
            ['work_time', 'require', '工作日不能为空'],
            ['need_money', 'require', '合同金额不能为空'],
        ]);
        if (!$validate->check($postData)) {
            returnJson(0, $validate->getError());
            exit();
        }
        if(!$postData)
        {
            return $this->buildFailed(ReturnCode::DB_READ_ERROR,'缺少必须参数');
        }
        $res=$this->need->where('id',$postData['id'])->update(['work_time'=>$postData['work_time'],'need_money'=>$postData['need_money']]);
        if($res !==false){
            //修改需求订单的状态
            $re=$this->need->where('id',$postData['id'])->update(['status'=>3]);
        }else{
            return $this->buildFailed(ReturnCode::DB_READ_ERROR,'提交失败');
        }
        return $re ? $this->buildSuccess(1,'提交成功') : $this->buildFailed(0,'提交失败');
    }

    /**
     * lilu
     * 
     */



     
}
