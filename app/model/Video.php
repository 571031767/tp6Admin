<?php

namespace app\model;

use think\Model;

/**
 * qq571031767  url:micuer.com
 */
class Video extends Model
{
    protected  $autoWriteTimestamp = true;
    public function cont(){
        return $this->hasOne("Content","contentid","id");
    }
    //多态关联定义
    public function contentid()
    {
        return $this->morphOne(Content::class, 'contentaid');
    }
}
