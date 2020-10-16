<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Credit extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = ['customer_id','seller_id','delivery_id','status_id','user_id','guarantee','according','have_card','created_date','guarantee_date','card_date','confirm_date','init_date','fee_quantity','fee_amount','initial_payment','total_amount','unification','observation'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['created_date','guarantee_date','card_date','confirm_date','init_date'];


    public function customer(){
        return $this->belongsTo(Customer::Class)
                    ->with(['route','commerce','commercial_town','commercial_neighborhood','personal_town','personal_neighborhood','seller'])
                    ->orderBy('name');
    }

    public function seller(){
    	return $this->belongsTo(Seller::Class);
    }

    public function delivery(){
    	return $this->belongsTo(Delivery::Class);
    }

    public function status(){
    	return $this->belongsTo(Status::Class);
    }

    public function user(){
    	return $this->belongsTo(User::Class);
    }

    public function articles(){
    	return $this->belongsToMany(Article::Class, 'article_credits')
            ->withPivot(['price', 'quantity' ,'serial_number', 'article_id','credit_id', 'company_id','store_id','point_of_sale_id'])->withTimestamps();
    }

    public function fees(){
        return $this->hasMany(Fee::Class)
                    ->with(['reason']);
    }

    public function claims(){
        return $this->hasMany(Claim::Class);
    }

    public function lastNumberFee(){
        return $this->hasOne(Fee::Class)
            ->selectRaw('credit_id, max(number) as number')
            ->groupBy('credit_id');
    }

    public function totalPaid(){
        return $this->hasOne(Fee::Class)
            ->selectRaw('credit_id, sum(paid_amount) as paid_amount')
            ->groupBy('credit_id');
    }

    public function efectivity(){
        return $this->hasOne(Fee::Class)
            ->selectRaw('credit_id, ((sum(paid_amount) * 100) / total_amount) as efectivity')
            ->join('credits','credits.id','=','fees.credit_id')
            ->where('fees.paid_date', '<=', date('Y-m-d'))
            ->groupBy('credit_id');
    }

    public function getEfectivity(){
        if($this->efectivity){
            return $this->efectivity->efectivity;
        }else{
            return 0;
        }
    }

}
