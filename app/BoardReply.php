<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardReply extends Model
{
    protected $table = 'board_reply';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'topic_id' , 'username', 'reply_date', 'ip_user', 'reply'
       ];
}
