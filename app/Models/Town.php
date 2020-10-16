<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Town extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'district_id'];

    //Relations
    public function district(){
        return $this->belongsTo('App\Models\District');
    }

    public function neighborhoods(){
        return $this->hasMany('App\Models\Neighborhood');
    }
}