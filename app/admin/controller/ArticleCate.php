<?php

namespace app\admin\controller;

use think\facade\Session;
use think\facade\View;
use think\Request;
use think\exception\ValidateException;
//qq571031767  微博：@沙坪坝韩宇
class ArticleCate extends Common
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function add()
    {
        $list = \app\model\ArticleCate::where(1)
            ->order("status DESC ,id DESC")
            ->select()->toArray();
        $list = unlimitforlevel($list);
        View::assign("list",$list);
        View::assign("title","新增");
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
        $title = \think\facade\Request::param("name");
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
            if(isset($map) &&is_array($map)){
                $map = array_push($map,["status","=",$status]);
            }else{
                $map =[["status","=",$status]];
            }

        }
        if(!isset($map)){
            $map=1;
        }

        $list = \app\model\ArticleCate::where($map)
            ->order("status DESC ,id DESC")
            ->select()->toArray();
        $list = unlimitforlevel($list);
        View::assign("list",$list);
        View::assign("title","列表");
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


        unset($data["file"]);
        if($data["pid"]){
            $t = \app\model\ArticleCate::where(array('id'=>$data["pid"]))->field('spid')->find();
            $spid = $t["spid"];
            $data["spid"] = $spid ? $spid.$data["pid"] : $data["pid"];
            $data["spid"] = $data["spid"]."|";
        }


        $res = \app\model\ArticleCate::create($data);
        //p($res);
        if($res){

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
        $list = \app\model\ArticleCate::where(1)
            ->order("status DESC ,id DESC")
            ->select()->toArray();
        $list = unlimitforlevel($list);
        View::assign("list",$list);
        $res = \app\model\ArticleCate::find($id);

        View::assign("res",$res);

        View::assign("title","修改");
        return \view();
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
        $data = $request->post();
        unset($data["file"]);
        $res = \app\model\ArticleCate::where("id",$id)
            ->update($data);
        if($res){

            return json(["code"=>200,"msg"=>"成功"]);
        }else{
            return json(["code"=>204,"msg"=>"请稍后再试"]);
        }
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
        $res = \app\model\ArticleCate::where("id",$id)->delete();
        if($res){
            return json(["code"=>200,"msg"=>"成功"]);
        }else{
            return json(["code"=>204,"msg"=>"请稍后再试"]);
        }
    }
}
