<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductRate extends Model
{
    protected $table = 'product_rate';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'product_id','username','rate'
       ];
}
