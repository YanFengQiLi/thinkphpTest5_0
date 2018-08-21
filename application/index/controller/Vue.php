<?php
namespace app\index\controller;

use app\index\model\Vue as VueModel;
use think\Controller;
use think\Request;
use think\Route;

header('Access-Control-Allow-Origin:*');
class Vue extends Controller{
	//查询记录
	public function index(){
		$vue = new VueModel();
		$data = $vue->all();
		$result = [
			'status' => 0,
			'message' => $data
		];
		return json($result);
	}

	//添加数据
    public function add(Request $request){
        $vue = new VueModel();
        $post = $request->post();
        $num = $vue->save($post);
        if($num){
            $result = [
                'status' => 0,
                'message' => '添加成功'
            ];
        }else{
            $result = [
                'status' => 1,
                'message' => '添加失败'
            ];
        }
        return json($result);
    }

    //删除数据
    public function del(Request $request){
        $vue = new VueModel();
        $id = $request->param('id');
        $num = $vue::destroy($id);
        if($num){
            $result = [
                'status' => 0,
                'message' => '删除成功'
            ];
        }else{
            $result = [
                'status' => 1,
                'message' =>'删除失败'
            ];
        }
        return json($result);
    }
}