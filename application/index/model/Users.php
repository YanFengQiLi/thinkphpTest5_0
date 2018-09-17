<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Users extends Model{
    use SoftDelete;

    protected $table = 'think_user';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time1';
    protected $updateTime = 'update_time1';
    protected $dateFormat = 'Y-m-d H;i:s';
    protected $hidden = ['password'];


    protected $deleteTime = 'delete_time';

    //  类型转换
    /*protected $type = [
        'delete_time' => 'datetime'
    ];*/

    //  hasOne()
    public function userInfo(){
        return $this->hasOne('userInfo','user_id','id')
            ->field('user_id,user_content');
    }

    //  hasMany()
    public function userComments(){
        return $this->hasMany('userComment','user_id','id')->field('id,user_id,comment,create_time');
    }

    //  绑定字段到父模型 bind()可以传递
    public function userInfo2(){
        return $this->hasOne('userInfo','user_id')
            ->bind([
                'user_content',
                'user_info_id' => 'id'
            ]);
    }


}