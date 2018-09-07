<?php

namespace app\index\controller;

use app\index\model\Vue as VueModel;
use app\index\model\VueNews;
use think\Controller;
use think\Request;
use app\index\model\UserComment;

header('Access-Control-Allow-Origin:*');

/**
 * Class Vue
 * @package app\index\controller
 * 路由规则：config/route.php中
 */
class Vue extends Controller
{
    //查询记录
    public function index()
    {
        $vue = new VueModel();
        $data = $vue->all();
        $result = ['status' => 0, 'message' => $data];
        return json($result);
    }

    //添加数据
    public function add(Request $request)
    {
        $vue = new VueModel();
        $post = $request->post();
        $num = $vue->save($post);
        if ($num) {
            $result = ['status' => 0, 'message' => '添加成功'];
        } else {
            $result = ['status' => 1, 'message' => '添加失败'];
        }
        return json($result);
    }

    //删除数据
    public function del(Request $request)
    {
        $vue = new VueModel();
        $id = $request->param('id');
        $num = $vue::destroy($id);
        if ($num) {
            $result = ['status' => 0, 'message' => '删除成功'];
        } else {
            $result = ['status' => 1, 'message' => '删除失败'];
        }
        return json($result);
    }


    /**
     * @return \think\response\Json
     * @throws \Exception
     * @author zhenHong
     * 批量添加新闻
     */
    public function addNews()
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $data[$i]['title'] = '这是新闻标题---' . $i;
            $data[$i]['click'] = $i;
            $data[$i]['content'] = '这是新闻内容---' . $i;
        }
        $news = new VueNews();
        $bool = $news->saveAll($data);
        if ($bool) {
            return dataResponse(200, '', '添加成功');
        } else {
            return dataResponse(201, '', '添加失败');
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author zhenHong
     * 新闻列表
     */
    public function vueNewsList()
    {
        $page = input('page') ?: 1;
        $list['list'] = VueNews::select(function ($query) use ($page) {
            $query->page($page, 10)->order('create_time desc');
        });
        $list['total'] = VueNews::count();
        return dataResponse(200, $list, '查询成功');
    }

    /**
     * @param $id
     * @return \think\response\Json
     * @throws \think\exception\DbException
     * @author zhenHong
     * 新闻详情
     */
    public function vueNewsInfo($id)
    {
        $newInfo = VueNews::get($id);
        return dataResponse($newInfo ? 200 : 201, $newInfo, '成功');
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author zhenHong
     * 评论列表
     */
    public function vueUserComments(Request $request)
    {
        $param = $request->param();
        $info = UserComment::with('user')->select(function ($query) use ($param) {
            $query->where(['news_id' => $param['newsId']])
                ->page($param['pageIndex'], 2)
                ->order('create_time desc');
        });
        return dataResponse(200,$info,'成功');
    }

    /**
     * @param Request $request
     * @return \think\response\Json
     * @author zhenHong
     * 发表评论
     */
    public function vueAddComments(Request $request){
        $data = $request->post();
        $UserComment = new UserComment();
        $num = $UserComment->save($data);
        if($num){
            return dataResponse(200,'','发表评论成功');
        }else{
            return dataResponse(201,'','发表评论失败');
        }
    }
}