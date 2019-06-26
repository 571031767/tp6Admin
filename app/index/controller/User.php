<?php

namespace app\index\controller;

use think\facade\Session;
use think\facade\View;
use think\Request;


//qq571031767  微博：@沙坪坝韩宇
class User extends Logged
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


        View::assign("title","首页");
        return view();
    }

    //修改用户信息
    public function change_profile()
    {
        $uid = Session::get("index_user.id");
        if(\think\facade\Request::isPost()){
            $data = \think\facade\Request::post();
            $res = \app\model\User::where("id",$uid)->update($data);
            if($res){
                $return["code"] = 200;
                $return["msg"] = "成功";

            }else{
                $return["code"] = 201;
                $return["msg"] = "请稍后再试";

            }
            return json($return);
        }

        $user = \app\model\User::find($uid);
        View::assign("user",$user);
        return view();
    }

    //修改用户密码
    public function change_password()
    {
        $uid = Session::get("index_user.id");
        $user = \app\model\User::find($uid);
        if(\think\facade\Request::isPost()){
            $data = \think\facade\Request::post();
            if(md5($data["password"]) != $user["password"]){
                $return["code"] = 203;
                $return["msg"] = "密码错误";
                return json($return);
            }

            if($data["new_password"] != $data["re_password"]){
                $return["code"] = 204;
                $return["msg"] = "两次密码不一致";
                return json($return);
            }

            $res = \app\model\User::where("id",$uid)->update(["password"=>md5($data["new_password"])]);
            if($res){
                $return["code"] = 200;
                $return["msg"] = "成功,即将重新登录";
                Session::delete("index_user");
            }else{
                $return["code"] = 201;
                $return["msg"] = "请稍后再试";

            }
            return json($return);
        }


        View::assign("user",$user);
        return view();
    }

    //修改用户头像
    public function change_headimgurl()
    {
        $uid = Session::get("index_user.id");
        $user = \app\model\User::find($uid);
        if(\think\facade\Request::isPost()){
            $data = \think\facade\Request::post();

            $res = \app\model\User::where("id",$uid)->update(["headimgurl"=>$data["head"]]);
            if($res){
                $return["code"] = 200;
                $return["msg"] = "成功";
            }else{
                $return["code"] = 201;
                $return["msg"] = "请稍后再试";

            }
            return json($return);
        }


        View::assign("user",$user);
        return view();
    }

    public function my_comment()
    {

        $list = \app\model\Comment::with(["cont","user"])
            ->where("status",1)
            ->paginate();
        View::assign("list",$list);
        return \view();
    }

    //删除我的留言
    public function del_comment()
    {
        $id = \think\facade\Request::param("id");
        $res = \app\model\Comment::where('id',$id)->delete();
        if($res){
            $return["code"] = 200;
            $return["msg"] = "成功";
        }else{
            $return["code"] = 201;
            $return["msg"] = "请稍后再试";

        }
        return json($return);
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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
    public function read(Request $id)
    {
        //
        p($id);
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
