<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Fee extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['credit_id','route_id','reason_id', 'number','paid_date','payment_amount','paid_amount'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['paid_date'];

    public function credit(){
    	return $this->belongsTo(Credit::Class);
    }

    public function reason(){
    	return $this->belongsTo(Reason::Class);
    }

    public function route(){
    	return $this->belongsTo(Route::Class);
    }

    public function detail(){
        return $this->hasOne(PaymentDetail::Class);
    }
}
