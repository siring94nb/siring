<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/22
 * Time: 10:31
 */
namespace app\admin\controller;

use app\data\model\InvestmentClass;
use app\data\model\InvestmentSet;
use think\Request;
use think\Validate;

/**
 * @author fyk
 * Class Setup
 * @package app\admin\controller
 */
class Setup extends Base{

    /**
     * 投融设置列表
     * @return array
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();
        $where =[];
        if(!empty($param['name'])){
            $where['b.title'] = ['like','%'.$param['name'].'%'];
        }

        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }

        $field = 'a.id,a.cost,a.reward,a.cid,b.title';
        $order = 'a.id desc';

        $list = (new InvestmentSet())->alias('a')->join('investment_class b','a.cid=b.id')
            ->field($field) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $this->buildSuccess([
            'list' => $list['data'],
            'count' => $list['total'],
        ]);


    }

    /**
     * 投融设置新增
     * @return array
     */
    public function add(){
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['cost','require|number','发布费用不能为空|费用必须为数字'],
            ['reward','require|number','赏金不能为空|赏金必须为数字'],
            ['cid','require|unique:InvestmentSet','分类不能为空|当前分类已存在'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        $param['created_at'] = time();
        $result = InvestmentSet::create($param);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 投融设置修改
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function upd(){
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id', 'require', '缺少必要参数ID'],
            ['cost','require|number','发布费用不能为空|费用必须为数字'],
            ['reward','require|number','赏金不能为空|赏金必须为数字'],
            ['cid','require|unique:InvestmentSet','分类不能为空|当前分类已存在'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        $param['updated_at'] = time();
        $result = InvestmentSet::update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 投融设置删除
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

        $result = InvestmentSet::destroy($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 行业分类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function category_index(){

        $list = (new InvestmentClass())->select();
        return $this->buildSuccess([
            'list'=>$list,
        ]);
    }


    /**
     * 行业分类新增
     * @return array
     */
    public function category_add(){
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['title','require','分类名称不能为空'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        $param['created_at'] = time();
        $result = InvestmentClass::create($param);
        if($result){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

    /**
     * 行业分类修改
     * @return array
     */
    public function category_upd(){
        $request = Request::instance();
        $param = $request->param();
        $validate = new Validate([
            ['id', 'require', '缺少必要参数ID'],
            ['title','require','分类名称不能为空'],
        ]);
        if(!$validate->check($param)){
            return $this->buildFailed(0,$validate->getError());exit();
        }
        $param['updated_at'] = time();
        $result = InvestmentClass::update($param);
        if($result !== false){
            return $this->buildSuccess([]);
        }else{
            return $this->buildFailed(0,'操作失败');
        }
    }

}
