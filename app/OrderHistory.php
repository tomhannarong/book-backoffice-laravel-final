<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = 'order_history';

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_id' , 'order_id', 'username', 'price', 'product_price', 'quantitys', 'percent_discount', 'discount', 
        'net', 'share_percent', 'buffet', 'is_ebook'
       ];
}
