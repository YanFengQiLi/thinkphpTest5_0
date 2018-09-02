<?php
use think\Route;

Route::get('news','index/TestMyRoute/index');


/**
 *  vue 的路由
*/
//  新闻详情路由
Route::get('vue/vueNewsInfo/:id','index/Vue/vueNewsInfo');

/**
 * 新闻评论路由  vue/vueUserComments/1?pageIndex=1&name=4565 当我们以这种形式去访问路由时，也是可以的
 * 只不过获取参数时，需要 $request->param() 或 input() 或 request()->param() 去获取 url 里的全部参数
 */
Route::get('vue/vueUserComments/:newsId','index/Vue/vueUserComments');
