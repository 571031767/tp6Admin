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

    public function article()
    {
        return $this->hasOne(Article::class,"contentid");
    }

    public function video()
    {
        return $this->belongsTo(Video::class,"id");
    }

    public function soft()
    {
        return $this->hasOne(Soft::class,"contentid");
    }
    //多态关联定义
    public function contentid()
    {
        return $this->morphTo();
    }
}
