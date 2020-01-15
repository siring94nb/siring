<?php
namespace  app\admin\controller;


use app\data\model\NeedOrder as Need;
use app\data\model\NeedScore;
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
        // $param['user_id'] = $this->request->get('user_id', '');
        $model_order=new Need();
        $data=$model_order->get_need_order($param,0);
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
     * fyk
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
            $need_detail= (new Need())->need_detail($postData['id']);

            return  $this->buildSuccess(['data'=>$need_detail]);
        }else{
            return $this->buildFailed(ReturnCode::DB_READ_ERROR,'操作失败');
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
            ['type', 'require', '类型不能为空：1为平台报价，2签订合同'],
            ['id', 'require', '主键id不能为空'],
        ]);

        if (!$validate->check($postData)) {
            return $this->buildFailed(0,$validate->getError());
        }
        $need_type = $postData['type'];
        unset($postData['type']);
        switch ($need_type){
            case 1://平台报价
                $validate = new Validate([
                  //  ['id', 'require', '主键id不能为空'],
                    ['proposal', 'require', '报价单不能为空'],
                    ['work_day', 'require', '工作日不能为空'],
                    ['need_money', 'require', '合同金额不能为空'],
                ]);
                if (!$validate->check($postData)) {
                    return $this->buildFailed(0,$validate->getError());
                }
                $res = Need::where('id',$postData['id'])->strict(false)->update(
                    [   'proposal'=>$postData['proposal'],
                        'grade'=>$postData['work_day'],
                        'money'=>$postData['need_money'],
                    ]);
                if($res !== false){
                    //修改需求订单的状态
                    $re = Need::where('id',$postData['id'])->update(['examine_type'=>1,'examine'=>1]);

                    return $re !== false ? $this->buildSuccess(1,'状态提交成功') : $this->buildFailed(0,'状态提交失败');

                }else{
                    return $this->buildFailed(ReturnCode::DB_READ_ERROR,'提交失败');
                }

                break;
            case 2://签订合同

                if(!empty($postData['clause'])){

                    $postData['need_status'] =3;
                    $res = Need::where('id',$postData['id'])->strict(false)->update($postData);

                    return $res !== false ? $this->buildSuccess(1,'状态提交成功') : $this->buildFailed(0,'状态提交失败');
                }
                $postData['need_status'] =3;
                $res = Need::where('id',$postData['id'])->strict(false)->update($postData);

                return $res !== false ? $this->buildSuccess(1,'状态提交成功') : $this->buildFailed(0,'状态提交失败');

                break;
            case 3://原型确认
                $validate = new Validate([
                    ['prototype_url', 'require', '原型地址不能为空'],
                ]);
                if (!$validate->check($postData)) {
                    return $this->buildFailed(0,$validate->getError());
                }
                $postData['need_status'] = 4;
                $res = Need::where('id',$postData['id'])->strict(false)->update($postData);

                return $res !== false ? $this->buildSuccess(1,'状态提交成功') : $this->buildFailed(0,'状态提交失败');

                break;
            case 4://项目上线
                $validate = new Validate([
                    ['project_url', 'require', '项目地址不能为空'],
                ]);
                if (!$validate->check($postData)) {
                    return $this->buildFailed(0,$validate->getError());
                }
                $postData['need_status'] = 5;
                $res = Need::where('id',$postData['id'])->strict(false)->update($postData);

                return $res !== false ? $this->buildSuccess(1,'状态提交成功') : $this->buildFailed(0,'状态提交失败');

                break;
            case 5://项目验收

                $postData['need_status'] = 6;
                $res = Need::where('id',$postData['id'])->strict(false)->update($postData);

                return $res !== false ? $this->buildSuccess(1,'提交成功') : $this->buildFailed(0,'提交失败');


                break;
            case 6:
               echo '暂无';

                break;
        }


    }

    /**
     * @author fyk
     * 软件/定制开发满意度调查表
     * @return array
     * @return int 2非常不满意 4不满意 6一般 8满意 10非常满意
     * @throws \think\exception\DbException
     */
    public function investigation()
    {
        $request=Request::instance();
        $param=$request->param();

        $validate = new Validate([
            ['order_id', 'require', '订单号不能为空'],
        ]);

        if (!$validate->check($param)) {
            return $this->buildFailed(0,$validate->getError());
        }
        $order = NeedScore::get(['order_id'=>$param['order_id']]);
        //if(!$order)returnJson(0,'订单有误');
        $order['total'] = $order['satisfied'] + $order['satisfy'] + $order['reliable'] + $order['easy']
            + $order['beautiful'] + $order['serve'] + $order['knowledge'] + $order['response'] + $order['complaint'] + $order['sale'];

        return $order !== false ? $this->buildSuccess(['data'=> $order,]) : $this->buildFailed(0,'失败');
    }

}
