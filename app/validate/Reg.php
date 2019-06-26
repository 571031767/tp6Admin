<?php

namespace app\validate;

use think\Validate;

class Reg extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'email' =>  'require|email',
        'phone'  =>  'require|number|length:11',
        'password' =>  'require',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'email'        => '邮箱格式错误',
        'email.require'   => '邮箱必须',
        'phone.require' => '不为空',
        'password.require' => '密码必须',
    ];
}
