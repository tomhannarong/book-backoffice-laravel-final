<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaitFiction extends Model
{
    protected $table = 'wait_fiction';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'book_name','alias','price','pim_time','isbn','writer','pages',
        'book_description','picture','pim_year','publisher_id','book_type_id'
       ];
}
