<?php

namespace app\admin\controller;

use think\Request;
use think\Validate;
use think\Db;
class Seo extends Base
{
    /**
     * 显示资源列表
     * @author fyk
     * @return \think\Response
     */
    public function index()
    {
        $seo = new \app\data\model\Seo();

        $data = $seo ->seo_index();

        return $this->buildSuccess([
            'con' => $data,
        ]);

    }


    /**
     * 保存更新的资源
     * @author fyk
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function upd()
    {
        $request = Request::instance();
        $param = $request->param();
       // pp($param);die;
        $rules = [
            'name' => 'require',
            'title' => 'require',
            'tag' => 'require',
            'con' => 'require',
            'copyright' => 'require',
        ];
        $message = [
            'name.require' => '请填写网站名称',
            'title.require' => '请填写网站短名称',
            'tag.require' => '请填写网站标签',
            'con.require' => '请填写关键词',
            'copyright.require' => '请填写版权信息',
        ];
        $validate = new Validate($rules, $message);
        if (!$validate->check($param)) {
            return $this->buildFailed(0, $validate->getError());
        }
        $param['created_at'] = time();
        $info = Db::table('seo')->find();
        if (empty($info)) {
            $insert = Db::table('seo')->insert($param);
            if (!$insert) {
                return $this->buildFailed(0, '操作失败');
            }
        } else {
            $id = $info['id'];
            $update = Db::table('seo')->where('id',$id)->update($param);
            if ($update === false) {
                return $this->buildFailed(0, '操作失败');
            }
        }

        return $this->buildSuccess([]);
    }


}
