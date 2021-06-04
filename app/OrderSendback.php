<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSendback extends Model
{
    protected $table = 'order_sendback';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'order_id','description'
       ];
}
