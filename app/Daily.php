<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    protected $table = 'daily';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'DATE','NUM'
       ];
}
