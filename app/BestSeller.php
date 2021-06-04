<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestSeller extends Model
{
    //

    protected $table = 'best_seller';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'top','book_name','alias','price','pim_time','isbn','writer','pages',
        'book_description','picture','pim_year','publisher_id','book_type_id','attachment','book_id'
       ];

    public function getProduct()
    {
        return $this->hasOne(Product::class,'id' ,'book_id');
    }
    public function getFavorBook()
    {
        return $this->hasOne(FavorBook::class,'book_id' ,'book_id');
    }
    
}
