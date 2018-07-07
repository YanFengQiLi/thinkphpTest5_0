<?php
namespace app\index\validate;

use think\Validate;

/**
 * Class User
 * @package app\index\validate
 * User表验证类
 */
class User extends Validate{

    //当前验证的规则
    protected $rule = [
        'username' => ['require','regex'=>'/^[a-zA-Z0-9]{6,10}$/','checkUserName'=>'zhangsan'],
        'email' => ['require','email'],
        'mobile' => ['regex' => '0?(13|14|15|17|18|19)[0-9]{9}'],
        'password' => ['require','regex'=>'/^[a-zA-Z0-9]{6,10}$/'],
        //令牌验证规则
        //'__token__' => 'token'
    ];
    //错误提示信息
    protected $message = [
        'username' => '用户名由字母和数字组成,长度在5~15位',
        'email' => '邮箱不合法',
        'mobile' => '手机号不合法',
        'password' => '密码由字母和数字组成,长度在6~20位',
        //表单令牌验证
        //'__token__' => '页面已经过期'
    ];

    /**
     * @var array
     *  验证场景
     *  key:场景标示字段,自定义
     *  value:需要验证的字段名称
     */
    protected  $scene = [
        //使用原有的验证规则
//        'edit'  => ['username','email']

        //对某些字段规则进行重新设置
        'edit'  => [
            'username'  => ['require','min'=>5,'max'=>10],
            'email' => 'checkEmail',
            //表单令牌验证
            //'__token__' => 'token'
        ]
    ];

    /*
     *  自定义验证规则   需要注意的是你自定义的验证规则名,不能和tp5系统内的规则名重名
     *  支持传递三个参数：
     *      1、$value   对应字段的提交值
     *      2、$rule    定义的规则值
     *      3、$data    传递进来的数据源
     * */
    protected function checkUserName($value,$rule,$data){
        return $value != $rule ? true : '用户名已经存在';
    }

    //edit场景使用的回调
    protected function checkEmail($value){
        return $value == '123@qq.com' ? true : false;
    }


}