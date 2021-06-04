<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranferEbook extends Model
{
    protected $table = 'ebook_order_payment';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'order_id','payment_id','username_customer','username_receipt','total_order','bank_datetime','payment_method','remark1',
        'file1','order_status','approve_date','post_date','public_show','bank'
       ];
}
