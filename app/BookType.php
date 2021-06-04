<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    //
    protected $table = 'book_type';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'book_type'
       ];
}
