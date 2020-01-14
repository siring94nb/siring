<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 19:46
 */

namespace app\model;

use traits\model\SoftDelete;

class User extends  Base{

    use SoftDelete;
    protected $deleteTime = 'delect_at';
    protected $table = "user";
    protected $resultSetType = 'collection';
    protected $createTime   = 'created_at';
    protected $updateTime    = 'end_time';
    /**
     * 关联表
     * @return \think\model\relation\HasOne
     */
    public function grade(){
        return $this -> hasOne( 'UserGrade' , 'user_id' , 'id' );
    }

    /**
     * 用户列表数据
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function user_list($param)
    {

        $where = array();
        if(!empty($param['is_city'])){
            $where['is_city'] = $param['is_city'];
        }
        if(!empty($param['is_subpackage'])){
            $where['is_subpackage'] = $param['is_subpackage'];
        }
        if(!empty($param['title'])){
            $where['phone|realname'] = ['like','%'.$param['title'].'%'];
        }

        if(!empty($param['start_time'])){
            $param['start_time'] = date('Y-m-d H:i:s',strtotime($param['start_time']));
            $where['created_at'] = ['gt',$param['start_time']];
        }
        if(!empty($param['end_time'])){
            $param['end_time'] = date('Y-m-d H:i:s',strtotime($param['end_time']));
            $where['created_at'] = ['lt',$param['end_time']];
        }
        if(!empty($param['start_time']) && !empty($param['end_time'])){
            $where['created_at'] = ['between',[$param['start_time'],$param['end_time']]];
        }
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = '*';
        $order = 'id desc';

        $user = new User();
        $list = $user -> field( $field ) -> where( $where ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list;
    }

    /**
     * 新增
     * @param $param
     * @return false|int
     */
    public  function user_add($type,$password,$salt,$realname,$phone,$remark,$img,$invitation)
    {
        $join = new User;
        $join->save([

            'type' => $type,
            'password' => $password,
            'salt' => $salt,
            'realname' => $realname,
            'phone' => $phone,
            'remark' => $remark,
            'img' => $img,
            'invitation' => $invitation,
            'created_at' => time(),

        ]);
        return $join;

    }

    /**
     * 修改同时修改密码
     * @param $param
     * @return false|int
     */
    public  function user_upd($id,$type,$password,$salt,$realname,$phone,$remark,$img)
    {
        $join = new User;
        $res = $join->save([

            'type' => $type,
            'password' => $password,
            'salt' => $salt,
            'realname' => $realname,
            'phone' => $phone,
            'remark' => $remark,
            'img' => $img,

        ],['id' => $id]);

        return $res;
    }

    /**
     * 修改
     * @param $param
     * @return false|int
     */
    public  function user_edit($id,$type,$salt,$realname,$phone,$remark,$img)
    {
        $join = new User;
        $res = $join->save([

            'type' => $type,
            'salt' => $salt,
            'realname' => $realname,
            'phone' => $phone,
            'remark' => $remark,
            'img' => $img,

        ],['id' => $id]);

        return $res;
    }

    /**
     * 软删除
     * @param $id
     */
    public static function user_del($id)
    {
        if (!$id) {
            returnJson(0, '缺少必要参数');
        }

        $res = User::destroy($id);

        return $res;
    }
}
