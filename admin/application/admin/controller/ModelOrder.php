<?php
namespace app\admin\controller;

use think\Request;
use think\Db;
use think\Session;
use app\util\ReturnCode;
use think\Validate;
use app\data\model\ModelOrder;

/**
 * lilu
 * 后端--订单--套餐订单
 */
class ModelOrder extends   Base{

    /**
     * lilu
     * 模板套餐列表
     */
    public function index(){
        $request=Request::instance();
        $param['size'] = $this->request->get('size', config('apiAdmin.ADMIN_LIST_DEFAULT')); 
        $param['page'] = $this->request->get('page', 1);
        $param['title'] = $this->request->get('title', '');
        $param['order_status'] = $this->request->get('order_status', '');
        $param['start_time'] = $this->request->get('start_time', '');
        $param['end_time'] = $this->request->get('end_time', '');
        $model_order=new ModelOrder();
        $data=$model_order->get_saas_order($param);
        if(!empty($data['data'])){
            return   $this->buildSuccess([
                'data'=>$data
            ]);
        }else{
            return   $this->buildFailed(ReturnCode::DB_SAVE_ERROR, '操作失败');

        }

    }
}