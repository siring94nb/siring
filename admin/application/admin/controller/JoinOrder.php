<?php

namespace app\admin\controller;
use app\data\model\Provinces;
use think\Request;
use think\Db;
use think\Validate;
use app\data\model\JoinOrder as JoinOrderAll;
use app\data\model\JoinRole;
class JoinOrder extends Base {
	/**
     * 会员订单列表
     * @author fyk
     * @time 2019/10/09
     */
    public function index(){
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 1 ;

        $partner = new JoinOrderAll();

        $data = $partner->join_list($param);
        foreach ($data['data'] as $k => $v){
            $data['data'][$k]['pay_time'] = $v['pay_time'] == null ? '未付款' : date('Y-m-d H:i:s',$v['pay_time']);
            //查询等级
            $grade_name = JoinRole::grade_type($v['city_id']);

            $data['data'][$k]['grade_title'] = $grade_name['title'];
        }
        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }
     /**
     * 订单审核
     * @author fyk
     * @time 2019/10/09
     */
     public function upd()
     {
  		  $id = $this -> request -> post( 'id' , 0 );
          $status = $this -> request -> post( 'status' , 1 );

          $info = Db::table('join_order') -> where('id',$id ) -> find();
          if($info['status'] === 2){
              return $this -> buildSuccess( [] , '当前状态不能更改' );
          } else {
            $update_date = [
              'status' => $status,
              'updated_at' => date( 'Y-m-d H:i:s' )
            ];
            $res = Db::table('join_order') -> where('id',$id ) -> update( $update_date );

            return $res !== false ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );

        }
     }

    /**
     * 城市合伙人订单
     * @return array
     * @throws \think\exception\DbException
     */
    public function partner()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 2 ;

        $partner = new JoinOrderAll();

        $data = $partner->join_list($param);
        foreach ($data['data'] as $k => $v){
            $data['data'][$k]['pay_time'] = $v['pay_time'] == null ? '未付款' : date('Y-m-d H:i:s',$v['pay_time']);
            //查询城市
            $city_name = Provinces::province_query($v['city_id']);
            $data['data'][$k]['city_title'] = $city_name['name'];
        }
        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }


    /**
     * 分包商订单
     * @return array
     * @throws \think\exception\DbException
     */
    public function merchant()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 3 ;

        $partner = new JoinOrderAll();

        $data = $partner->join_list($param);
            foreach ($data['data'] as $k => $v){
                $data['data'][$k]['pay_time'] = $v['pay_time'] == null ? '未付款' : date('Y-m-d H:i:s',$v['pay_time']);
                //查询技能
                $stocks= json_decode( $v['dev'] , true );

                if(!empty($stocks)){
                    $name = [];//外层循环为空
                    foreach ($stocks as $key => $val){
                        $name[] = implode(",", $val);
                    }
                    $res = join('/',$name);
                    $data['data'][$k]['dev_name'] = $res;
                }else{
                    $data['data'][$k]['dev_name'] = "无";
                }

            }
        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

}
