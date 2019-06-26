<?php

namespace app\model;

use think\Model;

/**
 * qq571031767  url:micuer.com
 */
class Article extends Model
{
    protected  $autoWriteTimestamp = true;
    public function cont(){
        return $this->hasOne("Content","contentid","id");
    }
}
