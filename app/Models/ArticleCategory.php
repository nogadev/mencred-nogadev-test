<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ArticleCategory extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name'];   

    //Relations
    public function articles(){
        return $this->hasMany('App\Article');
    }
    public function attributes(){
        return $this->hasMany('App\Models\Attribute');
    }
}
