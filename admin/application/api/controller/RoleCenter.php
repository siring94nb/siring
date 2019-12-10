<?php

namespace app\api\controller;
use app\data\model\JoinOrder;
use app\data\model\AllOrder;
use app\data\model\Provinces;
use think\Controller;
use think\Request;
use app\data\model\User;
use think\Session;

class RoleCenter extends Controller
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
                            $data = $order ->where(['user_id'=>$user_data['id'],'role_type'=>2]) -> field('id,grade,end_time') ->find();
                            $city = Provinces::province_query($data['grade']);
                            $data['name'] = $city['name'];

                        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
                    }else{
                        returnJson(0,'亲，您暂时还不是城市合伙人，赶紧去申请吧！');
                    }
                }else{
                    returnJson(0,'请登录');
                }


                break;
            case 2://会员

                $uid = Session::get("uid");
                if($uid){
                    $user_data = User::where('id',$uid)->find()->toarray();

                    if($user_data['type'] != 0){

                        $order = new JoinOrder();
                        $data = $order ->where(['user_id'=>$user_data['id'],'role_type'=>1]) -> field('id,grade,end_time') ->find();
                        $data['name'] = $user_data['grade'] == 1 ?'金牌会员' :($user_data['grade'] == 2 ?'钻石会员' : $user_data['grade'] == 3 ? '皇冠会员':'普通会员');

                        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
                    }else{
                        returnJson(0,'亲，您暂时还不是等级会员，赶紧去申请吧！');
                    }
                }else{
                    returnJson(0,'请登录');
                }

                break;
            case 3://分包商

                $uid = Session::get("uid");
                if($uid){
                    $user_data = User::where('id',$uid)->find()->toarray();

                    if($user_data['type'] = 2){

                        $order = new JoinOrder();
                        $data = $order ->where(['user_id'=>$user_data['id'],'role_type'=>3]) -> field('id,dev,end_time') ->find();
                        $data['name'] = json_decode($data['dev'],true);
                        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
                    }else{
                        returnJson(0,'亲，您暂时还不是分包商，赶紧去申请吧！');
                    }
                }else{
                    returnJson(0,'请登录');
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
                returnJson(0,'请登录');
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
            returnJson(0,'请登录');
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
            returnJson(0,'请登录');
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
            returnJson(0,'请登录');
        }

    }


}
