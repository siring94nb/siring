<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/8
 * Time: 14:24
 */
namespace app\admin\controller;
use app\data\model\InvestmentProject;
use app\data\model\Message;
use app\data\model\PromotionOrder;
use think\Request;
use think\Db;
use think\Validate;

/**
 * 投融列表
 * @author fyk
 * Class Receipt
 * @package app\admin\controller
 */
class Investment extends Base
{
    /**
     * 订单列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $where['a.type'] = 6;
        if(!empty($param['process'])){
            $where['a.need_status'] = $param['process'];

        }
        if(!empty($param['title'])){
            $where['a.name|a.no'] = ['like','%'.$param['title'].'%'];
        }

        if(!empty($param['type'])){
            $where['a.type'] = $param['type'];
        }

        if(!empty($param['start_time'])){
            $where['a.created_at'] = ['gt',$param['start_time']];
        }

        if(!empty($param['end_time'])){
            $where['a.created_at'] = ['lt',$param['end_time']];
        }

        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['a.created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 6;
        }

        $field = 'a.id,a.model_type,a.name,a.user_id,a.sid,a.resume,a.surplus,a.created_at,a.need_status,b.title,c.realname,c.phone';
        $order = 'a.id desc';

        $list = (new InvestmentProject())
            ->alias('a')->join('investment_class b','a.sid=b.id','left')
            ->join('user c','a.user_id = c.id','left')
            -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $k => $v){
            $msg1 = Message::OfficialNews($v['id'],1);
            $list['data'][$k]['admin_msg'] = $msg1['content'];

            $msg2 = Message::OfficialNews($v['id'],0);
            $list['data'][$k]['user_msg'] = $msg2['content'];

        }
        return $this -> buildSuccess( array(
            'list' => $list['data'],
            'count' => $list['total'],
        ) );
    }

    /**
     * 订单详情
     * @param $order_id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        $need_detail = (new InvestmentProject())->details($order_id);

        return  $need_detail ? $this->buildSuccess(['data'=>$need_detail]): $this->buildFailed(ReturnCode::DB_READ_ERROR,'操作失败');

    }
}
