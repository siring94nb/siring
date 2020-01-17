<?php

namespace app\admin\controller;
use app\data\model\Member as MemberAll;
use app\data\model\Suggest;
use think\Controller;
use think\Request;
use think\Validate;

class Message extends Base
{
    /**
     * 留言列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        $request = Request::instance();
        $param = $request->param();

        $where = array();

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'a.id,a.user_id,a.con,a.imgs,a.is_accept,a.created_at,a.updated_at,b.realname as name';
        $order = 'a.id desc';

        $list = (new Suggest())
            ->alias('a')->join('user b','a.user_id=b.id','left')
            -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $this -> buildSuccess( array(
            'list' => $list['data'],
            'count' => $list['total'],
        ) );
    }


    /**
     * 修改
     * @return mixed
     */
    public function edit(){

        $request = Request::instance();
        $param = $request->param();
        $rules = [
            'id'=>'require',
            'is_accept'=>'require',

        ];
        $message = [
            'id.require'=>'请选择数据',
            'is_accept.require'=>'判断不能为空',

        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['updated_at'] = time();
        $result = (new Suggest())->update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 删除
     * @return array
     * @throws \think\exception\DbException
     */
    public function del(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
        ];
        $message = [
            'id.require'=>'请选择数据ID',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        $info = MemberAll::get($param['id']);
        if(empty($info)){
            return $this->buildFailed(0,'数据不存在');
        }

        $result = MemberAll::destroy($param['id']);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }
}
