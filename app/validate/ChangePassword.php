<?php

namespace app\validate;

use think\Validate;

class ChangePassword extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'old_password|原密碼' =>  'require|length:4,25',
        'new_password|新密碼' =>  'require|length:4,25',
        'confirm_password|確認新密碼' =>  'require|length:4,25|confirm:new_password',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [

    ];
}
