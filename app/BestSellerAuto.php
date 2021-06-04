<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestSellerAuto extends Model
{
    protected $table = 'ebook_bestseller';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'product_id','seq','post_date','ip','pv','sale_qty','device','best_type',
        'is_ebook'
       ];

    public function getProduct()
    {
        return $this->belongsTo(Product::class,'product_id' ,'id');
    }
    public function getFavorBook()
    {
        return $this->hasOne(FavorBook::class,'book_id' ,'product_id');
    }
    public function getApproveReadEbook()
    {
        return $this->hasOne(ApproveEbook::class,'product_id' ,'product_id');
    }
    public function getCartEbook()
    {
        return $this->hasOne(TmpCart::class,'book_id' ,'product_id');
    }
}
