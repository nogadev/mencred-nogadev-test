<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'date','amount','expenseconcept_id','seller_id'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    protected $dates = ['date'];

    public function seller(){
        return $this->belongsTo(Seller::Class);
    }

    public function expenseconcept(){
        return $this->belongsTo(ExpenseConcept::Class);
    }
    

}
