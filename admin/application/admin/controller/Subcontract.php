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
        $validate = new Validate([
            ['pid', 'require', '省份id不能为空'],
            ['name', 'require', '城市名称不能为空'],
            ['type', 'require', '城市级别不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
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
        $validate = new Validate([
            ['pid', 'require', '省份id不能为空'],
            ['name', 'require', '城市名称不能为空'],
            ['type', 'require', '城市级别不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
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
