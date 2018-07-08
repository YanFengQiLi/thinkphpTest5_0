<?php
namespace app\index\controller;

use think\Controller;

/**
 * Class TestMyRoute
 * @package app\index\controller
 * 路由使用：
 *      1、可以动态注册    (官方推荐使用)，性能方面比定义配置文件要高
 *      2、定义路由配置文件
 *      注意：
 *      (1)这两个形式是在同一个路由文件中是可以共存的
 *      (2)只要路由中存在必选参数，则必须传递，否则直接报错：模块不存在
 *      (3)路由中存在可选参数，可以不传，但是到具体方法中必须给定默认值，否则直接报错：方法参数错误
 *      (4)可选参数一定放到路由规则的最后，因为如果中间存在可选参数的话，其后的参数都将成为可选参数
 *
 */
class TestMyRoute extends Controller{

    /**
     * @return string
     * @author zhenHong
     * @date 2018/7/8 14:54
     * 使用route路由文件
     */
    public function index(){
        return '1111';
    }


    /**
     * @return string
     * @author zhenHong
     * @date 2018/7/8 14:53
     * 使用route_my路由文件
     */
    public function newShow(){
        return '2222';
    }

    /**
     * @param $name
     * @param $age
     * @return string
     * @author zhenHong
     * @date 2018/7/8 14:53
     * 使用路由传递变量--必传参数
     *      访问路由：URL必须为标准的pathInfo模式
     *      http://testGetParam/张三/12
     */
    public function testGetParam($name,$age){
       return "我的名字是{$name}，年龄为{$age}";
    }

    /**
     * @param string $name
     * @param string $age
     * @return string
     * @author zhenHong
     * @date 2018/7/8 14:53
     * 使用路由传递变量--可选参数
     * 测试地址： http://testChoseParam
     */
    public function testChoseParam($name = '姓名没传',$age = '年龄没传'){
        return "我是可选参数：{$name},年龄为：{$age}";
    }

    /**
     * @param string $name
     * @param $sex
     * @return string
     * @author zhenHong
     * @date 2018/7/8 15:06
     * 使用路由传递变量--必选+可选参数
     * 测试地址：http://testChoseAndMustParam/zhangsan
     */
    public function testChoseAndMustParam($name,$sex='没传'){
        return "我的姓名:{$name},我的性别:{$sex}";
    }



}