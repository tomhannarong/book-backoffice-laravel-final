<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpCart extends Model
{
    protected $table = 'tmp_cart';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'book_id','username','quantity','blame_product','buffet','can_discount','user_id','is_ebook'
       ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'book_id' ,'id');
    }
}
