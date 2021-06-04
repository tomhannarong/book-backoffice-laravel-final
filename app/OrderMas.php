<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderMas extends Model
{
    protected $table = 'order_mas';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'order_date','order_time','username','payment','transport','transport_rate','net_price','order_status',
        'show_status','tranfer_address','tracking_number','confirmation','date_paid','fullname','address_subdistric','address_distric',
        'address_province','address_zipcode','user_id','approve_status','approve_date','approve_time','paid_time','reason','phone','book_available'
       ];

    public function getProduct()
    {
        return $this->belongsToMany(Product::class,'order_tran' ,'order_id','book_id');
    }
    public function getReason()
    {
        return $this->hasMany(OrderSendback::class, 'order_id', 'id');
    }
    public function getUser()
    {
        return $this->hasOne(User::class,'username','username');
    }
    public function getOrderTran()
    {
        return $this->hasMany(OrderTran::class, 'order_id', 'id')
        ->leftJoin('product','product.id' ,'order_tran.book_id')
        ->leftJoin('product_gallery_photo', function ($join) {
            $join->on('product_gallery_photo.product_id', '=', 'order_tran.book_id');
            $join->on('product_gallery_photo.default', '=', DB::raw("'true'"));
        })
        
        ->select('product.ISBN','product.book_name','product.buffet','order_tran.*','product_gallery_photo.photo');
    }
    public function getTranfer()
    {
        return $this->hasOne(Tranfer::class, 'account_tranfer', 'id');
    }
    public function getImageSlip()
    {
        return $this->hasMany(ImageSlip::class, 'order_id', 'id');
    }
        
    
}
