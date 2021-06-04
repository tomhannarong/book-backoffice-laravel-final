<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contactUs extends Model
{
    protected $table = 'contact_us';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'topic' ,'name', 'email','tel', 'message' , 'read'
       ];
}
