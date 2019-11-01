<?php
/**
 * Created by PhpStorm.
 * User: fyk
 * Date: 2019/11/1
 * Time: 15:48
 */
namespace app\data\model;
use think\Model;
class UserDiscount extends Model
{

    protected $table = "user_discount";
    protected $resultSetType = 'collection';

    public function dis_list($status, $uid)
    {
        $data = UserDiscount::with('discount')->where(['status' => $status, 'user_id' => $uid])
            ->field('id,user_id,discount_id,status')->select()->toArray();
        return $data;
    }

    /**
     * 关联分类表
     * @return \think\model\relation\BelongsTo
     */
    public function discount()
    {
        return $this->belongsTo('Discount', 'discount_id', 'id');
    }

}
