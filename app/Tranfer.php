<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranfer extends Model
{
    protected $table = 'tranfer';

    protected $primaryKey = 'id';

    //public $incrementing = true;
    protected $fillable = [
        'tranfer_date','tranfer_time','inform_date','attach_slip','amount','account_tranfer','bank_tranfer','username','show_status','remark1','reason','tranfer_status'
       ];
       public function getImageSlip()
       {
           return $this->hasMany(ImageSlip::class,'order_id' ,'account_tranfer');
       }
       
}
