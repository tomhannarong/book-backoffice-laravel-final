<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageSlip extends Model
{
    protected $table = 'image_slips';

    protected $primaryKey = 'id';

    protected $fillable = [
        'filename','order_id'
       ];
}
