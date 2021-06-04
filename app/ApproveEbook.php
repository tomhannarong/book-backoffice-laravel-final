<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApproveEbook extends Model
{
    protected $table = 'ebook_approve_ebook';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'username','product_id','order_id','tran_id','approve_status','approve_date'
       ];
}
