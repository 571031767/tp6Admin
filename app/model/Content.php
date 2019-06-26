<?php

namespace app\model;

use think\Model;

/**
 * qq571031767  url:micuer.com
 */
class Content extends Model
{
    protected $autoWriteTimestamp =true;
    //
    public function model()
    {
        return $this->hasOne("ContentModel","id","model_id");
    }
}
