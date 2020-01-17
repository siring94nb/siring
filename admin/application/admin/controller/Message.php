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

        $field = 'id,user_id,con,img,is_accept,created_at,updated_at';
        $order = 'id desc';

        $count = (new Suggest()) ->where($where)->count();

        $list = (new Suggest()) ->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();

        return $this->buildSuccess([
            'count'=>$count,
            'list'=>$list,
        ]);
    }

    /**
     * 添加
     * @return mixed
     */
    public function add(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'name'=>'require',
            'position'=>'require',
            'img'=>'require',
            'con'=>'require',
        ];
        $message = [
            'name.require'=>'名称不能为空',
            'position.require'=>'职位不能为空',
            'img.require'=>'请上传图片',
            'con.require'=>'内容不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['created_at'] = time();
        $count = (new Suggest())->count();
        if($count > 9){
            return $this->buildFailed(0,'添加成员不能超过10个');exit();
        }
        $result = (new Suggest())->insert($param);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
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
            'name'=>'require',
            'position'=>'require',
            'img'=>'require',
            'con'=>'require',
        ];
        $message = [
            'id.require'=>'请选择数据',
            'name.require'=>'名称不能为空',
            'position.require'=>'职位不能为空',
            'img.require'=>'请上传图片',
            'con.require'=>'内容不能为空',
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
