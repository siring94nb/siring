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
class NeedOrder extends Base{

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
            $need_detail=Need::get($postData['id']);
            halt($need_detail);
        }else{
            return $this->buildFailed(ReturnCode::DB_READ_ERROR,'操作失败');


        }
    }



     
}
