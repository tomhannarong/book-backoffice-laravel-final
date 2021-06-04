<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTran extends Model
{
    protected $table = 'order_tran';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'order_id','book_id','quantitys','price','percent_discount','discount','net','username','product_price','share_percent','approve_status'
        ,'approve_date' ,'is_ebook'
       ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class, 'book_id', 'id');
    }
}
