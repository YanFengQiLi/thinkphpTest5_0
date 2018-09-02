<?php

namespace app\index\model;

use think\Model;

class User extends Model
{

    protected $table = 'think_user';

    /**
     * 开启自动写入时间戳后，会自动判断你是更新还是写入操作
     * 自动的为你写入，对应的时间字段的时间戳
     * 需要注意是：
     *      更新方法必须使用save()方法
     */
    protected $autoWriteTimestamp = true;

    protected $dateFormat = 'Y-m-d H:i:s';
    /**
     * 如果你的时间戳不是tp5默认的时间字段，
     * 还是想要使用时间戳的自动写入，那么就要定义
     * 写入、更新的时间字段
     *
     */
    protected $createTime = 'create_time1';
    protected $updateTime = 'update_time1';

    //追加属性
    protected $append = ['message'];

    /**
     * @var string
     * 模型的数据集返回类型   不设置此属性会返回一个对象数组，设置后会返回一个对象
     * 这个属性能去调用toArray()/toJson这类的函数
     * 因为获取器只有当输出数据时，才能转化，而不是从数据库里查询出来就能转化了
     */
    protected $resultSetType = 'collection';

    /*protected function getMessageAttr($value)
    {
        return $value . '我是经过User模型处理之后的数据';
    }*/

    /**
     * 获取器的作用是在获取数据的字段值后自动进行处理
     */
    protected function getCreateTimeAttr($value, $data)
    {
        return date('Y-m-d H:i:s', $value);
    }

    //不是数据表字段也能使用获取器
    protected function getStatusAttr($value, $data)
    {
        $status = ['0' => '未读', '1' => '已读'];
        return $status[$data['status']];
    }

    protected function getUpdateTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }

    //修改器
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }

    /**
     * 修改器的作用是可以在数据赋值的时候自动进行转换处理
     *  主要用于修改和删除
     */
    protected function setEmailAttr($value)
    {
        return $value . '--' . '这是邮箱';
    }

    /**
     * @return \think\model\relation\HasOne
     *  hasOne() 一对一关联
     * 注意：
     * （1）、hasOne() 参数说明
     *     参数1： 要关联的模型名称   命名规范是驼峰法
     *     参数2： 关联模型的外键，tp5默认会已 当前模型名+ _ + id 的方式去找你userInfo的外键，
     *              如果没有找到会报错，所以如果不是 tp5 外键的命名，要指定外键
     *     参数3： 关联模型的主键
     *     参数4： 别名--现在已经被废弃
     *     参数5： 链接类型：默认使用INNER 可支持，LEFT RIGHT FULL
     * （2）、只获取关联模型的某些字段
     *      使用 $this->hasOne()->field()
     * （3）、关联模型的属性绑定（需要版本在 V5.0.4+）
     *      使用 $this->hasOne()->bind('关联模型的字段名1,字段名2...')
     * （4）、注意这里我起的 userInfo() 并不是非要和我的数据表名称对应，
     *  和数据表名称对应的好处就是，显示的定义了 我当前模型与关联的模型
     *
     */
    public function userInfo()
    {
        return $this->hasOne('userInfo', 'user_id', '', '', 'right')
            ->field('user_id,user_content');
    }

    public function userInfos()
    {
        return $this->hasOne('userInfo','user_id')->bind('user_content');
    }


    /**
     * @return \think\model\relation\HasMany
     * @author zhenHong
     *
     */
    public function userComments(){
        return $this->hasMany('UserComment','user_id')->field('user_id,comment,create_time');
    }
}