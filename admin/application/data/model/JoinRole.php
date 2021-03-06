<?php

namespace app\data\model;

use think\Model;
use traits\model\SoftDelete;

class JoinRole extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delect_at';
    protected $table = "join_role";
    protected $resultSetType = 'collection';
//    protected $hidden = ['created_at','updated_at'];

    /**
     * 角色列表分类
     * @author fyk
     * @param $param
     * @return array
     * @throws \think\exception\DbException
     */
    public function join_list($param)
    {

        $where = [];
        $where['delect_at'] = null;
        $where['type'] = $param['type'];
        if(empty($param['page'])){
            $param['page'] = 1;
        }
        if(empty($param['size'])){
            $param['size'] = 10;
        }
        $field = '*';
        $order = 'id desc';

        $list =  JoinRole::where( $where )  -> field( $field ) -> order( $order )
            -> paginate( $param['size'] , false , array( 'page' => $param['page'] ) ) -> toArray();

        return $list;
    }

    /**
     * 角色加盟新增
     * @param $param
     * @return false|int
     */
    public  function join_add($type,$title,$img,$term,$money,$policy,$forecast,$discount,$royalty,$bottom_commission,$standard_commission,$standard_num)
    {
        $join = new JoinRole;
        $res = $join->save([

            'type' => $type,
            'title' => $title,
            'img' => $img,
            'term' => $term,
            'money' => $money,
            'policy' => $policy,
            'forecast' => $forecast,
            'discount' => $discount,
            'royalty' => $royalty,
            'bottom_commission' => $bottom_commission,
            'standard_commission' => $standard_commission,
            'standard_num' => $standard_num,
            'created_at' => time(),

        ]);

        return $res ;
    }

    /**
     * 角色加盟修改
     * @param $param
     * @return false|int
     */
    public  function join_upd($id,$type,$title,$img,$term,$money,$policy,$forecast,$discount,$royalty,$bottom_commission,$standard_commission,$standard_num)
    {
        $join = new JoinRole;
        $res = $join->save([

            'type' => $type,
            'title' => $title,
            'img' => $img,
            'term' => $term,
            'money' => $money,
            'policy' => $policy,
            'forecast' => $forecast,
            'discount' => $discount,
            'royalty' => $royalty,
            'bottom_commission' => $bottom_commission,
            'standard_commission' => $standard_commission,
            'standard_num' => $standard_num,
            'created_at' => time(),

        ],['id' => $id]);

        return $res;
    }

    /**
     * 软删除
     * @param $id
     */
    public static function join_del($id)
    {
        if (!$id) {
            returnJson(0, '缺少必要参数');
        }

        $res = JoinRole::destroy($id);

        return $res;
    }


    /**
     * 城市合伙人等级费用
     * @return false|\PDOStatement|string|\think\Collection|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function grade_index()
    {
        return JoinRole::where('type',2)->select() ? JoinRole::where('type',2)->field('sort,title,money')->select() : returnJson(0,'数据不存在');
    }


    /**
     * 会员套餐费用
     * @return false|\PDOStatement|string|\think\Collection|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function member_index()
    {
        return JoinRole::where('type',1)->select() ? JoinRole::where('type',1)->field('id,title,img,money,policy')->select() : returnJson(0,'数据不存在');
    }

    /**
     * 分包商套餐费用
     * @param $policy
     * @return false|\PDOStatement|string|\think\Collection|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function join_index($id)
    {
        return JoinRole::where('id',$id)->field('id,title,policy,money')->find()->toArray();
    }

    /**
     * 用户套餐折扣信息
     * @param $id
     * @return array|void
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function join_user($id)
    {
        return self::get(['id'=>$id]) ? self::get(['id'=>$id])->toArray() : returnJson(0,'数据有误');
    }

    /**
     * 等级显示
     * @param $grade
     * @return JoinRole|array|null
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function member_details($grade)
    {
        switch ($grade){
            case 0:
                return   self::get(['id',2])->toArray();
                break;
            case 1:
                return   self::get(['id',3])->toArray();
                break;
            case 2:
                return self::get(['id',4])->toArray();
                break;
            case 3:
                return self::get(['id',5])->toArray();
                break;
        }
    }

    /**
     * 申请等级
     * @param $grade
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function grade_type($grade)
    {
        return self::where('id',$grade)->find();
    }

    /**
     * 等级政策
     * @param $grade
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function grade_city($grade)
    {
        return self::where('sort',$grade)->find();
    }

}
