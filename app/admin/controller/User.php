<?php

namespace app\admin\controller;


use think\facade\Session;
use think\facade\View;
use think\exception\ValidateException;
//qq571031767  微博：@沙坪坝韩宇
class User extends Common
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    //用户个人信息
    public function profile()
    {
        if(\think\facade\Request::isAjax()){
            $data = \think\facade\Request::post();
            unset($data{"file"});
            $res = \app\model\User::where("id",Session::get("admin_user.id"))
                ->save($data);
            if($res){
                //更新session信息
                $user = \app\model\User::where("id",Session::get("admin_user.id"))->find()->toArray();
                Session::set("admin_user",$user);
                return json(["code"=>200,"msg"=>"成功"]);
            }else{
                return json(["code"=>204,"msg"=>"请稍后再试"]);
            }
        }
        View::assign("user",Session::get("admin_user"));
        View::assign("title","个人信息");
        return View::fetch();
    }

    //後台用戶修改密碼
    public function change_password()
    {
        if (\think\facade\Request::isAjax()){
            $data = \think\facade\Request::post();
            try {
                $result = validate(\app\validate\ChangePassword::class)->check($data);

                if (true !== $result) {
                    // 验证失败 输出错误信息
                    $return["code"] = 201;
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
            $res = \app\model\User::where("id",Session::get("admin_user.id"))
                ->save(["password"=>$data["new_password"]]);
            if($res){
                return json(["code"=>200,"msg"=>"成功"]);
            }else{
                return json(["code"=>204,"msg"=>"请稍后再试"]);
            }
        }
        View::assign("title","修改密碼");
        return View::fetch();
    }

    //用戶退出登錄
    public function logout()
    {
        Session::set("admin_user","");
        Session::set("index_user","");
        $this->redirect(url("index/index/index"));
    }

}
