<?php
use think\Route;

//动态注册形式----tp5官方推荐
Route::get('newShow','index/TestMyRoute/newShow');

//传递必选参数
Route::get('testGetParam/:name/:age','index/TestMyRoute/testGetParam');

//可选参数
Route::get('testChoseParam/[:name]/[:age]','index/TestMyRoute/testChoseParam');

//可选参数+必选参数
Route::get('testChoseAndMustParam/:name/[:sex]','index/TestMyRoute/testChoseAndMustParam');



//定义配置文件的形式
return [
    'newShow1' => 'index/TestMyRoute/newShow'
];

