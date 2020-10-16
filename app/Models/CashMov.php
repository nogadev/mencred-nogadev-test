<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CashMov extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'cash_movs';

    protected $fillable = ['id','cash_id','mov_reason_id','payment_method_id','amount','description','reference','method'];

    protected $hidden = ['created_at','updated_at'];

    public function cash()
    {
    	return $this->belongsTo(Cash::Class);
    }

    public function movreasons()
    {
        return $this->belongsTo(MovReason::Class,'mov_reason_id', 'id');
    }


    public function ingresos(){
        return $this->hasOne(CashMov::Class)
            ->selectRaw('cash_id, sum(amount) as total')
            ->where('mov_type_id','=',1)
            ->groupBy('cash_id');
    }

    public function paymentmethods(){
    	return $this->belongsTo(PaymentMethod::Class, 'payment_method_id');
    }

    public function checks(){
        return $this->belongsTo(PaymentDetail::Class, 'reference', 'id');
    }
}

