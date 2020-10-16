<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EntityType extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','name'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    const ARTICLE = 1;
    const INVOICE = 2;

    public function files()
    {
    	return $this->hasMany(FileDetail::Class);
    }
}
