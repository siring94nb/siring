<?php

namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;

class Honor extends Base
{
    /**
     * 荣誉列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(){
        $request = Request::instance();
        $param = $request->param();

        $where = array();
        $where['type'] = 2;
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'id,title,img,created_at,updated_at';
        $order = 'id desc';

        $count = (new \app\data\model\Banner()) ->where($where)->count();

        $list = (new \app\data\model\Banner()) ->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();

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
            'title'=>'require',
            'img'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'img.require'=>'请上传图片',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['created_at'] = time();
        $param['type'] = 2;
        $result = (new \app\data\model\Banner())->insert($param);
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
            'title'=>'require',
            'img'=>'require',
        ];
        $message = [
            'id.require'=>'请选择数据',
            'title.require'=>'名称不能为空',
            'img.require'=>'请上传图片',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['updated_at'] = time();
        $result = (new \app\data\model\Banner())->update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 删除
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
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

        $info = (new \app\data\model\Banner())::get($param['id']);
        if(empty($info)){
            return $this->buildFailed(0,'数据不存在');
        }

        $result = (new \app\data\model\Banner())::destroy($param['id']);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }
}
