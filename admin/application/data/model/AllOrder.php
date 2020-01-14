<?php

namespace app\data\model;

use think\Model;

class AllOrder extends Model
{
    protected $table = "all_order";
    protected $resultSetType = 'collection';
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';

    /**
     * 城市合伙人
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function order_list($param)
    {
        $type = $param['type'];
        switch($type) {
            case 1://城市累计会员明细

                $where['city_id'] = $param['cid'];
                $where['payment'] = 2;
                if(!empty($param['title'])){
                    $where['phone'] = ['like','%'.$param['title'].'%'];
                }

                if(!empty($param['start_time'])){
                    $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
                    $where['created_at'] = ['gt',$param['start_time']];
                }
                if(!empty($param['end_time'])){
                    $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
                    $where['created_at'] = ['lt',$param['end_time']];
                }
                if(!empty($param['start_time']) && !empty($param['end_time'])){
                    $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
                }
                if(empty($param['page'])){
                    $param['page'] = 1;
                }
                if(empty($param['size'])){
                    $param['size'] = 10;
                }
                $field = 'id,phone,ot_yqm,entry_name,money,bottom_money,reach_money,created_at';
                $order = 'id desc';

                $user = new AllOrder();
                $list = $user -> field( $field ) -> where( $where ) -> order( $order )
                    -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

                return $list;

                break;
            case 2://我邀请的会员明细

                $where['ot_yqm'] = $param['invitation'];
                $where['payment'] = 2;
                if(!empty($param['title'])){
                    $where['phone'] = ['like','%'.$param['title'].'%'];
                }

                if(!empty($param['start_time'])){
                    $where['created_at'] = ['gt',$param['start_time']];
                }
                if(!empty($param['end_time'])){
                    $where['created_at'] = ['lt',$param['end_time']];
                }
                if(!empty($param['start_time']) && !empty($param['end_time'])){
                    $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
                }
                if(empty($param['page'])){
                    $param['page'] = 1;
                }
                if(empty($param['size'])){
                    $param['size'] = 10;
                }
                $field = 'id,phone,ot_yqm,entry_name,money,bottom_money,reach_money,created_at';
                $order = 'id desc';

                $user = new AllOrder();
                $list = $user -> field( $field ) -> where( $where ) -> order( $order )
                    -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

                return $list;

                break;
            case 3://合伙人入驻订单

                $where['user_id'] = $param['user_id'];
                $where['role_type'] = 2;
                if(!empty($param['title'])){
                    $where['phone'] = ['like','%'.$param['title'].'%'];
                }

                if(!empty($param['start_time'])){
                    $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
                    $where['created_at'] = ['gt',$param['start_time']];
                }
                if(!empty($param['end_time'])){
                    $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
                    $where['created_at'] = ['lt',$param['end_time']];
                }
                if(!empty($param['start_time']) && !empty($param['end_time'])){
                    $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
                }
                if(empty($param['page'])){
                    $param['page'] = 1;
                }
                if(empty($param['size'])){
                    $param['size'] = 10;
                }
                $field = 'id,user_id,role_type,pay_type,money,grade,city_grade,add_time,end_time';
                $order = 'id desc';

                $user = new JoinOrder();
                $list = $user -> field( $field ) -> where( $where ) -> order( $order )
                    -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

                foreach ($list['data'] as $k => $v){
                    //城市
                    $city =  Provinces::province_query($v['grade']);
                    $list['data'][$k]['city_name'] = $city['name'] ?? '申请城市有误';
                    //政策
                    $grade = JoinRole::grade_city($v['city_grade']);
                    $list['data'][$k]['grade_title'] = $grade['policy'] ?? '无';
                }

                return $list;

                break;

        }

    }


    /**
     * 等级会员
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function rank_member($param)
    {
        $type = $param['type'];
        switch ($type) {
            case 1://我邀请会员明细

                $where['ot_yqm'] = $param['invitation'];
                $where['payment'] = 2;
                if (!empty($param['title'])) {
                    $where['phone'] = ['like', '%' . $param['title'] . '%'];
                }

                if (!empty($param['start_time'])) {
                    $where['created_at'] = ['gt', $param['start_time']];
                }
                if (!empty($param['end_time'])) {
                    $where['created_at'] = ['lt', $param['end_time']];
                }
                if (!empty($param['start_time']) && !empty($param['end_time'])) {
                    $where['created_at'] = ['between', [$param['start_time'], $param['end_time']]];
                }
                if (empty($param['page'])) {
                    $param['page'] = 1;
                }
                if (empty($param['size'])) {
                    $param['size'] = 10;
                }
                $field = 'id,phone,ot_yqm,entry_name,money,bottom_money,reach_money,created_at';
                $order = 'id desc';

                $user = new AllOrder();
                $list = $user->field($field)->where($where)->order($order)
                    ->paginate($param['size'], false, array('page' => $param['page']))->toArray();

                return $list;

                break;
            case 2://等级订单

                $where['user_id'] = $param['user_id'];
                $where['role_type'] = 2;
                if (!empty($param['title'])) {
                    $where['phone'] = ['like', '%' . $param['title'] . '%'];
                }

                if (!empty($param['start_time'])) {
                    $param['start_time'] = date('Y-m-d H:i:s', strtotime($param['start_time']));
                    $where['created_at'] = ['gt', $param['start_time']];
                }
                if (!empty($param['end_time'])) {
                    $param['end_time'] = date('Y-m-d H:i:s', strtotime($param['end_time']));
                    $where['created_at'] = ['lt', $param['end_time']];
                }
                if (!empty($param['start_time']) && !empty($param['end_time'])) {
                    $where['created_at'] = ['between', [$param['start_time'], $param['end_time']]];
                }
                if (empty($param['page'])) {
                    $param['page'] = 1;
                }
                if (empty($param['size'])) {
                    $param['size'] = 10;
                }
                $field = 'id,user_id,role_type,pay_type,money,grade,city_grade,add_time,end_time';
                $order = 'id desc';

                $user = new JoinOrder();
                $list = $user->field($field)->where($where)->order($order)
                    ->paginate($param['size'], false, array('page' => $param['page']))->toArray();

                foreach ($list['data'] as $k => $v) {

                    //会员等级
                    $grade = JoinRole::member_details($param['grade']);
                    $list['data'][$k]['grade_title'] = $grade['policy'] ?? '无';
                    $list['data'][$k]['grade_img'] = $grade['img'] ?? '无';
                    $list['data'][$k]['grade_name'] = $grade['title'] ?? '无';
                }

                return $list;

                break;
        }
    }

    /**
     * 分包商
     * @param $param
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function subcontract($param)
    {
        $type = $param['type'];
        switch ($type) {
            case 1://承接的项目明细

                $where['ot_yqm'] = $param['invitation'];
                $where['payment'] = 2;
                if (!empty($param['title'])) {
                    $where['phone'] = ['like', '%' . $param['title'] . '%'];
                }

                if (!empty($param['start_time'])) {
                    $where['created_at'] = ['gt', $param['start_time']];
                }
                if (!empty($param['end_time'])) {
                    $where['created_at'] = ['lt', $param['end_time']];
                }
                if (!empty($param['start_time']) && !empty($param['end_time'])) {
                    $where['created_at'] = ['between', [$param['start_time'], $param['end_time']]];
                }
                if (empty($param['page'])) {
                    $param['page'] = 1;
                }
                if (empty($param['size'])) {
                    $param['size'] = 10;
                }
                $field = 'id,phone,ot_yqm,entry_name,money,bottom_money,reach_money,created_at';
                $order = 'id desc';

                $user = new AllOrder();
                $list = $user->field($field)->where($where)->order($order)
                    ->paginate($param['size'], false, array('page' => $param['page']))->toArray();

                return $list;

                break;
            case 2://分包商入驻订单

                $where['user_id'] = $param['user_id'];
                $where['role_type'] = 3;
                if (!empty($param['title'])) {
                    $where['phone'] = ['like', '%' . $param['title'] . '%'];
                }

                if (!empty($param['start_time'])) {
                    $param['start_time'] = date('Y-m-d H:i:s', strtotime($param['start_time']));
                    $where['created_at'] = ['gt', $param['start_time']];
                }
                if (!empty($param['end_time'])) {
                    $param['end_time'] = date('Y-m-d H:i:s', strtotime($param['end_time']));
                    $where['created_at'] = ['lt', $param['end_time']];
                }
                if (!empty($param['start_time']) && !empty($param['end_time'])) {
                    $where['created_at'] = ['between', [$param['start_time'], $param['end_time']]];
                }
                if (empty($param['page'])) {
                    $param['page'] = 1;
                }
                if (empty($param['size'])) {
                    $param['size'] = 10;
                }
                $field = 'id,user_id,role_type,pay_type,money,dev,created_at';
                $order = 'id desc';

                $user = new JoinOrder();
                $list = $user->field($field)->where($where)->order($order)
                    ->paginate($param['size'], false, array('page' => $param['page']))->toArray();


                return $list;

                break;
        }
    }

    /**
     * 支付成功添加统计订单
     * @param $role_type
     * @param $budget_type
     * @param $data
     * @param $income
     * @return false|int
     */
    public function allorder_add($budget_type,$data,$pay_money,$income)
    {

            $user = (new User())->user_detail($data['user_id']);//查询个人信息
            //判断等级
            if(empty($dev)){
                $dev = '';
            }
            return $this->save([

                'role_type' => $data['type'],
                'budget_type' => $budget_type,
                'user_id' => $user['id'],
                'phone' => $user['phone'],
                'yqm' => $user['invitation'],
                'pay_type' => $data['pay_type'],
                'ot_yqm' => $user['other_code'],
                'entry_name' => $data['name'],
                'no' => $data['no'],
                'money' => $pay_money,
                'income' => $income,
                'payment' => 2,
                'pay_time' => time(),
                'status' => 2,
               // 'bottom_money' => $bottom_money,
               // 'reach_money' => $reach_money,
                'dev' => $dev,
                'grade' => $user['grade'],
                'created_at' => time(),
                'province_id' => $user['province_id'],
                'city_id' => $user['city_id'],
            ]);

    }
}
