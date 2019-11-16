<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/15
 * Time: 9:31
 */
namespace app\admin\controller;

use think\Request;
use think\Db;
use think\Validate;
/**
 * 推广运营
 * Class Extension
 * @package app\admin\controller
 */
class Extension extends Base
{

    /**
     * 主页列表
     * @return array
     */
    public function index(){
        $request = Request::instance();
        $param = $request->param();

        $where['deleted_at'] = null;
        if(!empty($param['name'])){
            $where['name'] = ['like','%'.$param['name'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = '*';
        $order = 'sort asc';

        $count = Db::table('extension')->where($where)->count();
        $list = Db::table('extension')->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();

        return $this->buildSuccess([
            'count'=>$count,
            'list'=>$list,
        ]);
    }

    /**
     * 新增
     * @return array
     */
    public function add(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'name'=>'require',
            'sort'=>'require',
            'price'=>'require',
            'money'=>'require',
            'con'=>'require',
            'status'=>'require|in:0,1',
        ];
        $message = [
            'name.require'=>'请填写名称',
            'sort.require'=>'请填写排序',
            'price.require'=>'请填写原价',
            'money.require'=>'请填写划线价',
            'con.require'=>'请填写详情',
            'status.require'=>'请选择状态',
            'status.in'=>'状态选择错误',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        Db::startTrans();
        try{
            $param['created_at'] = time();
            Db::table('extension')->insert($param);
            Db::commit();
            return $this->buildSuccess([]);
        }catch(\Exception $e){
            Db::rollback();
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 修改
     * @return array
     */
    public function upd(){
        $request = Request::instance();
        $param = $request->param();
        $rules = [
            'name'=>'require',
            'sort'=>'require',
            'price'=>'require',
            'money'=>'require',
            'con'=>'require',
            'status'=>'require|in:0,1',
        ];
        $message = [
            'name.require'=>'请填写名称',
            'sort.require'=>'请填写排序',
            'price.require'=>'请填写原价',
            'money.require'=>'请填写划线价',
            'con.require'=>'请填写详情',
            'status.require'=>'请选择状态',
            'status.in'=>'状态选择错误',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        Db::startTrans();
        try{
            $param['updated_at'] = time();

            Db::table('extension')->update($param);
            Db::commit();
            return $this->buildSuccess([]);
        }catch(\Exception $e){
            Db::rollback();
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * @function 删除
     * @param str id 主键
     */
    public function del(){
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id'=>'require',
        ];
        $message = [
            'id.require'=>'请选择数据',
        ];
        $validate = new Validate($rules,$message);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());
        }

        $info = Db::table('extension')->find($param['id']);

        if(empty($info)){
            return $this->buildFailed(0,'数据不存在');
        }else{
            if($info['deleted_at'] !== null){
                return $this->buildFailed(0,'数据已删除');
            }
        }

        Db::startTrans();
        try{
            $param['deleted_at'] = time();
            Db::table('extension')->update($param);
            Db::commit();
            return $this->buildSuccess([]);
        }catch(\Exception $e){
            Db::rollback();
            return $this->buildFailed(0,'操作失败');
        }
    }

}
