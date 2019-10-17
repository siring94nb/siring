<?php

namespace app\admin\controller;

use think\Request;

class Feedback extends Base
{
    /**
     * 意见反馈
     * @author fyk
     * @return mixed
     * @throws \think\exception\DbException
     * @time 2019/10/14/18:03
     */
    public function index()
    {
        $request = Request::instance();
        $param = $request->param();

        $partner = new \app\data\model\Feedback();

        $data = $partner->suggest_list($param);

        return $this -> buildSuccess( array(
            'list' => $data['data'],
            'count' => $data['total'],
        ) );
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
