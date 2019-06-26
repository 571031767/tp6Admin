<?php

namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Request;

//qq571031767  微博：@沙坪坝韩宇
class Comment extends BaseController
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $contentid = \think\facade\Request::param("contentid");
        $page = \think\facade\Request::param("page",1);
        $limit = \think\facade\Request::param("limit",10);
        $list = \app\model\Comment::with("user")
            ->where("contentid",$contentid)
            ->where("status",1)
            ->page($page)
            ->limit($limit)
            ->select();
        if(!$list->isEmpty()){
            $return["code"] = 200;
            $return["msg"] = "成功";
            $return["data"] = $list;
            return json($return);
        }else{
            $return["code"] = 201;
            $return["msg"] = "失败";
            $return["data"] = $list;
            return json($return);
        }
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $user = Session::get("index_user");
        if(!$user){
            $return["code"] = 201;
            $return["msg"] = "用户未登录";
            return json($return);
        }
        $data = \think\facade\Request::post();
        try {
            $result = validate(\app\validate\Comment::class)->check($data);

            if (true !== $result) {
                // 验证失败 输出错误信息
                $return["code"] = 203;
                //$return["msg"] = $result;
                $return["msg"] = "数据格式错误";
                return json($return);
            }
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            $return["code"] = 201;
            $return["msg"] = $e->getError();
            //$return["msg"] = "数据不能为空";
            return json($return);
        }

        $data["uid"] = $user["id"];
        $res = \app\model\Comment::create($data);
        if($res){
            //评论数+1
            Db::name("content")
                ->where("contentid",$data["contentid"])
                ->inc("comment_num")
                ->update();

            $res->user = $user;
            $return["code"] = 200;
            $return["msg"] = "成功";
            $return["data"] = $res;

            return json($return);
        }else{
            $return["code"] = 204;
            $return["msg"] = "请稍后再试";
            $return["data"] = "";

            return json($return);
        }



    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $content = \app\model\Content::with("model")->find($id);

        switch ($content["model"]["model_name"]){
            case "Article":
                $res = \app\model\Article::find($id);
                $view = "article";
            case "Video";
                $res = \app\model\Video::find($id);
                $view = "video";
            case "Thumb";
                $res = \app\model\Thumb::find($id);
                $view = "thumb";
            case "Soft";
                $res = \app\model\Soft::find($id);
                $view = "soft";
            default:
                $res = \app\model\Article::find($id);
                $view = "article";
        }
        View::assign("res",$res);
        View::assign("content",$content);
        return View::fetch($view);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
