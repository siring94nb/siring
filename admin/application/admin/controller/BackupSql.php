<?php

namespace app\admin\controller;

use think\Request;
use \tp5er\Backup;
class BackupSql extends Base
{
    /**
     * 显示资源列表
     * @author fyk
     * @return \think\Response
     * @time 2019/10/15
     */
    //数据库备份
    public function index1()
    {
        //获取操作内容：（备份/下载/还原/删除）数据库
        $type = input("type");
        //获取需要操作的数据库名字
        $name = input("name");
        $backup = new \org\Baksql(\think\Config::get("database"));
        switch ($type) {
            //备份
            case "backup":
                $info = $backup->backup();
                return $info  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
                break;
            //下载
            case "dowonload":
                $info = $backup->downloadFile($name);
                return $info  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
                break;
            //还原
            case "restore":
                $info = $backup->restore($name);
                return $info  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
                break;
            //删除
            case "del":
                $info = $backup->delfilename($name);
                return $info  ?   $this -> buildSuccess( [] , '成功' ) :  $this -> buildFailed( 1001 , '失败' );
                break;
            //如果没有操作，则查询已备份的所有数据库信息
            default:
                $data = array_reverse($backup->get_filelist());//将信息由新到老排序

                return $this->buildSuccess([
//                    'count'=>$count,
                    'list'=>$data,
                ]);

        }
    }


    public function index()
    {
        $config=array(
            'path'     => './static/data/',//数据库备份路径
            'part'     => 20971520,//数据库备份卷大小
            'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
        );

        $db= new Backup($config);

        $file = array_values($db->fileList());//获取备份文件列表

        $total = count($file);//数组统计
        foreach ($file as $key => $val){

            $file[$key]['title'] = '思锐数据库备份';

            $file[$key]['size'] = formatBytes($val['size']);

            $file[$key]['created_at'] = date('Y-m-d H:i:s',$val['time']);
        }
        rsort($file);//数据排序

        return $this -> buildSuccess( array(
            'list' => $file,
            'count' => $total,
        ) );

    }
    /**
     * 显示创建资源表单页.
     * @author fyk
     * @return \think\Response
     */
    public function create()
    {
        $config=array(
            'path'     => './static/data/',//数据库备份路径
            'part'     => 20971520,//数据库备份卷大小
            'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
        );

        $db= new Backup($config);

        $tables=$db->dataList();//获取数据库所有表的信息

        foreach($tables as $k=>$v){
            $db->backup($v['name'],0);//循环所有表备份表和数据
        }

        $res = $db->getFile();//获取所备份文件的文件名

        return $res  ?   $this -> buildSuccess( [] , '备份成功' ) :  $this -> buildFailed( 1001 , '备份失败' );
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save($time)
    {
        $config=array(
            'path'     => './static/data/',//数据库备份路径
            'part'     => 20971520,//数据库备份卷大小
            'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
        );
        $db= new Backup($config);

        $file = $db->downloadFile($time);//下载备份数据

        return $file  ?   $this -> buildSuccess( [] , '下载成功' ) :  $this -> buildFailed( 1001 , '下载失败' );
       // pp($file);die;
    }


    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function del($time)
    {
        $config=array(
            'path'     => './static/data/',//数据库备份路径
            'part'     => 20971520,//数据库备份卷大小
            'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
        );
        $db= new Backup($config);

        $file = $db->delFile($time);//删除备份数据

        return $file  ?   $this -> buildSuccess( [] , '删除成功' ) :  $this -> buildFailed( 1001 , '删除失败' );
    }
}
