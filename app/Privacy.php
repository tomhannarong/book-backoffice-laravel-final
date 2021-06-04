<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $table = 'privacy';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'news_title','news_detail','approve_status'
       ];
}
