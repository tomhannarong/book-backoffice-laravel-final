<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGalleryPhoto extends Model
{
    protected $table = 'product_gallery_photo';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [ 
        'product_id','photo' , 'default'
    ];
}
