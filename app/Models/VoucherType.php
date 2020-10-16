<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VoucherType extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','code','description','acronym'];

}
