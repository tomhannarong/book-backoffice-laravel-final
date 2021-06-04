<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    //
    protected $table = 'transport';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'transport','transport_rate','transport_description'
       ];

}
