<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'quantity_min','quantity_max','discount'
       ];
}
