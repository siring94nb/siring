<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use \tp5er\Backup;
class Banner extends Base
{
    /**
     * 显示资源列表
     * @time 2019/10/10
     * @return \think\Response
     */
    public function index()
    {

        $banner = new \app\data\model\Banner();
        $data = $banner->banner_list();

        return $data ? returnJson(1,'获取成功',$data) : returnJson(0,'获取失败',$data);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */

    public function save()
    {
        $config=array(
            'path'     => './static/data/',//数据库备份路径
            'part'     => 20971520,//数据库备份卷大小
            'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
        );
        $time = 1571190090;
        $db= new Backup($config);

        $file = $db->downloadFile($time);//下载备份数据

        pp($file);die;
    }

    public function create()
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
