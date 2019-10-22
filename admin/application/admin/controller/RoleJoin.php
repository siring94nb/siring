<?php

namespace app\admin\controller;
use app\data\model\Provinces;
use app\data\model\JoinRole;
use think\Controller;
use think\Request;
use think\Validate;

/**
 * 角色加盟
 * Class RoleJoin
 * @package app\admin\controller
 */
class RoleJoin extends Base
{
    /**
     * 会员等级设置列表
     * @author fyk
     * @return array
     * @throws \think\exception\DbException
     */
    public function member_index()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 1 ;

        $partner = new JoinRole();

        $data = $partner->join_list($param);

        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

    /**
     * 会员等级设置新增
     * @author fyk
     * @return \think\Response
     */
    public function member_create()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'title'=>'require',
            'img'=>'require',
            'term'=>'require',
            'money'=>'require',
            'policy'=>'require',
            'discount'=>'require',
            'royalty'=>'require',
            'is_hide'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'img.require'=>'图片不能为空',
            'term.require'=>'有效期不能为空',
            'money.require'=>'费用不能为空',
            'policy.require'=>'等级政策不能为空',
            'discount.require'=>'折扣不能为空',
            'royalty.require'=>'提成不能为空',
            'is_hide.require'=>'显示不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['type'] = 1 ;
        $param['created_at'] = time() ;

        // 储存
        $result = (new JoinRole()) ->allowField(true)-> save($param);

        return $result  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );


    }

    /**
     * 会员等级设置修改
     * @param Request $request
     * @return array
     * @throws \think\exception\DbException
     */
    public function member_save()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
            'title'=>'require',
            'img'=>'require',
            'term'=>'require',
            'money'=>'require',
            'policy'=>'require',
            'discount'=>'require',
            'royalty'=>'require',
            'is_hide'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'img.require'=>'图片不能为空',
            'term.require'=>'有效期不能为空',
            'money.require'=>'费用不能为空',
            'policy.require'=>'等级政策不能为空',
            'discount.require'=>'折扣不能为空',
            'royalty.require'=>'提成不能为空',
            'is_hide.require'=>'显示不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['type'] = 1 ;
        $param['updated_at'] = time() ;
        // 储存
        $result = (new JoinRole()) ->allowField(true) ->save($param,['id'=>$param['id']]);

        return $result  !== false  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
    }

    /**
     * 会员等级设置状态
     * @return array
     * @throws \think\exception\DbException
     */
    public function member_read()
    {
        $request = Request::instance();
        $param = $request->param();

        if(!$param['id'])returnJson(0,'ID不能为空');
        if(!$param['is_hide'])returnJson(0,'状态参数不能为空');

        if( $param['is_hide'] == 1 ){
            $update_date = [
                'is_hide' => 2,
            ];
        }else{
            $update_date = [
                'is_hide' => 1,
            ];
        }

        $result = (new JoinRole()) ->save($update_date,['id'=>$param['id']]);

        return $result  !== false  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
    }


    /**
     * 会员等级设置删除
     * @param  int  $id
     * @return \think\Response
     */
    public function member_delete()
    {
        $id = $this->request->post('id');

        $res = JoinRole::join_del($id);

        return $res  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );

    }

    /**
     * 合伙人设置列表
     * @author fyk
     * @return array
     * @throws \think\exception\DbException
     */
    public function partner_index()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 2 ;

        $partner = new JoinRole();

        $data = $partner->join_list($param);

        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

    /**
     * 合伙人设置新增
     * @author fyk
     * @return \think\Response
     */
    public function partner_create()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'title'=>'require',
            'money'=>'require',
            'policy'=>'require',
            'forecast'=>'require',
            'bottom_commission'=>'require',
            'standard_commission'=>'require',
            'standard_num'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'money.require'=>'费用不能为空',
            'policy.require'=>'等级政策不能为空',
            'forecast.require'=>'收益预测不能为空',
            'bottom_commission.require'=>'保底佣金比例为空',
            'standard_commission.require'=>'达标佣金比例为空',
            'standard_num.require'=>'达标数量为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['type'] = 2 ;

        // 储存
        $join = new JoinRole();
        $res = $join->join_add($param['type'],$param['title'],'','',$param['money'],$param['policy'],
            $param['forecast'],'','', $param['bottom_commission'],$param['standard_commission'],$param['standard_num']);

        return $res  ?   $this -> buildSuccess( [] , '新增成功' ) :  $this -> buildFailed( 1001 , '新增失败' );
    }

    /**
     * 合伙人设置修改
     * @param Request $request
     * @return array join_upd
     * @throws \think\exception\DbException
     */
    public function partner_save()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
            'title'=>'require',
            'money'=>'require',
            'policy'=>'require',
            'forecast'=>'require',
            'bottom_commission'=>'require',
            'standard_commission'=>'require',
            'standard_num'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'money.require'=>'费用不能为空',
            'policy.require'=>'等级政策不能为空',
            'forecast.require'=>'收益预测不能为空',
            'bottom_commission.require'=>'保底佣金比例为空',
            'standard_commission.require'=>'达标佣金比例为空',
            'standard_num.require'=>'达标数量为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        $param['type'] = 2 ;
        // 储存
        $join = new JoinRole();
        $res = $join->join_upd($param['id'],$param['type'],$param['title'],'','',$param['money'],$param['policy'],
            $param['forecast'],'','', $param['bottom_commission'],$param['standard_commission'],$param['standard_num']);

        return $res  !== false ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
    }



    /**
     * 合伙人设置删除
     * @param  int  $id
     * @return \think\Response
     */
    public function partner_delete()
    {
        $id = $this->request->post('id');

        $res = JoinRole::join_del($id);

        return $res  ?   $this -> buildSuccess( [] , '删除成功' ) :  $this -> buildFailed( 1001 , '删除失败' );
    }

    /**
     * 分包商设置列表
     * @author fyk
     * @return array
     * @throws \think\exception\DbException
     */
    public function subcontractor_index()
    {
        $request = Request::instance();
        $param = $request->param();
        $param['type'] = 3 ;

        $partner = new JoinRole();

        $data = $partner->join_list($param);

        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

    /**
     * 分包商设置新增
     * @author fyk
     * @return \think\Response
     */
    public function subcontractor_create()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'title'=>'require',
            'money'=>'require',
            'policy'=>'require',
            'forecast'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'money.require'=>'费用不能为空',
            'policy.require'=>'开发语言不能为空',
            'forecast.require'=>'收益预测不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['type'] = 3;

        // 储存
        $join = new JoinRole();
        $res = $join->join_add($param['type'],$param['title'],'','',$param['money'],$param['policy'],
            $param['forecast'],'','', '','','');

        return $res  ?   $this -> buildSuccess( [] , '新增成功' ) :  $this -> buildFailed( 1001 , '新增失败' );
    }

    /**
     * 分包商设置修改
     * @param Request $request
     * @return array
     * @throws \think\exception\DbException
     */
    public function subcontractor_save()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
            'title'=>'require',
            'money'=>'require',
            'policy'=>'require',
            'forecast'=>'require',
            'bottom_commission'=>'require',
            'standard_commission'=>'require',
            'standard_num'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'money.require'=>'费用不能为空',
            'policy.require'=>'等级政策不能为空',
            'forecast.require'=>'收益预测不能为空',
            'bottom_commission.require'=>'保底佣金比例为空',
            'standard_commission.require'=>'达标佣金比例为空',
            'standard_num.require'=>'达标数量为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['type'] = 3 ;

        // 储存
        $join = new JoinRole();
        $res = $join->join_upd($param['id'],$param['type'],$param['title'],'','',$param['money'],$param['policy'],
            $param['forecast'],'','', '','','');

        return $res  !== false ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
    }


    /**
     * 分包商设置删除
     * @param  int  $id
     * @return \think\Response
     */
    public function subcontractor_delete()
    {
        $id = $this->request->post('id');

        $res = JoinRole::join_del($id);

        return $res  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );

    }

    /**
     * 等级城市省份列表
     * @author fyk
     * @return \think\Response
     */
    public function city_index()
    {
        $province = new Provinces();
        $data = $province->province_index();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 城市合伙人省份列表
     * @author fyk
     * @return \think\Response
     */
    public function city_create()
    {
        $request = Request::instance();
        $param = $request->param();

        $city = new Provinces();

        $data = $city->city_add($param);

        return $data ? returnJson(1,'成功') : returnJson(0,'失败');
    }
}
