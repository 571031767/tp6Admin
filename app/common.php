<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function deleteAll($path) {
    $op = dir($path);
    while(false != ($item = $op->read())) {
        if($item == '.' || $item == '..') {
            continue;
        }
        if(is_dir($op->path.'/'.$item)) {
            deleteAll($op->path.'/'.$item);
            rmdir($op->path.'/'.$item);
        } else {
            unlink($op->path.'/'.$item);
        }

    }
}
//文章点击记录  status  1pc   2移动端
function ArticleHits($article_id='',$status=1){
    $data["article_id"] =$article_id;
    $data["uid"] =  \think\Session::get("uid");
    $data["add_time"] = time();
    return \app\common\model\ArticleHits::create($data);
}

/**
 * @param $typeId  对应users表中的status字段
 * 根据用户的类型 返回当前党员的状态  如在即党员  预备党员 等
 * 1：在籍党员
2：历史党员
3：流入党员
4：失联党员
5：申请人
6：积极分子
7：发展对象
8：预备党员
0：默认
 */
function userType($typeId){
    switch ($typeId){
        case 1:
            return "在籍党员";
        case 2:
            return "历史党员";
        case 3:
            return "流入党员";
        case 4:
            return "失联党员";
        case 5:
            return "申请人";
        case 6:
            return "积极分子";
        case 7:
            return "预备党员";
        case 0:
            return "注册会员";
        default:
            return "带完善";
    }
}

/**
 * @param $num
 * 根据当前用户的状态，返回用户所处的流程步骤
 1:入党申请阶段
2：入党积极分子阶段
3：发展对象阶段
4：预备党员阶段
5：正式党员阶段
 */
function JoinPartyStep($num){
    switch ($num){
        case 1:
            return "入党申请阶段";
        case 2:
            return "入党积极分子阶段";
        case 3:
            return "发展对象阶段";
        case 4:
            return "预备党员阶段";
        case 5:
            return "正式党员阶段";
        case 0:
            return "普通会员";
        default:
            return "带完善";
    }
}

function p($res){
    echo '<pre>';
    print_r($res);
    echo '</pre>';
}


//将分类组合1维数组
function unlimitforlevel($cate,$html="___", $pid=0,$level=0){
    $arr = array();
    foreach($cate as $v){
        if($v['pid'] == $pid){
            $v['level']=$level + 1;

            $v['html'] =str_repeat($html,$level);

            $arr[] = $v;
            $arr = array_merge($arr,unlimitforlevel($cate , $html ,$v['id'] , $level+1));
        }

    }
    return $arr;
}
//组合多维数组
function unlimitforlayer($cate,$name = 'child', $pid=0){
    $arr = array();
    foreach($cate as $v){
        if($v['pid'] == $pid){
            $v[$name]=unlimitforlayer($cate ,$name, $v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}

//组合多维数组
function forztree($cate,$name = 'children', $pid=0){
    $arr = array();
    foreach($cate as $v){
        if($v['pid'] == $pid){
            $v[$name]=unlimitforlayer($cate ,$name, $v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * @param $param
 * @return string
 * url组合成新的条件 复制给a  适合多条件搜索模板
 * php 多条件搜索的a 连接的url怎么解决  解决方案 powered by qq571031767 微博沙坪坝韩宇
 */

function geturi($param) {
    $url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], "?") ? "" : "?") . $param;
    $parse = parse_url($url);
    if (isset($parse["query"])) {
        parse_str($parse["query"], $params);
        $res = explode("=",$param);
        $res[0] = substr($res[0],1);
        unset($params[$res[0]]);
        $params[$res[0]] = $res[1];
        $url = $parse["path"] . "?" . http_build_query($params);
        return urldecode($url);
    } else {
        return urldecode($url);
    }
}

/**
 * 发送短信函数
 * @param $phone
 * @param $msg
 */
function sendMsg($phone,$msg){
        $statusStr = array(
            "0" => "短信发送成功",
            "-1" => "参数不全",
            "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
            "30" => "密码错误",
            "40" => "账号不存在",
            "41" => "余额不足",
            "42" => "帐户已过期",
            "43" => "IP地址限制",
            "50" => "内容含有敏感词"
        );
        $smsapi = "http://api.smsbao.com/";
        $user = config('conf.dxb_username');                 //短信平台帐号
        $pass = md5(config('conf.dxb_password'));            //短信平台密码
        $content=$msg;
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl);

        $v["phone"]=array("in",explode(",",$phone));
        $users=\think\Db::name("users")->where($v)->select();
        //根据手机号存储用户id
        if($users){
            $uid=[];
            foreach ($users as $k=>$v){
                $uid[]=$v["id"];
            }
        }
        else{
            $uid="error-联系开发者！";
        }

        $data["phone"]=$phone;
        $data["content"]=$msg;
        $data["add_time"]=time();
        $data["userid"]=session("uid");
        $data["uid"]=implode(",",$uid);
        $data["status"]=$statusStr[$result];
        \think\Db::name("message")->insertGetId($data);

        return $statusStr[$result];

    }


/**
 * @param $name
 * 快速引用百度富文本编辑器
 */
function ueditor($name,$width="96%",$height="500",$content=''){
    $width = $width."px";
    $height = $height."px";

    $editor_script_cache = <<<TTT
     <script type="text/javascript" charset="utf-8" src="//{$_SERVER['HTTP_HOST']}/static/ueditor/ueditor.config.js?t=20190107"></script>
     <script type="text/javascript" charset="utf-8" src="//{$_SERVER['HTTP_HOST']}/static/ueditor/ueditor.all.min.js?t=20190107"> </script>

    <script type="text/javascript" charset="utf-8" src="//{$_SERVER['HTTP_HOST']}/static/ueditor/lang/zh-cn/zh-cn.js?t=20190107"></script>
TTT;

    echo $editor_script_cache;
    echo '<textarea id="'.$name.'" name="'.$name.'" type="text/plain" style="width:'.$width.';height:'.$height.'; margin-top: 30px;">'.$content.'</textarea>';
    $str = <<<EOT
    <script type="text/javascript">

    var ue = UE.getEditor('{$name}', {
        toolbars: [
        [
            'source', //源代码
//            'anchor', //锚点
            'undo', //撤销
            'redo', //重做
            'bold', //加粗
//            'indent', //首行缩进
//            'snapscreen', //截图
            'italic', //斜体
            'underline', //下划线
            'strikethrough', //删除线
//            'subscript', //下标
//            'fontborder', //字符边框
//            'superscript', //上标
            'blockquote', //引用
//            'pasteplain', //纯文本粘贴模式
//            'horizontal', //分隔线
//            'time', //时间
//            'date', //日期
//            'insertrow', //前插入行
//            'insertcol', //前插入列
//            'mergeright', //右合并单元格
//            'mergedown', //下合并单元格
//            'deleterow', //删除行
//            'deletecol', //删除列
//            'splittorows', //拆分成行
//            'splittocols', //拆分成列
//            'splittocells', //完全拆分单元格
//            'deletecaption', //删除表格标题
            'inserttitle', //插入标题
//            'mergecells', //合并多个单元格
//            'deletetable', //删除表格
//            'insertparagraphbeforetable', //"表格前插入行"
//             'insertcode', //代码语言
            'fontfamily', //字体
            'fontsize', //字号
            'paragraph', //段落格式
            'customstyle', //自定义标题
//            'edittable', //表格属性
//            'edittd', //单元格属性
            'link', //超链接
            'unlink', //取消链接
//            'gmap', //Google地图
//            'help', //帮助
            'justifyleft', //居左对齐
            'justifyright', //居右对齐
            'justifycenter', //居中对齐
            'justifyjustify', //两端对齐
            'forecolor', //字体颜色
            'backcolor', //背景色
            'insertorderedlist', //有序列表
            'insertunorderedlist', //无序列表
            'fullscreen', //全屏
//            'directionalityltr', //从左向右输入
//            'directionalityrtl', //从右向左输入
//            'rowspacingtop', //段前距
//            'rowspacingbottom', //段后距
//            'pagebreak', //分页
//            'insertframe', //插入Iframe
//            'imagenone', //默认
//            'imageleft', //左浮动
//            'imageright', //右浮动
            'attachment', //附件
            'imagecenter', //居中
            'wordimage', //图片转存
            'lineheight', //行间距
//            'edittip ', //编辑提示
//            'webapp', //百度应用
//            'touppercase', //字母大写
//            'tolowercase', //字母小写
            'background', //背景
//            'template', //模板
            'scrawl', //涂鸦
            'music', //音乐
//            'inserttable', //插入表格
//            'drafts', // 从草稿箱加载
            'charts', // 图表
            'formatmatch', //格式刷
            'print', //打印
            'preview', //预览
            'selectall', //全选
            'removeformat', //清除格式
            'cleardoc', //清空文档
            'searchreplace', //查询替换
            'map', //Baidu地图
            'emotion', //表情
            // 'spechars', //特殊字符
            'simpleupload', //单图上传
            'insertimage', //多图上传
            'insertvideo', //视频
            'autotypeset', //自动排版
        ]
    ],
        autoHeightEnabled: true,
        autoFloatEnabled: true
    });
</script>
EOT;
    echo $str;
}

/**
 * 时间戳转换方法
 */
    function friendtime($time){
        if($time==null){
            $times=null;
        }
        else{
            $times=date("Y-m-d H:i:s",$time);
        }
        return $times;
    }


//将Unix时间戳转换成时间格式
function d($time){
    return date("Y-m-d H:i:s",$time);
}

//图像处理函数
function phpthumber($path,$width=123,$height=170){
    //return "/application/myclass/phpthumber/phpThumb.php?src={$path}&w={$width}&h={$height}";
    //"text.png_150_300.png"
    if(is_file(APP_PATH."../".$path)){

        if(!is_file(APP_PATH."../".$path."_".$width."_".$height.".png")){
            $image = \think\Image::open(APP_PATH."../".$path);
            $image->thumb($width,$height,\think\Image::THUMB_SOUTHEAST)->save(APP_PATH."../".$path."_".$width."_".$height.".png");
        }
        return $path."_".$width."_".$height.".png";
    }
    return "/static/dangjian/images/dangjian.png";
//
}

/**
 * 获取content列表

 * @param $cate_id
 * @param $limit
 * @param string $order
 * @param int $cache
 */
function content_list($cate_id=0,$limit=8,$order="id DESC",$where=1,$cache=true){
    if($cate_id == 0){
        $map = 1;
    }else{
        $map["cate_id"] = $cate_id;
    }

    $list = \app\model\Content::where($map)
        ->where($where)
        ->limit($limit)
        ->order($order)
        ->cache($cache)
        ->select();


    return $list;
}

/**
 * 获取单篇内容
 * @param int $id
 * @param int $cate_id
 * @param string $order
 * @param bool $cache
 * @return array|null|\think\Model
 */
function content($cate_id=0,$id = 0,$order="id DESC",$cache=true){
    if($cate_id == 0){
        $map = 1;
    }else{
        $map["cate_id"] = $cate_id;
    }
    if($id == 0){
        if(!is_array($map)){
            $map = 1;
        }
    }else{
        if(is_array($map)){
            $map["id"] = $id;
        }else{
            unset($map);
            $map["id"] = $id;
        }

    }
    $list = \app\model\Content::where($map)
        ->order($order)
        ->cache($cache)
        ->find();
    return $list;
}
