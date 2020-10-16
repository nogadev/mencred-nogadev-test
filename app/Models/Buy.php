<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Buy extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'company_id','supplier_id','date','voucher_type_id','subsidiary_number',
        'voucher_number','net_1','net_2','net_3','net_4','net_5',
        'tax_percentage_1','tax_percentage_2','tax_percentage_3','tax_percentage_4','tax_percentage_5',
        'tax_1','tax_2','tax_3','tax_4','tax_5',
        'net_not_taxed','net_exempt',
        'perception_gain_base','perception_gain_percentage','perception_gain',
        'perception_iibb_base','perception_iibb_percentage','perception_iibb',
        'perception_iva_base','perception_iva_percentage','perception_iva',
        'internal_taxes_base','internal_taxes_percentage','internal_taxes',
        'municipal_taxes_base','municipal_taxes_percentage','municipal_taxes',
        'bonus_percentage','bonus','total','comments',
        'perception_iibb'
    ];

    //Relations
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }
    public function voucherType(){
        return $this->belongsTo('App\Models\VoucherType');
    }
    public function buyArticle(){
        return $this->hasMany('App\Models\BuyArticle');
    }

    public function articles(){
        return $this->belongsToMany(Article::Class)->using(BuyArticle::Class);
    }
}
