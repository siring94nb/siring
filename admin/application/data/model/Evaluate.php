<?php
namespace app\data\model;
use think\Model;

/**
 * lilu
 * 快捷估价
 */
class Evaluate extends Model
{
    protected $table = "evaluate";
    protected $resultSetType = 'collection';

    /**
     * lilu
     * 获取跨界估价的平台
     */
    public function getPlateForm(){
        
        $plate_form=Evaluate::all();

    }



}