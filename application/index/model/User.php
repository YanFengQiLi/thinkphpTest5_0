<?php
namespace app\index\model;
use think\Model;

class User extends Model{

    protected $table = 'think_user';

    /**
        开启自动写入时间戳后，会自动判断你是更新还是写入操作
     * 自动的为你写入，对应的时间字段的时间戳
     * 需要注意是：
     *      更新方法必须使用save()方法
     */
    protected $autoWriteTimestamp = true;

    protected $dateFormat = 'Y-m-d H:i:s';
    /**
        如果你的时间戳不是tp5默认的时间字段，
     * 还是想要使用时间戳的自动写入，那么就要定义
     * 写入、更新的时间字段
     *
     */
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';
    /**
        获取器的作用是在获取数据的字段值后自动进行处理
     */
    protected  function getCreateTimeAttr($value,$data){
        return date('Y-m-d H:i:s',$value);
    }

    //不是数据表字段也能使用获取器
    protected function getStatusAttr($value,$data){
        $status = ['0' => '未读','1' => '已读'];
        return $status[$data['status']];
    }

    protected  function getUpdateTimeAttr($value){
        return date('Y-m-d H:i:s',$value);
    }

    protected function setPasswordAttr($value){
        return md5($value);
    }
    /**
        修改器的作用是可以在数据赋值的时候自动进行转换处理
     *  主要用于修改和删除
     */
    protected  function setEmailAttr($value){
        return $value.'--'.'这是邮箱';
    }


}