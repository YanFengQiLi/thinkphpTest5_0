<?php

namespace app\index\model;

use think\Model;

class UserComment extends Model
{
    protected $table = 'think_user_comments';


    protected $dateFormat = 'Y-m-d H:i:s';

    protected $insert = ['news_id' => 1];

    protected $autoWriteTimestamp = true;

    /**
     * @return \think\model\relation\BelongsTo
     * @author zhenHong
     *  定义相对关联-用户表
     */
    public function user()
    {
        return $this->belongsTo('user')->bind('username');
    }

}