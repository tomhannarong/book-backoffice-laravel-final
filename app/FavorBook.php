<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavorBook extends Model
{
    protected $table = 'favor_book';

    protected $primaryKey = 'id';

    protected $fillable = [
        'book_id','user_id','is_ebook'
       ];
}
