<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/22
 * Time: 10:31
 */
namespace app\admin\controller;

use app\data\model\InvestmentProject;
use think\Request;
use think\Validate;
use think\Db;
class Testing extends Base{

    /**
     * 投融设置列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();
        $where =[];
        if(!empty($param['name'])){
            $where['a.title'] = ['like','%'.$param['name'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'a.id,a.uid,a.no,a.title,a.cid,a.bright,a.status,a.pay_status,b.phone,c.title as title_class';
        $order = 'a.id desc';

        $list = (new InvestmentProject())->alias('a')->join('user b','a.uid = b.id')
            ->join('investment_class c','a.cid = c.id')
            ->field($field) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $this->buildSuccess([
            'list' => $list['data'],
            'count' => $list['total'],
        ]);


    }
}
