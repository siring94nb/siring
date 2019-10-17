<?php

namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;

class Msg extends Base {

	/**
	* @function 消息列表
	* @param str type       类型：0系统消息；1订单发货；2收货签收；3退货通知；4会员升级；5提现到账；6公告消息
	* @param str nickname   昵称
	* @param str con        内容
	* @param str start_time 开始时间
	* @param str end_time   结束时间
	* @param str page       当前页
	* @param str size       每页个数
	*/
	public function index(){
		$request = Request::instance();
		$param = $request->param();

		$where['a.deleted_at'] = null;
		$where['b.deleted_at'] = null;
		if($param['type'] != ''){
			if($param['type'] != 100){
				$where['a.type'] = $param['type'];
			}
		}
		if(!empty($param['nickname'])){
			$where['b.nickname'] = ['like','%'.$param['nickname'].'%'];
		}
		if(!empty($param['con'])){
			$where['a.con'] = ['like','%'.$param['con'].'%'];
		}
		if(!empty($param['start_time'])){
			$param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
			$where['a.created_at'] = ['gt',$param['start_time']];
		}
		if(!empty($param['end_time'])){
			$param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
			$where['a.created_at'] = ['lt',$param['end_time']];
		}
		if(!empty($param['start_time']) && !empty($param['end_time'])){
			$where['a.created_at'] = ['between',[$param['start_time'],$param['end_time']]];
		}

		if(empty($param['page'])){
			$param['page'] = 1;
		}
		if(empty($param['size'])){
			$param['size'] = 10;
		}
		
		$field = 'a.id,a.type,a.user_id,a.con,a.created_at,b.nickname';
		$order = 'a.id desc';

		$count = Db::table('msg')->alias('a')->join('user b','a.user_id=b.id')->where($where)->count();
		$list = Db::table('msg')->alias('a')->join('user b','a.user_id=b.id')->where($where)->field($field)->order($order)->page($param['page'],$param['size'])->select();
		$msg_types = config('msg_types');
		foreach($list as $k=>$v){
			//类型
			$list[$k]['type'] = $msg_types[$v['type']];
		}
		
		return $this->buildSuccess([
            'count'=>$count,
            'list'=>$list,
            'typeList'=>$msg_types,
        ]);
	}

	/**
	* @function 消息添加
	* @param str type  类型：0系统消息；1订单发货；2收货签收；3退货通知；4会员升级；5提现到账；6公告消息
	* @param arr grade 等级（例如：[0,1,2]）
	* @param str con   内容
	*/
	public function add(){
		$request = Request::instance();
		$param = $request->param();

		$rules = [
			'type'=>'require|in:0,1,2,3,4,5,6',
			'grade'=>'require|array',
			'con'=>'require',
		];
		$message = [
			'type.require'=>'请选择类型',
			'type.in'=>'类型格式错误',
			'grade.require'=>'请选择等级',
			'grade.array'=>'等级格式错误',
			'con.require'=>'请填写内容',
		];
		$validate = new Validate($rules,$message);
		if(!$validate->check($param)){
			return $this->buildFailed(0,$validate->getError());
		}

		Db::startTrans();
		try{
			$where = array(
				'grade'=>array('in',$param['grade']),
			);
			$data = Db::table('user_grade')->where($where)->field('user_id')->select();
			if(empty($data)){
				return $this->buildFailed(0,'暂不存在该等级的用户');
			}
			foreach($data as $k=>$v){
				addMsg(0,$v['user_id'],$param['con'],'');
			}
			
			Db::commit();
			return $this->buildSuccess([]);
		}catch(\Exception $e){
			Db::rollback();
			return $this->buildFailed(0,'操作失败');
		}
	}

	/**
	* @function 消息删除
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

		$info = Db::table('msg')->find($param['id']);
		if(empty($info)){
			return $this->buildFailed(0,'数据不存在');
		}else{
			if($info['deleted_at'] !== null){
				return $this->buildFailed(0,'数据已删除');
			}
		}

		Db::startTrans();
		try{
			$update = array(
				'deleted_at'=>date('Y-m-d H:i:s'),
			);
			Db::table('msg')->where(array('id'=>$info['id']))->update($update);

			Db::commit();
			return $this->buildSuccess([]);
		}catch(\Exception $e){
			Db::rollback();
			return $this->buildFailed(0,'操作失败');
		}
	}

}