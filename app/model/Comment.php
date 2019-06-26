<?php

namespace app\model;

use think\Model;

/**
 * qq571031767  url:micuer.com
 */
class Comment extends Model
{
    protected $autoWriteTimestamp = true;
    public function user()
    {
        return $this->hasOne("User","id","id");
    }

    public function cont(){
        return $this->hasOne("Content","id","contentid");
    }
}
