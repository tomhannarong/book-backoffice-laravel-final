<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebConfig extends Model
{
    protected $table = 'web_config';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'shop_name','logo','tag_title','tag_keyword','tag_description','publisher','address',
        'subdistric','distric','province','zipcode','tel','mobile_number','fax','email','email_news','buffet','share_admin','share_pub'
        ,'fee','cancel_time'
       ];
}
