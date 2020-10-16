<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentDetail extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
    	'number','payment_date','amount','owner_name','status_id','payment_method_id','bank_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected $dates = ['payment_date'];

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::Class);
    }

    public function bank(){
        return $this->belongsTo(Bank::Class,'bank_id', 'id');
    }

    public function movements(){
        return $this->belongsTo(CashMov::Class, 'id', 'reference');
    }
    

}
