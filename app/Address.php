<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'fullname','tel','address','subdistric','distric','province','zipcode','user_id','default'
       ];
}
