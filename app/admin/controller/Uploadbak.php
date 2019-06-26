<?php
/**
 * Created by PhpStorm.
 * User: 微博@沙坪坝韩宇，qq571031767
 * Date: 2017/6/20
 * Time: 14:27
 */
namespace app\admin\controller;


/**
 * Class Upload
 * @package app\admin\controller
 * upload 再6.0的文档未更新之前的上传
 *
 * 文档更新后已将此功能更新至最新框架支持
 */







class Upload
{

    public function upload()
    {
        //由于 tp 6的上传目前错在问题，故暂由此方法代替上传  后续更新升级 20190620

        //图片文件不能以中文名

        $path = __DIR__."/../../../public/uploads/".date("Ymd")."/";
        if (
            (
                    ($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/png")
            )
            &&
            ($_FILES["file"]["size"] < 5*1024*1024)
        )
        {
            if ($_FILES["file"]["error"] > 0)
            {
                return json(["code"=>204,"msg"=>"文件错误"]);
            }
            else
            {
//                echo "Upload: " . $_FILES["file"]["name"] . "<br />";
//                echo "Type: " . $_FILES["file"]["type"] . "<br />";
//                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
//                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
                if(!is_dir($path)){
                    mkdir($path,"0777");
                }
                if (file_exists($path . $_FILES["file"]["name"]))
                {
                    return json(["code"=>204,"msg"=>"文件名冲突"]);
                }
                else
                {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        $path . $_FILES["file"]["name"]);
                    $returnPath = "/uploads/".date("Ymd")."/".$_FILES["file"]["name"];
                    return json(["code"=>200,"msg"=>"成功","data"=>$returnPath]);
                }
            }
        }
        else
        {
            return json(["code"=>204,"msg"=>"类型错误或大小不符"]);
        }
    }

    public function head()
    {
        //由于 tp 6的上传目前错在问题，故暂由此方法代替上传  后续更新升级 20190620

        //图片文件不能以中文名

        $path = __DIR__."/../../../public/uploads/head/".date("Ymd")."/";
        if (
            (
                ($_FILES["file"]["type"] == "image/gif")
                || ($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/png")
            )
            &&
            ($_FILES["file"]["size"] < 5*1024*1024)
        )
        {
            if ($_FILES["file"]["error"] > 0)
            {
                return json(["code"=>204,"msg"=>"文件错误"]);
            }
            else
            {
                if(!is_dir($path)){
                    mkdir($path,"0777");
                }
                if (file_exists($path .time(). $_FILES["file"]["name"]))
                {
                    return json(["code"=>204,"msg"=>"文件名冲突"]);
                }
                else
                {
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        $path .time(). $_FILES["file"]["name"]);
                    $returnPath["src"] = "/uploads/head/".date("Ymd")."/".time().$_FILES["file"]["name"];

                    return json(["code"=>0,"msg"=>"成功","data"=>$returnPath]);
                }
            }
        }
        else
        {
            return json(["code"=>204,"msg"=>"类型错误或大小不符"]);
        }
    }


}