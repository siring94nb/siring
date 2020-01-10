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

}
