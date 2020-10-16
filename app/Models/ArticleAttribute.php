<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleAttribute extends Model
{
    //Relations
    public function article(){
        return $this->belongsTo('App\Article');
    }
    public function attribute(){
        return $this->belongsTo('App\Models\Attribute');
    }
}
