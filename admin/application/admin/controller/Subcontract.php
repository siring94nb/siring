<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/12/13
 * Time: 11:03
 */
namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Validate;

class Subcontract extends Base
{

    /**
     * 项目列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();

        $where['deleted_at'] = null;
        if (!empty($param['name'])) {
            $where['name'] = ['like', '%' . $param['name'] . '%'];
        }

        if (empty($param['page'])) {
            $param['page'] = 1;
        }
        if (empty($param['size'])) {
            $param['size'] = 10;
        }

        $field = '*';
        $order = 'id asc';

        $count = Db::table('subcontract')->where($where)->count();
        $list = Db::table('subcontract')->where($where)->field($field)->order($order)->page($param['page'], $param['size'])->select();

        return $this->buildSuccess([
            'count' => $count,
            'list' => $list,
        ]);
    }

    /**
     * @return array
     */
    public function add()
    {
        $request = Request::instance();
        $param = $request->param();
        pp($param);die;
        $rules = [
            'name' => 'require',
            'con' => 'require',
            'type' => 'require|in:0,1,2',
        ];
        $message = [
            'name.require' => '请填写名称',
            'con.require' => '请填写数量',
            'type.require' => '请选择类型',
            'type.in' => '类型选择错误',
        ];
        $validate = new Validate($rules, $message);
        if (!$validate->check($param)) {
            return $this->buildFailed(0, $validate->getError());
        }

        Db::startTrans();
        try {
            $param['created_at'] = time();
            $param['rule'] = json_encode($param['rule']);
            unset($param['full']);
            unset($param['reduce']);
            Db::table('subcontract')->insert($param);
            Db::commit();
            return $this->buildSuccess([]);
        } catch (\Exception $e) {
            Db::rollback();
            return $this->buildFailed(0, '操作失败');
        }
    }

    /**
     * @function 修改
     * @param str id   主键
     * @param str name   名称
     * @param obj rule   规则（例如：['full'=>'100','reduce'=>'10']）
     * @param str status 状态：0失效；1正常
     */
    public function upd()
    {
        $request = Request::instance();
        $param = $request->param();
        pp($param);die;
        $rules = [
            'id' => 'require',
            'name' => 'require',
            'num' => 'require',
            'add_time' => 'require',
            'end_time' => 'require',
            'rule' => 'require|array',
            'range' => 'require|in:0,1,2',
            'status' => 'require|in:0,1',
            'type' => 'require|in:0,1,2',
        ];
        $message = [
            'id.require' => '请选择数据',
            'name.require' => '请填写名称',
            'num.require' => '请填写数量',
            'add_time.require' => '请填写开始时间',
            'end_time.require' => '请填写结束时间',
            'rule.require' => '请填写规则',
            'rule.array' => '规则格式错误',
            'range.require' => '请选择范围',
            'range.in' => '范围选择错误',
            'status.require' => '请选择状态',
            'status.in' => '状态选择错误',
            'type.require' => '请选择类型',
            'type.in' => '类型选择错误',
        ];
        $validate = new Validate($rules, $message);
        if (!$validate->check($param)) {
            return $this->buildFailed(0, $validate->getError());
        }

        Db::startTrans();
        try {
            $param['updated_at'] = time();
            $param['rule'] = json_encode($param['rule']);
            unset($param['full']);
            unset($param['reduce']);
            Db::table('subcontract')->update($param);
            Db::commit();
            return $this->buildSuccess([]);
        } catch (\Exception $e) {
            Db::rollback();
            return $this->buildFailed(0, '操作失败');
        }
    }

    /**
     * @function 删除
     * @param str id 主键
     */
    public function del()
    {
        $request = Request::instance();
        $param = $request->param();

        $rules = [
            'id' => 'require',
        ];
        $message = [
            'id.require' => '请选择数据',
        ];
        $validate = new Validate($rules, $message);
        if (!$validate->check($param)) {
            return $this->buildFailed(0, $validate->getError());
        }

        $info = Db::table('subcontract')->find($param['id']);
        if (empty($info)) {
            return $this->buildFailed(0, '数据不存在');
        } else {
            if ($info['deleted_at'] !== null) {
                return $this->buildFailed(0, '数据已删除');
            }
        }

        Db::startTrans();
        try {
            $param['deleted_at'] = time();
            Db::table('subcontract')->update($param);
            Db::commit();
            return $this->buildSuccess([]);
        } catch (\Exception $e) {
            Db::rollback();
            return $this->buildFailed(0, '操作失败');
        }
    }

    /**
     * 分类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function classify()
    {

        $grade = new \app\data\model\JoinRole();

        $data = $grade->where('type',3)->field('id,title,policy')->select();
        foreach ($data as $k=>$v){

            $res = explode(',',$v['policy']);
            $data[$k]['res'] = $res;
        }

        // pp($res);die;
        return $this->buildSuccess([
            'list'=>$data,
        ]);

    }
}
