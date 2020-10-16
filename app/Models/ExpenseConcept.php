<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseConcept extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name','subtract'
    ];

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function expenses(){
        return $this->hasMany(Expense::Class);
    }
    

}
