<?php
namespace app\admin\controller;

use think\Request;
use think\Db;
use think\Session;
use app\util\ReturnCode;
use think\Validate;
use app\data\model\MealOrder as Model;

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
        $model_order=new Model();
        $data=$model_order->get_saas_order($param);
        if(!empty($data)){
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
     * 更改订单状态（待开通-已完成）
     * id     订单id
     * order_status
     */
    public function   change_order_status()
    {
        $request=Request::instance();
        $postData=$request->param();
        if($postData){
            $re=Model::update($postData)->toArray();
            if($re){
                return  $this->buildSuccess([]);
            }else{
                return  $this->buildFailed(ReturnCode::DB_SAVE_ERROR,'操作失败');
            }
        }else{
            return  $this->buildFailed(ReturnCode::DB_SAVE_ERROR,'缺少必须参数');
        }
    }




















}