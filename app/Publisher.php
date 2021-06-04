<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    //
    protected $table = 'publisher';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'publisher'
       ];
}
