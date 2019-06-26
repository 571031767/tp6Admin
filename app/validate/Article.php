<?php

namespace app\validate;

use think\Validate;

class Article extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'title' =>  'require|max:25|min:6',
        'info' =>  'require|min:50',
        'cate_id' =>  'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [

        'title.require'   => '标题不能空',
        'title.max'   => '标题最多25个字',
        'title.max'   => '标题不能低于6个字',
        'info.require'   => '内容不能为空',
        'info.require'   => '内容最低50字',
        'cate_id.require'   => '请选择分类',


    ];
}
