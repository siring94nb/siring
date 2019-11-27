<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/22
 * Time: 10:31
 */
namespace app\admin\controller;


use app\data\model\Meeting;
use think\Request;
use think\Db;
use think\Validate;

class Schedule extends Base{

    /**
     * 日程安排列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();
        $where =[];
        if(!empty($param['title'])){
            $where['title'] = ['like','%'.$param['name'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'id,title,field_img,img,region,address,cost,upper_num,add_time,end_time,is_rec,sort,status,con';
        $order = 'id desc';

        $list = (new Meeting())->field($field) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        foreach ($list['data'] as $k =>$v){
            $list['data'][$k]['region_address'] = $v['region'].$v['address'];
            $list['data'][$k]['activity_time'] = $v['add_time'].$v['end_time'];
        }

        return $this->buildSuccess([
            'list' => $list['data'],
            'count' => $list['total'],
        ]);


    }

    /**
     * 日程安排新增
     * @return array
     */
    public function add(){
        $request = Request::instance();
        $param = $request->param();
        $param['add_time'] = strtotime($param['add_time']);
        $param['end_time'] = strtotime($param['end_time']);
        $validate = new Validate([
            ['title','require','活动主题不能为空'],
            ['cost','require','费用不能为空'],
            ['region','require','省市区不能为空'],
            ['address','require','详细地址不能为空'],
            ['upper_num','require|number','人数不能为空|人数必须为数字'],
            ['sort','require|number','排序不能为空|排序必须为数字'],
            ['status','require|number','状态不能为空|状态必须为数字'],
            ['add_time','require','开始时间不能为空'],
            ['end_time','require','结束时间不能为空'],
            ['con','require','活动回顾不能为空'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        $param['created_at'] = time();

        $result = Meeting::create($param);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 日程安排修改
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function upd(){
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id', 'require', '缺少必要参数ID'],
            ['title','require','活动主题不能为空'],
            ['cost','require','费用不能为空'],
            ['region','require','省市区不能为空'],
            ['address','require','详细地址不能为空'],
            ['upper_num','require|number','人数不能为空|人数必须为数字'],
            ['sort','require|number','排序不能为空|排序必须为数字'],
            ['status','require|number','状态不能为空|状态必须为数字'],
            ['add_time','require','开始时间不能为空'],
            ['end_time','require','结束时间不能为空'],
            ['con','require','活动回顾不能为空'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        $param['updated_at'] = time();
        $result = Meeting::update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 日程安排删除
     * @return array
     */
    public function del(){
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id', 'require', '缺少必要参数ID'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }

        $result = Meeting::destroy($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

}
