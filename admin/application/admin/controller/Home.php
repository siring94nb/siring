<?php

namespace app\admin\controller;
use think\Request;
use think\Db;

class Home extends Base {
    /**
     * 首页弹窗
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @Author FYK
     */
    public function index(){
		$request = Request::instance();
        $param = $request->param();
        
        $where['a.deleted_at'] = null;
        //$where['b.stock'] != null;
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
		$field = 'a.id,a.name,b.stock';
		$order = 'a.id desc';
		$count = Db::table('goods')->alias('a')->join('goods_sku b','a.id=b.goods_id','inner')->where($where)->count();
        $list = Db::table('goods')->alias('a')->join('goods_sku b','a.id=b.goods_id','inner')->where($where)
        ->field($field)->order($order)->page($param['page'],$param['size'])->select();
		//print_r($list);die;
		$notice = [];
		foreach($list as $k=>$v){
            $box = [];
			//商品数量
            if(!empty($v['stock'])){
                $nums= json_decode($v['stock'] , true );
                //print_r($nums);die;
                if(!empty($nums)){
                    foreach ($nums as $key1 => $val1){
                        //print_r($val1);exit();
                        if(isset($val1['number']) && $val1['number'] < 600){
                            $str = array();//内层循环为空
                            foreach ($val1['data'] as $key2 => $val2){
                                $str[$key2] = $key2.':'." ".$val2;
                            }
                            $arr_atr = join(',',$str);
                            //print_r($nums_arr);die;
                            $box[] = '['.$arr_atr.",数量:".$val1['number'].']';
                        }else{
                            continue;//跳出终止循环
                        }
                    }
                    if(!empty($box)){
                        $notice[$k]['num'] = $v['name'].join(",",$box)."数量不足!";
                        unset($box);
                    }
                }
            }			
		}
		//print_r($notice);die;
		return $this->buildSuccess([
            'count'=>$count,
            'list'=>$notice,
        ]);
	}


}