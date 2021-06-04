<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductLink extends Model
{
    protected $table = 'product_link';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'product_name'
       ];
}
