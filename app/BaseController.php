<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app;

use app\model\ArticleCate;
use app\model\Link;
use app\model\Nav;
use app\model\Setting;
use app\model\Tags;
use think\App;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\Db;
use think\facade\View;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {

        if(!Cache::get("conf")){
            $conf = Db::name("setting")->where(1)->group("name")->select();
            foreach($conf as $k => $v){
                Cache::set($v["name"],$v["data"]);
            }
            Cache::set("conf",1); // 是否储存了配置缓存
        }

        if(Cache::get("site_status")!=1){
          return Cache::get("closed_reason");
        }

        //友情链接
        if(!Cache::get("links")){
            $links = Link::where(1)->limit(10)->order("ordid DESC")->select()->toArray();
            Cache::set("links",$links);
        }
        View::assign("links",Cache::get("links"));

        //文章分类  -  首页仅限2级分类
        if(!Cache::get("cate")) {
            $cate = Nav::where(1)->select()->toArray();
            $cate = unlimitforlayer($cate);
            Cache::set("cate", $cate);
        }
        View::assign("cate",Cache::get("cate"));
//        Cache::clear();
        View::assign("static","//127.0.0.1:8000/static");

        //网站标签
        $tags = Tags::where(1)->cache(true)->limit(30)->select();
        View::assign("tags",$tags);

    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

}
