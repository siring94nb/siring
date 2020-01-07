<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/26
 * Time: 17:16
 */
namespace app\data\model;

use think\Model;
use think\Db;
use traits\model\SoftDelete;

/**
 * @author fyk
 * 日程安排
 */
class Meeting extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delect_at';
    protected $createTime = 'add_time';
    protected $updateTime = 'end_time';
    protected $table = "meeting";
    protected $resultSetType = 'collection';

    /**
     * 会场介绍
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function meeting_list()
    {
        $res = self::field('id,title,region,address,add_time,end_time,upper_num,cost,field_img')->select();

        foreach ($res as $k=>$v){
            $res[$k]['map_img'] = explode(',',$v['field_img']);
        }

        return $res;
    }

}
