<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderMasEbook extends Model
{
    protected $table = 'ebook_order_mas';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'share_id','order_date','order_time','username','device','total_order','payment_id','order_status',
        'username_receipt','approve_status','approve_date','approve_time','paid_date','paid_time','pay_method'
       ];
}
