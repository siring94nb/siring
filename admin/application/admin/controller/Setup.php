<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/22
 * Time: 10:31
 */
namespace app\admin\controller;

use app\data\model\InvestmentSet;
use think\Request;
use think\Db;

/**
 * @author fyk
 * Class Setup
 * @package app\admin\controller
 */
class Setup extends Base{

    public function index()
    {
        $request = Request::instance();
        $param = $request->param();
        $where =[];
        if(!empty($param['title'])){
            $where['b.title'] = ['like','%'.$param['title'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'a.id,a.cost,a.reward,a.cid,b.title';
        $order = 'a.id desc';

        $list = (new InvestmentSet())->alias('a')->join('investment_class b','a.cid=b.id')
            ->field($field) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $this->buildSuccess([
            'list' => $list['data'],
            'count' => $list['total'],
        ]);


    }

}
