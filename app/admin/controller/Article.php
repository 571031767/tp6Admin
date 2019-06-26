<?php

namespace app\admin\controller;

use think\facade\Session;
use think\facade\View;
use think\Request;
use think\exception\ValidateException;
//qq571031767  微博：@沙坪坝韩宇
class Article extends Common
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function add()
    {
        View::assign("title","新增文章");
        return View::fetch();
    }



    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $id = \think\facade\Request::param("id");
        $title = \think\facade\Request::param("title");
        $status = \think\facade\Request::param("status");
        if($id){
            $map["id"] = $id;
        }
        if($title){
            if(isset($map)){
                unset($map);
            }
            $map= [
                ['title', 'like', "%{$title}%"],
            ];
        }
        if($status){
            $map["status"] = $status;
        }
        if(!isset($map)){
            $map=1;
        }

        $list = \app\model\Content::with("model")
            ->where("model_id","in","1,0")
            ->where($map)
            ->order("status DESC ,id DESC")
            ->paginate();
        View::assign("list",$list);
        View::assign("title","文章列表");
        return view();
    }

    public function main()
    {
        return \view();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $data = \think\facade\Request::post();
        try {
            $result = validate(\app\validate\Article::class)->check($data);

            if (true !== $result) {
                // 验证失败 输出错误信息
                $return["code"] = 201;
                $return["msg"] = "数据格式错误";
                return json($return);
            }

        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            $return["code"] = 201;
            $return["msg"] = $e->getError();
            return json($return);
        }
        if(!$data["author"]){
            if(Session::get("index_user.name")){
                $data["author"] = Session::get("index_user.name");
            }else{
                $data["author"] = "米醋儿-佚名";
            }
        }

        unset($data["file"]);
//        p($data);die;

        $res = \app\model\Article::create($data);
        //p($res);
        if($res){
            $content["title"] = $res->title;
            $content["cate_id"] = $res->cate_id;
//            $content["prefimg"] = $res->prefimg;
            $content["author"] = $res->author;
            $content["info"] = strip_tags($res->info);
            $content["hits"] = rand(548,699);
            $content["contentid"] = $res->id;
            \app\model\Content::create($content);
            return json(["code"=>200,"msg"=>"成功"]);
        }else{
            return json(["code"=>204,"msg"=>"请稍后再试"]);
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
