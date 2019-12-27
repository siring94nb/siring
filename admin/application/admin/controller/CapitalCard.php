<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/27
 * Time: 16:22
 */
namespace app\admin\controller;
use app\data\model\Offline;
use think\Request;
use think\Db;
use think\Validate;

class CapitalCard extends Base
{

    /**
     * 线下订单审核
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();

        $where['del_time'] = null;

        if (!empty($param['name'])) {
            $where['name'] = ['like', '%' . $param['name'] . '%'];
        }

        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (empty($param['size'])) {
            $param['size'] = 10;
        }

        $field = '*';
        $order = 'id asc';

        $list = ( new Offline()) -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();


        return $this -> buildSuccess( array(
            'list' => $list['data'],
            'count' => $list['total'],
        ) );

    }
}
