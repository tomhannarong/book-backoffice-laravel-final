<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestSellerEbook extends Model
{
    protected $table = 'ebook_bestseller';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'product_id','seq','post_date','ip','pv','sale_qty','device','best_type','is_ebook'
       ];
}
