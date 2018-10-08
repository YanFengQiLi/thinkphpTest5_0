<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class UserInfo extends Model{
    use SoftDelete;

    protected $table = 'think_user_info';

    protected $deleteTime = 'delete_time';


    /**
     * @return \think\model\relation\BelongsTo
     * @author zhenHong
     * 注意:
     *      使用belongsTo()->field()时，这里 field 里获取的字段值就是 user 表的字段
     */
    public function user(){
        return $this->belongsTo('user','user_id','id')->field('id,email');
    }
}