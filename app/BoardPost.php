<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardPost extends Model
{
    protected $table = 'board_post';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'topic' , 'username', 'post_date', 'view', 'post_description', 'show_status', 'pin', 'lastupdate'
       ];
}
