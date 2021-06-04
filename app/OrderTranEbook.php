<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTranEbook extends Model
{
    protected $table = 'ebook_order_tran';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'order_id','share_id','product_id','username','device','udid1','udid2','udid3','product_price','product_qty','total_price',
        'username_owner','share_percent','order_status','order_date','approve_date','paid_date','paid_time'
       ];
}
