<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class slide extends Model
{
    protected $table = 'slide';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'id','slide_name','slide_images','first_page','cart_page','cartb_page','carts_page','buffet_page','is_active'
       ];
}
