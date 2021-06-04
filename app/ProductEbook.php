<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductEbook extends Model
{
    protected $table = 'ebook_product';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [ 
        'product_name','cat_id','product_image','product_thumb_image','promote_link','product_description',
        'product_pdf','product_pdf2','add_date','last_modified','alias_price','product_price','affiliate_price'
        ,'sale_qty','username','publish1','best_seller','recommended','hot_item','user_book','alias1','publishing1',
        'serie_set','preview','enable','ISBN','public_show'
    ];
}
