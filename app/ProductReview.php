<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_review';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'product_id','username','message'
       ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'username' , 'product_review.username' );
    }
}
