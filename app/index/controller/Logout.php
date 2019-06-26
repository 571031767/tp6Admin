<?php

namespace app\index\controller;

use app\BaseController;

use app\model\User;

use think\facade\Session;
use think\Request;
use think\exception\ValidateException;
//qq571031767  微博：@沙坪坝韩宇
class Logout extends BaseController
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
        $user = Session::get("index_user");
        Session::delete("index_user");
        $url = url("index/login/index");
        return redirect($url);
    }


}