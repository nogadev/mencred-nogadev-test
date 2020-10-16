<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Collect extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['goal_amount','collected_amount', 'date_at', 'route_id'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['created_date','date_at'];


    public function route(){
    	return $this->belongsTo(Route::Class);
    }
    
    public function fees(){
        return $this->hasMany(Fee::Class);
    }

}
