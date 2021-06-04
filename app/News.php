<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'web_news';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'head_news' , 'news_detail', 'username', 'news_date'
       ];
}
