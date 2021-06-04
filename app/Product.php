<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [ 
        'book_name','book_type_id','writer','alias','price','pages','book_description','picture','attachment','stock','on_market','ISBN','pim_time'
        ,'pim_year','publisher_id','tag_description','tag_keyword','blame_product','serie_product','blame_position','blame_images','show_blame',
        'blog_url','youtube_url','buffet','stock_total','stock_hold','stock_remain','stock_sold','public_show','can_discount','book_weight' ,
        'product_price','promote_link','product_pdf','affiliate_price','username','publish1','best_seller','recommended','hot_item','user_book','is_ebook' ,
        'rate' ,'rate_num','rate_one_num' ,'rate_two_num','rate_three_num','rate_four_num','rate_five_num','comment_num'
          
    ];

    public function getPublisher()
    {
        return $this->hasOne(Publisher::class,'id' ,'publisher_id');
    }
    public function getFavorBook()
    {
        return $this->hasOne(FavorBook::class,'book_id' ,'id');
    }
    public function getApproveReadEbook()
    {
        return $this->hasOne(ApproveEbook::class,'product_id' ,'id');
    }
    public function getCartEbook()
    {
        return $this->hasOne(TmpCart::class,'book_id' ,'id');
    }
    public function getBookType()
    {
        return $this->hasOne(BookType::class,'id' ,'book_type_id');
    }
    public function getPhoto()
    {
        return $this->hasMany(ProductGalleryPhoto::class,'product_id' ,'id');
    }
    
    
}


