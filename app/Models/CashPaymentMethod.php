<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CashPaymentMethod extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','cash_id','payment_method_id','amount'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function cash()
    {
        return $this->belongsTo(Cash::Class);
    }

}