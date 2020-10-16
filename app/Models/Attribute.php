<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Attribute extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name','article_category_id'
    ];

    //Relations
    public function articleCategory(){
        return $this->belongsTo('App\Models\ArticleCategory');
    }
    public function articles(){
        return $this->hasMany('App\ArticleAttribute');
    }
}
