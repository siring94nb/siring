<?php

namespace app\api\controller;
use app\data\model\JoinOrder;
use app\data\model\AllOrder;
use app\data\model\Provinces;
use app\data\model\Subcontract;
use think\Request;
use app\data\model\User;
use think\Session;
use think\Validate;
use think\Db;
class RoleCenter extends Base
{

    /**
     * 个人提示状态
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function tips()
    {
        $request = Request::instance();
        $param = $request->param();
        $type = $param['type'];
        switch($type) {
            case 1://城市
                $uid = Session::get("uid");
                if($uid){
                    $user_data = User::where('id',$uid)->find()->toarray();

                    if($user_data['type'] = 2){

                            $order = new JoinOrder();
                            $data = $order ->where(['user_id'=>$user_data['id'],'type'=>2]) -> field('id,city_id,end_time') ->find();
                            $city = Provinces::province_query($data['city_id']);
                            $data['name'] = $city['name'];

                        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
                    }else{
                        returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');
                    }
                }else{
                    returnJson(3,'请登录');
                }


                break;
            case 2://会员

                $uid = Session::get("uid");
                if($uid){
                    $user_data = User::where('id',$uid)->find()->toarray();

                    if($user_data['type'] != 0){

                        $order = new JoinOrder();
                        $data = $order ->where(['user_id'=>$user_data['id'],'type'=>1]) -> field('id,grade,end_time') ->find();
                        $data['name'] = $user_data['grade'] == 1 ?'金牌会员' :($user_data['grade'] == 2 ?'钻石会员' : $user_data['grade'] == 3 ? '皇冠会员':'普通会员');

                        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
                    }else{
                        returnJson(0,'亲，您暂时还不是等级会员，赶紧去申请吧！');
                    }
                }else{
                    returnJson(3,'请登录');
                }

                break;
            case 3://分包商

                $uid = Session::get("uid");
                if($uid){
                    $user_data = User::where('id',$uid)->find()->toarray();

                    if($user_data['type'] = 2){

                        $order = new JoinOrder();
                        $data = $order ->where(['user_id'=>$user_data['id'],'type'=>3]) -> field('id,dev,end_time') ->find();
                        $data['name'] = json_decode($data['dev'],true);
                        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
                    }else{
                        returnJson(0,'亲，您暂时还不是分包商，赶紧去申请吧！');
                    }
                }else{
                    returnJson(3,'请登录');
                }
                break;
        }
    }

    /**
     * 合伙人列表
     */
    public function city_partner()
    {
        $request = Request::instance();
        $param = $request->param();
        $uid = Session::get("uid");
        if($uid){
            $user_data = User::where('id',$uid)->find()->toarray();
            $param['cid'] = $user_data['city_id'];
            $param['invitation'] = $user_data['invitation'];
            $param['user_id'] = $user_data['id'];
            if($user_data['type'] = 2){

                $order = new AllOrder();
                $data = $order->order_list($param);

                return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
            }else{
                returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');
            }
        }else{
            returnJson(3,'请登录');
        }


    }

    /**
     *城市合伙人会员总计
     */
    public function city_total()
    {

        $uid = Session::get("uid");
        if($uid){
        $user_data = User::where('id',$uid)->find()->toarray();
        if($user_data['is_city'] === 2){
            returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');exit();
        }
        $data['city_user_total'] = User::where('province_id',$user_data['province_id']) ->count();//城市累计会员总数
        $data['bottom_money_total'] = AllOrder::where('province_id',$user_data['province_id']) ->sum('bottom_money');//保底佣金总数
        $data['invite_user_total'] = User::where('other_code',$user_data['invitation']) ->count();//我邀请的会员总数
        $data['reach_user_total'] = AllOrder::where('province_id',$user_data['province_id']) ->sum('reach_money');//城市达标佣金总数

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

        }else{
            returnJson(3,'请登录');
        }

    }

    /**
     * 等级会员列表
     */
    public function member_partner()
    {
        $request = Request::instance();
        $param = $request->param();
        $uid = Session::get("uid");
        if($uid){
            $user_data = User::where('id',$uid)->find()->toarray();
            $param['invitation'] = $user_data['invitation'];
            $param['user_id'] = $user_data['id'];
            $param['grade'] = $user_data['grade'];
            if($user_data['type'] = 2){

                $order = new AllOrder();
                $data = $order->rank_member($param);

                return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
            }else{
                returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');
            }
        }else{
            returnJson(3,'请登录');
        }


    }

    /**
     *等级会员会员总计
     */
    public function member_total()
    {

        $uid = Session::get("uid");
        if($uid){
            $user_data = User::where('id',$uid)->find()->toarray();
            if($user_data['is_city'] === 2){
                returnJson(0,'亲，您暂时还不是身份会员，赶紧去申请吧！');exit();
            }
            $data['invite_user_total'] = User::where('other_code',$user_data['invitation']) ->count();//我邀请的会员总数
            $data['reach_user_total'] = AllOrder::where('ot_yqm',$user_data['invitation']) ->sum('bottom_money');//保底佣金总数

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

        }else{
            returnJson(3,'请登录');
        }

    }

    /**
     * 分包商列表
     */
    public function subcontract_partner()
    {
        $request = Request::instance();
        $param = $request->param();
        $uid = Session::get("uid");
        if($uid){
            $user_data = User::where('id',$uid)->find()->toarray();
            $param['user_id'] = $user_data['id'];
            $param['invitation'] = $user_data['other_code'];
            if($user_data['type'] = 2){

                $order = new AllOrder();
                $data = $order->subcontract($param);

                return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
            }else{
                returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');
            }
        }else{
            returnJson(3,'请登录');
        }


    }

    /**
     *分包商总计
     */
    public function subcontract_total()
    {

        $uid = Session::get("uid");
        if($uid){
            $user_data = User::where('id',$uid)->find()->toarray();
            if($user_data['is_city'] === 2){
                returnJson(0,'亲，您暂时还不是身份会员，赶紧去申请吧！');exit();
            }
            $data['invite_user_total'] = User::where('other_code',$user_data['invitation']) ->count();//佣金总数
            $data['reach_user_total'] = (new JoinOrder())::where('user_id',$user_data['id']) ->sum('money');//押金总数

            return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);

        }else{
            returnJson(3,'请登录');
        }

    }

    /**
     *分包项目视窗
     */
    public function sub_view()
    {
        $request = Request::instance();
        $param = $request->param();
        $uid = Session::get("uid");
        if($uid){
            $user_data = User::where('id',$uid)->find()->toarray();
            if($user_data['is_city'] === 2){
                returnJson(0,'亲，您暂时还不是身份会员，赶紧去申请吧！');exit();
            }
            if (empty($param['page'])) {
                $param['page'] = 1;
            }
            if (empty($param['size'])) {
                $param['size'] = 1;
            }

            $field = 'id,name,dev,con,type,created_at';
            $order = 'id desc';

            $join_order = (new \app\data\model\Subcontract()) -> field( $field ) -> where( ['type'=>0,'status'=>0 ]) -> order( $order )
                -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

            foreach ($join_order['data'] as $k =>$v){
                $jurl = htmlspecialchars_decode($v['con']);
                $join_order['data'][$k]['con'] = $jurl;
            }

            return $join_order ? returnJson(1,'获取成功',$join_order) : returnJson(0,'获取失败',$join_order);

        }else{
            returnJson(3,'请登录');
        }

    }

    /**
     * 接单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function receipt()
    {
        $request = Request::instance();
        $param = $request->param();
        //pp($param);die;
        $uid = Session::get("uid");
        if($uid){
            $validate = new Validate([
                ['xid', 'require', '项目id不能为空'],
                ['phone', 'require', '类型不能为空'],
            ]);
            if(!$validate->check($param)){
                returnJson (0,$validate->getError());exit();
            }
            $sub = Subcontract::where('id',$param['xid'])->find();
            if($sub['status'] == 1){
                returnJson(0,'该项目已被接，请看看其他单');exit();
            }
            $count = Subcontract::where('phone',$param['phone'])->count();
            if($count > 1){
                returnJson(0,'每人只能项目中只能接两单哦！');exit();
            }
            Db::startTrans();
            try {
                $param['status'] = 1;
                $param['no'] = 'RS'.date('YmdHi').rand(100000, 999999);
                (new Subcontract())->allowField(true)->save($param,['id'=>$param['xid']]);

                Db::commit();
                return returnJson(1,'接单成功');exit();
            } catch (\Exception $e) {
                Db::rollback();
                return returnJson(0,'接单失败');exit();
            }
        }else{
            returnJson(3,'请登录');
        }
    }


}
