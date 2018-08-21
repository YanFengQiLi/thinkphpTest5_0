<?php
namespace app\index\model;

use think\Model;

class Users extends Model{
    protected $table = 'think_user';
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time1';
    protected $updateTime = 'update_time1';

    protected function getUsernameAttr($value,$data){
        return $value.'--------';
    }
    protected $dateFormat = 'Y-m-d H:i:s';

    /*protected function getCreateTime1Attr($value,$data){
        return date('Y-m-d H:i:s',$value);
    }

    protected function getUpdateTime1Attr($value,$data){
        return date('Y-m-d H:i:s',$value);
    }*/

    protected function setPasswordAttr($value,$data){

        return md5($value);
    }
}