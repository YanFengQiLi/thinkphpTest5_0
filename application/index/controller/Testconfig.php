<?php
namespace app\index\controller;

use think\Config;
use think\Controller;
use think\Env;

class Testconfig extends Controller{
    /**
     * @author 作者
     * @date 2018/7/8 11:11
     * tp5的配置文件后缀格式：.php结尾，返回格式是以数组形式
     *  若采用其他格式的文件进行配置的话：
     *      要使用parse()导入完整的配置文件名
     */
    public function index(){
        Config::parse(CONF_PATH .'index/myConfig.ini','ini');
        echo Config::get('username');
    }

    /**
     * @author 作者
     * @date 2018/7/8 11:41
     * Env文件的配置及读取
     */
    public function testEnv(){
        echo Env::get('database.user_name');
        echo Env::get('myTest');
    }
}