<?php

namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;

class Notice extends Base {

	/**
	* @function 公告列表
	* @param str con        内容
	* @param str start_time 开始时间
	* @param str end_time   结束时间
	* @param str page       当前页
	* @param str size       每页个数
	*/
	public function index(){
		$request = Request::instance();
		$param = $request->param();

		$where['deleted_at'] = null;
		if(!empty($param['con'])){
			$where['con'] = ['like','%'.$param['con'].'%'];
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
		
		$field = 'id,con,type,created_at,updated_at';
		$order = 'id desc';

		$count = Db::table('notice')->where($where)->count();
		$list = Db::table('notice')->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();
		$user_grades = config('user_grades');
		foreach($list as $k=>$v){
			//类型
			$data = json_decode($v['type']);
			$type = '';
			foreach($data as $kk=>$vv){
				$type.= $user_grades[$vv].';';
			}
			$list[$k]['type'] = $type;
			//内容
			$con = strip_tags($v['con']);
			if(mb_strlen($con) > 32){
				$con = mb_substr($con,0,32).'...';
			}
			$list[$k]['con'] = $con;
		}
		
		return $this->buildSuccess([
            'count'=>$count,
            'list'=>$list,
        ]);
	}

	/**
	* @function 公告信息
	* @param str id 主键
	*/
	public function info(){
		$request = Request::instance();
		$param = $request->param();
        //print_r('$param');die;
		if(empty($param['id'])){
			$info = new \ArrayObject();
		}else{
			$info = Db::table('notice')->where(array('id'=>$param['id']))->find();
		}
		
		if(!$info){
			$info = new \ArrayObject();
		}else{
			$user_grades = config('user_grades');
			$type = json_decode($info['type']);
			if(empty($type)){
				$type = array();
			}else{
				$type_name = '';
				foreach($type as $k=>$v){
					$type_name .= $user_grades[$v].';';
				}
				$info['type_name'] = $type_name;
			}
			$info['type'] = $type;
		}

		return $this->buildSuccess([
            'info'=>$info,
        ]);
	}

	/**
	* @function 公告添加
	* @param arr type 类型（例如：[0,1,2]）
	* @param str con  内容
	*/
	public function add(){
		$request = Request::instance();
		$param = $request->param();

		$rules = [
			'type'=>'require|array',
			'con'=>'require',
		];
		$message = [
			'type.require'=>'请选择类型',
			'type.array'=>'类型格式错误',
			'con.require'=>'请填写内容',
		];
		$validate = new Validate($rules,$message);
		if(!$validate->check($param)){
			return $this->buildFailed(0,$validate->getError());
		}

		Db::startTrans();
		try{
			$type = $param['type'];
			//添加公告
			$param['type'] = json_encode($param['type']);
			$param['created_at'] = date('Y-m-d H:i:s');
			$param['updated_at'] = '';
			$param['deleted_at'] = null;
			$id = Db::table('notice')->insertGetId($param);

			//发送消息
			$where = array(
				'grade'=>array('in',$type),
			);
			$data = Db::table('user_grade')->where($where)->field('user_id')->select();
			foreach($data as $k=>$v){
				addMsg(6,$v['user_id'],$param['con'],$id);
			}
			
			Db::commit();
			return $this->buildSuccess([]);
		}catch(\Exception $e){
			Db::rollback();
			return $this->buildFailed(0,'操作失败');
		}
	}

	/**
	* @function 公告修改
	* @param str id   主键
	* @param arr type 类型（例如：[0,1,2]）
	* @param str con  内容
	*/
	public function upd(){
		$request = Request::instance();
		$param = $request->param();

		$rules = [
			'id'=>'require',
			'type'=>'require|array',
			'con'=>'require',
		];
		$message = [
			'id.require'=>'请选择数据',
			'type.require'=>'请选择类型',
			'type.array'=>'类型格式错误',
			'con.require'=>'请填写内容',
		];
		$validate = new Validate($rules,$message);
		if(!$validate->check($param)){
			return $this->buildFailed(0,$validate->getError());
		}

		Db::startTrans();
		try{
			$type = $param['type'];
			//修改公告
			$param['type'] = json_encode($param['type']);
			$param['updated_at'] = date('Y-m-d H:i:s');
			Db::table('notice')->update($param);

			//删除旧消息
			$where = array(
				'type'=>6,
				'data'=>$param['id'],
			);
			$update = array(
				'deleted_at'=>date('Y-m-d H:i:s'),
			);
			Db::table('msg')->where($where)->update($update);
			//添加新消息
			$where = array(
				'grade'=>array('in',$type),
			);
			$data = Db::table('user_grade')->where($where)->field('user_id')->select();
			foreach($data as $k=>$v){
				addMsg(6,$v['user_id'],$param['con'],$param['id']);
			}

			Db::commit();
			return $this->buildSuccess([]);
		}catch(\Exception $e){
			Db::rollback();
			return $this->buildFailed(0,'操作失败');
		}
	}

	/**
	* @function 公告删除
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

		$info = Db::table('notice')->find($param['id']);
		if(empty($info)){
			return $this->buildFailed(0,'数据不存在');
		}else{
			if($info['deleted_at'] !== null){
				return $this->buildFailed(0,'数据已删除');
			}
		}

		Db::startTrans();
		try{
			//删除公告
			$param['deleted_at'] = date('Y-m-d H:i:s');
			Db::table('notice')->update($param);

			//删除消息
			$where = array(
				'type'=>6,
				'data'=>$param['id'],
			);
			$update = array(
				'deleted_at'=>date('Y-m-d H:i:s'),
			);
			Db::table('msg')->where($where)->update($update);

			Db::commit();
			return $this->buildSuccess([]);
		}catch(\Exception $e){
			Db::rollback();
			return $this->buildFailed(0,'操作失败');
		}
	}

}