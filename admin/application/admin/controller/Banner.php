<?php
/**
 * Created by PhpStorm.
 * User: PHP
 * Date: 2019/10/8
 * Time: 16:05
 */
namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;

class Banner extends Base {

    /**
     * @function banner列表
     * @param str type_id    类型
     * @param str page       当前页
     * @param str size       每页个数
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

        $field = 'id,title,img,url';
        $order = 'id desc';

        $count = Db::table('banner')->where($where)->count();
        $list = Db::table('banner')->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();

        return $this->buildSuccess([
            'count'=>$count,
            'list'=>$list,
        ]);
    }

    /**
     * @function banner添加
     */
    public function add(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'title'=>'require',
            'img'=>'require',
            'url'=>'require',
        ];
        $message = [
            'title.require'=>'名称不能为空',
            'img.require'=>'请上传图片',
            'url.require'=>'外链地址不能为空',

        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['created_at'] = time();
        $result = Db::table('banner')->insert($param);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * @function banner修改
     */
    public function edit(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
            'title'=>'require',
            'img'=>'require',
            'url'=>'require',
        ];
        $message = [
            'id.require'=>'请选择数据',
            'title.require'=>'名称不能为空',
            'img.require'=>'请上传图片',
            'url.require'=>'外链地址不能为空',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }
        $param['updated_at'] = time();
        $result = Db::table('banner')->update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * @function banner删除
     * @param str id 主键
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

        $info = Db::table('banner')->find($param['id']);
        if(empty($info)){
            return $this->buildFailed(0,'数据不存在');
        }

        $result = Db::table('banner')->where('id',$param['id'])->delete();
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }


}