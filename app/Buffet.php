<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buffet extends Model
{
    protected $table = 'buffet';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'book_number' ,'total_price', 'book_price'
       ];
}
