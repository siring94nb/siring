<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2020/1/6
 * Time: 10:40
 */
namespace app\data\model;

use think\Model;
use think\Db;
use think\Validate;

/**
 * @author fyk
 * 消息表
 */
class Message extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $table = "message";
    protected $resultSetType = 'collection';

    /**
     * 留言
     * @param $param
     * @return false|int
     */
    public function add($param)
    {
        $validate = new Validate([
            ['pid','require','产品id必须'],
            ['uid','require','发用户不能为空'],
            ['rid','require','收消息用户不能为空'],
            ['content','require','留言不能为空'],
        ]);
        if(!$validate->check($param)){
            returnJson (0,$validate->getError());exit();
        }

        return $this->allowField(true)->save($param);

    }

    /**
     * 留言列表
     * @param $pid
     * @param $uid
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function get_list($pid,$uid)
    {
        $res = self::where(['pid'=>$pid,'uid'=>$uid])->order('create_time','desc')->paginate()->toArray();
            foreach ($res['data'] as $k =>$v){
                if($v['inside']==0){
                    $user = (new User()) ->user_detail($v['uid']);//查询个人信息
                    $res['data'][$k]['name'] = $user['realname'];
                    $res['data'][$k]['img'] = $user['img'];
                }else{
                    $res['data'][$k]['name'] = '平台顾问';
                }

            }
        return $res;
    }

}
