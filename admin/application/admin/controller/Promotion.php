<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/8
 * Time: 11:19
 */
namespace app\admin\controller;
use app\data\model\PromotionOrder;
use think\Request;
use think\Db;
use think\Validate;

/**
 * AI列表
 * @author fyk
 * Class Receipt
 * @package app\admin\controller
 */
class Promotion extends Base
{
    /**
     * 列表管理
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();
        $where['a.type'] = 5 ;

        if (!empty($param['name'])) {
            $where['a.name'] = ['like', '%' . $param['name'] . '%'];
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
        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (empty($param['size'])) {
            $param['size'] = 10;
        }

        $field = 'a.id,a.no,a.name,a.type,a.role_type,a.model_id,a.money,a.order_status,a.user_id,a.created_at,
            b.name as title,c.realname,c.phone';
        $order = 'a.id asc';

        $list = (new PromotionOrder())
            ->alias('a')->join('extension b','a.model_id=b.id','left')
            ->join('user c','a.user_id = c.id','left')
            -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $k=>$v){

            $list['data'][$k]['packagefee'] = $v['title'].':'.$v['money'];

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
        $need_detail = (new PromotionOrder())->details($order_id);

        return  $need_detail ? $this->buildSuccess(['data'=>$need_detail]): $this->buildFailed(ReturnCode::DB_READ_ERROR,'操作失败');

    }

    /**
     * 确认状态
     * @param $order_id
     * @param $status
     * @return array
     */
    public function promotion_status($order_id,$status)
    {
        $data = (new PromotionOrder()) ->status($order_id,$status);

        return $data !== false ? $this->buildSuccess(['data'=> $data,]) : $this->buildFailed(0,'失败');
    }

    /**
     * 上传稿件
     * @param $order_id
     * @param $url
     * @return array
     */
    public function promotion_upd($order_id,$url)
    {
        $data = PromotionOrder::update(['project_url'=>$url],['id'=>$order_id]);

        return $data !== false ? $this->buildSuccess(['data'=> $data,]) : $this->buildFailed(0,'失败');
    }
}
