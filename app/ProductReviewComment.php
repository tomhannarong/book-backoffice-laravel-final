<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReviewComment extends Model
{
    protected $table = 'product_review_comment';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'product_id','product_review_comment_id','username','message'
       ];
}
