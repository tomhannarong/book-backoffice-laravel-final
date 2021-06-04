<?php

namespace App\Http\Controllers;

use App\OrderMas;
use App\OrderTran;
use App\Tranfer;
use App\User;
use App\Product;
use App\WebConfig;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;

class OrderMasController extends Controller
{
    private $title_index , $fn_index ,$val_index = "";

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        
        // $data = OrderMas::with(['getTranfer','getImageSlip','getUser','getOrderTran'])->where("id" , "32528")->first();
        // DD($data);
        // viewOrderDetail
        // DD(OrderMas::with(['getTranfer','getReason'])->limit(10)->get());

        if(request()->ajax()) {  
            $data = null;
            $this->title_index = "Trash";   
            $status_text = '';
            $filter_text = '';
            if(!empty($request->status)){
                if($request->status === "wait-for-pay"){
                    $status_text = 'รอชำระเงิน';
                }else if($request->status === "check"){
                    $status_text = 'รอตรวจสอบ';
                }else if($request->status === "paid"){
                    $status_text = 'ชำระเงินแล้ว';
                }else if($request->status === "sent"){
                    $status_text = 'ชำระเงินแล้ว';
                }else if($request->status === "cancel"){
                    $status_text = 'ยกเลิก';
                    
                }
                else if($request->status === "cancelPeriod"){
                    $status_text = 'รอชำระเงิน';
                    
                }
                else if($request->status === "all"){
                    $status_text = '';
                }
            }
            
            

            
                           
            if(!empty($request->fn) ){
                if($request->fn === "trash"){ //จัดส่งแล้ว
                    $this->title_index = "Delete";
                    $this->fn_index = "trash";
                    
                        $data = OrderMas::with(['getTranfer']);
                        if($request->status){
                            $data->where('order_status' , $status_text);
                        }
                        $data = $data->orderBy('id','DESC')->get();
                }  
                if($request->fn === "cancel"){ //ยกเลิกแล้ว
                        $data = OrderMas::with(['getTranfer']);
                        if($request->status){
                            $data->where('order_status' , "ยกเลิก");
                        }
                        $data = $data->orderBy('id','DESC')->get();
                }  
                if($request->fn === "count_noti"){ //noti order master
                         // noti_wait_pay = "0";  //รอตรวจสอบ
                        // noti_paid = "0" ; //ชำระเงินแล้ว
                        // noti_refund = "0" //ขอคืนเงิน
                        // noti_order_all = "0" //order all
                        // noti_approve_ebook = "0" //approve e-book
                    $noti_wait_pay = OrderMas::where('order_status' , "รอตรวจสอบ")->count();

                    $noti_paid = OrderMas::where(function($query){
                        $query->where('book_available' , "y");
                        $query->orWhereNull('book_available');
                    })->whereNull('tracking_number')->where('order_status','ชำระเงินแล้ว')->count();

                    $noti_refund = OrderMas::where('order_status' , "ขอคืนเงิน")->count();

                    $noti_order_all = $noti_wait_pay + $noti_paid + $noti_refund ;
                    $noti_approve_ebook = OrderMas::where('order_status' , "ชำระเงินแล้ว")
                                        ->where('approve_status' , "n")
                                        ->whereNull('approve_date')->whereNull('approve_time')->count();


                    return response()->json(['success'=>'Item View successfully.' , 'noti_wait_pay' => $noti_wait_pay , 'noti_paid' => $noti_paid , 'noti_refund' => $noti_refund , 'noti_order_all' => $noti_order_all , 'noti_approve_ebook' => $noti_approve_ebook]);
                } 

                if($request->fn === "count_noti_sidebar"){ //noti sidebar
                    $noti_wait_pay = OrderMas::where('order_status' , "รอตรวจสอบ")->count();

                    $noti_paid = OrderMas::where(function($query){
                        $query->where('book_available' , "y");
                        $query->orWhereNull('book_available');
                    })->whereNull('tracking_number')->where('order_status','ชำระเงินแล้ว')->count();

                    $noti_wait_approve = OrderMas::where('order_status' , "ชำระเงินแล้ว")
                    ->where('approve_status' , "n")
                    ->whereNull('approve_date')->whereNull('approve_time')->count();

                    return response()->json(['success'=>'Item View successfully.' , 'noti_wait_pay' => $noti_wait_pay , 'noti_paid' => $noti_paid , 'noti_wait_approve' => $noti_wait_approve ]);
                } 

                
                
                if($request->fn === "viewData"){ //ดูข้อมูล
                    $data = OrderMas::with(['getTranfer','getUser','getImageSlip'])->where("id" , $request->order_id)->first();
                    $sumTotalBook = 0 ;
                    $sumTotalEBook = 0 ;
                    $sumTotalQuantitys = 0 ;
                    $isDisableAction = '';
                    $html_footer = '';
                    $html = '';
                    $html .= '<div style="background-color: #092c4c;border-radius:15px;" class="col-sm-12 col-md-6 col-lg-3 mt-4 mb-4 p-2">
                                <font class="pl-4" style="color:#7E91A2;" >เลขที่สั่งซื้อ</font>
                                <font class="pl-3 text-white" style="" >'.$data->id.'</font>
                            </div>';
                            // 
                            if($data->order_status == "รอชำระเงิน"){

                    $html .= '<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                        <ul class="timeline">
                                            <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                            <li class="check "><font class="text_small">คำสั่งซื้อมีการชำระเงิน</font></li>
                                            <li class="check_pay "><font class="text_small">ตรวจสอบการชำระเงิน</font></li>
                                            <li class="approve_icon "><font class="text_small">อนุมัติ, จัดส่ง</font></li>
                                        </ul>
                                    </div>
                              </div>'; 

                    $html .='<div class="box-des py-2">
                                <div class="">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Customer Order</font>
                                        </div>
                                        <div class="express-box-body ">
                                            <div class="row">
                
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <table class="" style="width:100%">
                                                        
                                                        <tbody>
                                                            <tr class="spaceUnder">
                                                                <td width="40%" class="box-text">ประเภทหนังสือ</td>
                                                                <td width="60%" class="box-text-values">';
                                                                if($data->book_available == "y" ){
                                                    $html .= '           <span class="right badge badge-danger noti-book-type" >Book</span>';
                                                                }
                                                                if($data->approve_status){
                                                    $html .= '           <span class="right badge badge-danger noti-ebook-type" >E-Book</span>
                                                                        <span class="right badge badge-danger noti-book-type-order" style="background-color: white" data-toggle="popover" data-content="รออนุมัติ E-Book" data-trigger="hover" data-placement="bottom" data-original-title="" title="">!</span>';
                                                                }
                                                                    
                                                                    
                                                      $html .= '</td>
                                                            </tr>
                                                            <tr class="spaceUnder">
                
                                                                <td class="box-text">รวมราคาหนังสือ</td>
                                                                <td class="box-text-values">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                            </tr>
                                                            <tr class="spaceUnder">
                                                                <td class="box-text">ค่าจัดส่ง</td>
                                                                <td class="box-text-values">'.number_format(round((float)$data->transport_rate,0),0).' บาท ('.$data->transport.')</td>
                                                            </tr>
                                                            <tr class="spaceUnder">
                                                                <td class="box-text">รวมสุทธิ</td>
                                                                <td class="box-text-values-total font-medium">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <a class="btn btn-light btn_des_order_new_style" data-toggle="collapse" href="#action_des_order_new" role="button" aria-expanded="false" aria-controls="action_des_order_new">
                                                        รายละเอียดการสั่งซื้อ
                                                        <img class="icon_des_order_new_style" src="'.url('img/icon_pages/arrow_down.png').'">
                                                    </a>
                
                                                    <div class="collapse " id="action_des_order_new">
                                                    <div class="">
                                                        <div class="" style="padding-right: 0 ;padding-left: 0;">
                                                            <div class=" table-responsive" style="padding-left:0;padding-right:0">
                                                                <div >
                                                                
                                                                    <table class="text-left" style="width:100%;">
                                                                        
                                                                    
                                                                        <tbody >';
                                                                        if($data->book_available == "y"){ //Book Data
                                                                            $iBookSum = 0;
                                                                            $bookHeaderShow = "true";
                                                                            foreach ($data->getOrderTran as $val){
                                                                                if($val->is_ebook == "false"){
                                                                                    $iBookSum += 1 ;
                                                                                }
                                                                            }
                                                                            foreach ($data->getOrderTran as $val){
                                                                                if($val->is_ebook == "false"){
                                                                                    $sumTotalBook += $val->net ;
                                                                                    $sumTotalQuantitys += $val->quantitys;
                    
                                                            $html .= '   <tr class="table-body-type-book  spaceUnderSty2 highlighted">';
                                                                            if($bookHeaderShow == "true"){
                                                            $html .= '      <td  colspan="" rowspan="'.$iBookSum.'" class="table-header-type-book"><font class="table-header-type">Book</font></td>';
                                                                                
                                                                            }
                                                            $html .= '      <td  colspan="" ><img src="'.url('storage/book-images/'.($val->photo ?? '')).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                            <td  colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                            <td  colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                                            <td  colspan="2" class="box-text-values ';
                                                                            
                                                                            if($bookHeaderShow == "true"){
                                                            $html .= '      table-body-tr-top ';    
                                                                                $bookHeaderShow = "false";
                                                                            }
                                                                                        
                                                            $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                        </tr> ';
                    
                                                                                } 
                                                                            }
                    
                                                            $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                                            <td colspan="2" class="table-body-des-default"></td>
                                                                            <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ Book</td>
                                                                            <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalBook,2),2).' บาท</td>
                                                                        </tr> 
                                                                        
                                                                        ';
                                                                            
                                                                        }
                                                        
                                                                        if($data->approve_status){ //E-Book Data
                                                                            $iEBookSum = 0;
                                                                            $eBookHeaderShow = "true";
                                                                            foreach ($data->getOrderTran as $val){
                                                                                if($val->is_ebook == "true"){
                                                                                    $iEBookSum += 1 ;
                                                                                }
                                                                            }
                                                                            foreach ($data->getOrderTran as $val){
                                                                            
                                                                                if($val->is_ebook == "true"){
                                                                                    $sumTotalEBook += $val->net ;
                                                                                    $sumTotalQuantitys += $val->quantitys;
                                                                                
                                                            $html .= '   <tr class="table-body-type-ebook  spaceUnderSty2 highlighted">';
                                                                            if($eBookHeaderShow == "true"){
                                                            $html .= '      <td colspan="" rowspan="'.$iEBookSum.'" class="table-header-type-ebook"><font class="table-header-type">E-Book</font></td>';
                        
                                                                            }
                                                            $html .= '      
                                                                            <td colspan="" ><img src="'.url('storage/book-images/'.$val->photo).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                            <td colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                            <td colspan="" class="box-text-values text-right"><font class="num-text">'.$val->quantitys.'</font></td>
                                                                            <td colspan="2" class="box-text-values ';
                                                                            
                                                                            if($eBookHeaderShow == "true"){
                                                            $html .= '      table-body-tr-top ';    
                                                                                $eBookHeaderShow = "false";
                                                                            }
                                                                                                            
                                                            $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                        </tr> ';
                    
                                                                                }
                                                                            }
                    
                                                            $html .= '  <tr class="table-body-type-ebook  spaceUnderSty2">
                                                                            <td colspan="2" class="table-body-des-default"></td>
            
                                                                            <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ E-Book</td>
                                                                            <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalEBook,2),2).' บาท</td>
                                                                        </tr> 
                                                                        
                                                                        ';
                                                                            
                                                                        }
                                                            $html .= '  <tr class="spaceUnderSty2">
                                                                            <td colspan="8" class=""></td>   
                                                                        </tr>';
                    
                                                            $html .= '  <tr class="spaceUnder">
                                                                            <td colspan="3" class=""></td>                                                                       
                                                                            <td colspan="3" class="box-text-values text-left pl-4">รวมรายการทั้งหมด</td>                                                                        
                                                                            <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                                        </tr>
                                                                        <tr class="spaceUnder">
                                                                            <td colspan="3" class=""></td>                                                                 
                                                                            <td colspan="3" class="box-text-values text-left pl-4">ค่าจัดส่ง</td>                                          
                                                                            <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->transport_rate,2),2).' บาท</td>
                                                                        </tr>
                                                                        <tr class="spaceUnder">
                                                                            <td colspan="3" class=""></td>                                                                      
                                                                            <td colspan="3" class="box-text-values text-total-sub text-left pl-4">รวมสุทธิ</td>
                                                                            <td colspan="2" class="box-text-values-total text-right text-total-sum pr-4">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                                        </tr>';
                                                                        
                    
                                                                                    
                                                                $html .= '</tbody>
                                                                    </table>
                                                                </div>
                                                                
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                
                            </div>';
                                
                    
                            }elseif($data->order_status == "รอตรวจสอบ"){
                    $html .= '<div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                    <ul class="timeline">
                                        <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                        <li class="check active"><font class="text_normal">คำสั่งซื้อมีการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->getTranfer->inform_date).' '.formatTimeThai($data->getTranfer->inform_date).' น.'.'</font></li>
                                        <li class="check_pay "><font class="text_small">ตรวจสอบการชำระเงิน</font></li>
                                        <li class="approve_icon "><font class="text_small">อนุมัติ, จัดส่ง</font></li>
                                    </ul>
                                </div>
                             </div>';
                    $html .= '<div class="row py-2">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Pay-in Slip</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">โอนมายังธนาคาร</td>
                                                        <td width="60%" class="box-text-values">'.$data->getTranfer->bank_tranfer.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">

                                                        <td class="box-text">ผู้โอน</td>
                                                        <td class="box-text-values">'.$data->getTranfer->username.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">วันที่</td>
                                                        <td class="box-text-values">'.formatDateThai($data->getTranfer->tranfer_date.' '.$data->getTranfer->tranfer_time).'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">เวลา</td>
                                                        <td class="box-text-values">'.formatTimeThai($data->getTranfer->tranfer_date.' '.$data->getTranfer->tranfer_time).' น.</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">จำนวน</td>
                                                        <td class="box-text-values">'.number_format(round((float)$data->getTranfer->amount,0),0).' บาท</td>
                                                    </tr>                                            
                                                </tbody>
                                            </table>

                                            
                                            <div class="row div-image-slip">
                                                <div class="col">
                                                    <div class="" style="" >  
                                                        <div class="text-center">
                                                        <a data-gallery="photoviewer" data-title="'.$data->getImageSlip[0]->filename.'" data-group="a" id="show-img-photoviewer" 
                                                            href="'.url('storage/slip-images/'.$data->getImageSlip[0]->filename).'">
                                                            <img src="'.asset('storage/slip-images/thumbnail/'.$data->getImageSlip[0]->filename).'" data-img="'.asset('storage/slip-images/'.$data->getImageSlip[0]->filename).'" id="show-img" class="text-center image-slip show-image-payin" alt="">
                                                        </a>
                                                        </div>
                                                    
                                                        <div class="small-img">
                                                            <img src="'.url('img/icon_pages/online_icon_right@2x.png').'" class="icon-left text-left" alt="" id="prev-img">
                                                            <div class="small-container text-center">
                                                                <div id="small-img-roll">';

                                                                foreach ($data->getImageSlip as $image_slip){
                                                $html .= '            
                                                                            <img src="'.asset('storage/slip-images/thumbnail/'.$image_slip->filename).'" data-img="'.asset('storage/slip-images/'.$image_slip->filename).'" class="show-small-img image-slip-small text-center cropped2" alt="">
                                                                      ';
                                                                }
                                                $html .= '      </div>
                                                            </div>
                                                            <img src="'.url('img/icon_pages/online_icon_right@2x.png').'" class="icon-right" alt="" id="next-img">
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>
                                                
                                            

                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Customer Order</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">ประเภทหนังสือ</td>
                                                        <td width="60%" class="box-text-values">';
                                                            if($data->book_available == "y" ){
                                                $html .= '           <span class="right badge badge-danger noti-book-type" >Book</span>';
                                                            }
                                                            if($data->approve_status){
                                                $html .= '           <span class="right badge badge-danger noti-ebook-type" >E-Book</span>
                                                                    <span class="right badge badge-danger noti-book-type-order" style="background-color: white" data-toggle="popover" data-content="รออนุมัติ E-Book" data-trigger="hover" data-placement="bottom" data-original-title="" title="">!</span>';
                                                            }
                                                                        
                                                                          
                                               $html .= '</td>
                                                    </tr>
                                                    <tr class="spaceUnder">

                                                        <td class="box-text">รวมราคาสินค้า</td>
                                                        <td class="box-text-values">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">รวมสุทธิ</td>
                                                        <td class="box-text-values-total font-medium">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                    </tr>
                                                
                                                </tbody>
                                            </table>
                                            
                                            <a class="btn btn-light btn_des_order_new_style mt-4" data-toggle="collapse" href="#action_des_order_new" role="button" aria-expanded="false" aria-controls="action_des_order_new">
                                                รายละเอียดการสั่งซื้อ
                                                <img class="icon_des_order_new_style" src="'.url('img/icon_pages/arrow_down.png').'">
                                            </a>
                                            
                                            <div class="collapse" id="action_des_order_new" style="min-height:100px;">
                                                <div class="">
                                                    <div class="" style="padding-right: 0 ;padding-left: 0;">
                                                        <div class=" table-responsive" style="padding-left:0;padding-right:0">
                                                            <div >
                                                            
                                                                <table class="text-left" style="width:100%;">
                                                                    
                                                                   
                                                                    <tbody >';
                                                                    if($data->book_available == "y"){ //Book Data
                                                                        $iBookSum = 0;
                                                                        $bookHeaderShow = "true";
                                                                        foreach ($data->getOrderTran as $val){
                                                                            if($val->is_ebook == "false"){
                                                                                $iBookSum += 1 ;
                                                                            }
                                                                        }
                                                                        foreach ($data->getOrderTran as $val){
                                                                            if($val->is_ebook == "false"){
                                                                                $sumTotalBook += $val->net ;
                                                                                $sumTotalQuantitys += $val->quantitys;
                
                                                        $html .= '   <tr class="table-body-type-book  spaceUnderSty2 highlighted">';
                                                                        if($bookHeaderShow == "true"){
                                                        $html .= '      <td  colspan="" rowspan="'.$iBookSum.'" class="table-header-type-book"><font class="table-header-type">Book</font></td>';
                                                                            
                                                                        }
                                                        $html .= '      <td  colspan="" ><img src="'.url('storage/book-images/'.($val->photo ?? '')).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                        <td  colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                        <td  colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                                        <td  colspan="2" class="box-text-values ';
                                                                        
                                                                        if($bookHeaderShow == "true"){
                                                        $html .= '      table-body-tr-top ';    
                                                                            $bookHeaderShow = "false";
                                                                        }
                                                                                    
                                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                    </tr> ';
                
                                                                            } 
                                                                        }
                
                                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                                        <td colspan="2" class="table-body-des-default"></td>
                                                                        <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ Book</td>
                                                                        <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalBook,2),2).' บาท</td>
                                                                    </tr> 
                                                                    
                                                                    ';
                                                                        
                                                                    }
                                                       
                                                                    if($data->approve_status){ //E-Book Data
                                                                        $iEBookSum = 0;
                                                                        $eBookHeaderShow = "true";
                                                                        foreach ($data->getOrderTran as $val){
                                                                            if($val->is_ebook == "true"){
                                                                                $iEBookSum += 1 ;
                                                                            }
                                                                        }
                                                                        foreach ($data->getOrderTran as $val){
                                                                        
                                                                            if($val->is_ebook == "true"){
                                                                                $sumTotalEBook += $val->net ;
                                                                                $sumTotalQuantitys += $val->quantitys;
                                                                            
                                                        $html .= '   <tr class="table-body-type-ebook  spaceUnderSty2 highlighted">';
                                                                        if($eBookHeaderShow == "true"){
                                                        $html .= '      <td colspan="" rowspan="'.$iEBookSum.'" class="table-header-type-ebook"><font class="table-header-type">E-Book</font></td>';
                    
                                                                        }
                                                        $html .= '      
                                                                        <td colspan="" ><img src="'.url('storage/book-images/'.$val->photo).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                        <td colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                        <td colspan="" class="box-text-values text-right"><font class="num-text">'.$val->quantitys.'</font></td>
                                                                        <td colspan="2" class="box-text-values ';
                                                                        
                                                                        if($eBookHeaderShow == "true"){
                                                        $html .= '      table-body-tr-top ';    
                                                                            $eBookHeaderShow = "false";
                                                                        }
                                                                                                        
                                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                    </tr> ';
                
                                                                            }
                                                                        }
                
                                                        $html .= '  <tr class="table-body-type-ebook  spaceUnderSty2">
                                                                        <td colspan="2" class="table-body-des-default"></td>
        
                                                                        <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ E-Book</td>
                                                                        <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalEBook,2),2).' บาท</td>
                                                                    </tr> 
                                                                    
                                                                    ';
                                                                        
                                                                    }
                                                        $html .= '  <tr class="spaceUnderSty2">
                                                                        <td colspan="8" class=""></td>   
                                                                    </tr>';
                
                                                        $html .= '  <tr class="spaceUnder">
                                                                        <td colspan="3" class=""></td>                                                                       
                                                                        <td colspan="3" class="box-text-values text-left pl-4">รวมรายการทั้งหมด</td>                                                                        
                                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                                    </tr>
                                                                    <tr class="spaceUnder">
                                                                        <td colspan="3" class=""></td>                                                                 
                                                                        <td colspan="3" class="box-text-values text-left pl-4">ค่าจัดส่ง</td>                                          
                                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->transport_rate,2),2).' บาท</td>
                                                                    </tr>
                                                                    <tr class="spaceUnder">
                                                                        <td colspan="3" class=""></td>                                                                      
                                                                        <td colspan="3" class="box-text-values text-total-sub text-left pl-4">รวมสุทธิ</td>
                                                                        <td colspan="2" class="box-text-values-total text-right text-total-sum pr-4">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                                    </tr>';
                                                                    
                
                                                                                
                                                            $html .= '</tbody>
                                                                </table>
                                                            </div>
                                                            
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                                
                    
                                </div> ';
                    $html_footer .= '<div class="modal-footer order_status_footer">
                                        <a href="javascript:void(0)" class="btn btn-paid-success ml-2 btnNext" 
                                            data-id="'.$data->id.'" 
                                            data-val="'.$data->order_status.'" 
                                            data-id-tran="'.$data->getTranfer->id.'" data-fn="NextStage"><img src="'.url('img/icon_pages/correct.png').'"> <font>ยืนยันและอนุมัติ</font></a>
                                        <a href="javascript:void(0)" class="btn btn-paid-sendback ml-2 mr-4 btnRej" 
                                            data-id="'.$data->id.'" 
                                            data-val="'.$data->order_status.'" 
                                            data-id-tran="'.$data->getTranfer->id.'" data-fn="rollback" ><img src="'.url('img/icon_pages/sendback.png').'"> <font>ส่งกลับ</font></a>
                                    </div>';
                            }elseif($data->order_status == "ชำระเงินแล้ว"){

                                if($data->tracking_number){
                    $html .= '<div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                    <ul class="timeline">
                                            <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                            <li class="check active"><font class="text_normal">คำสั่งซื้อมีการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->getTranfer->inform_date).' '.formatTimeThai($data->getTranfer->inform_date).' น.'.'</font></li>
                                            <li class="check_pay active"><font class="text_normal">ตรวจสอบการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->date_paid).' '.formatTimeThai($data->paid_time).' น.'.'</font></li>
                                            <li class="approve_icon active"><font class="text_normal">อนุมัติ, จัดส่ง</font><br><font class="text_small">'.formatDateThai($data->updated_at).' '.formatTimeThai($data->updated_at).' น.'.'</font></li>
                                    </ul>
                                </div>
                             </div>';

                                }else{
                                    // have e-book only
                                    if($data->approve_status && (!$data->book_available || $data->book_available == "n")){
                    $html .= '  <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                        <ul class="timeline">
                                                <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                                <li class="check active"><font class="text_normal">คำสั่งซื้อมีการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->getTranfer->inform_date).' '.formatTimeThai($data->getTranfer->inform_date).' น.'.'</font></li>
                                                <li class="check_pay active"><font class="text_normal">ตรวจสอบการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->date_paid).' '.formatTimeThai($data->paid_time).' น.'.'</font></li>
                                                <li class="approve_icon active"><font class="text_normal">อนุมัติ, จัดส่ง</font></li>
                                        </ul>
                                    </div>
                                </div>';

                    
                                    }
                                    // have book only  
                                    
                                    if(!$data->approve_status && ($data->book_available && $data->book_available == "y") ) {
                    $html .= '  <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                        <ul class="timeline">
                                            <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                            <li class="check active"><font class="text_normal">คำสั่งซื้อมีการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->getTranfer->inform_date).' '.formatTimeThai($data->getTranfer->inform_date).' น.'.'</font></li>
                                            <li class="check_pay active"><font class="text_normal">ตรวจสอบการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->date_paid).' '.formatTimeThai($data->paid_time).' น.'.'</font></li>
                                            <li class="approve_icon"><font class="text_small">อนุมัติ, จัดส่ง</font><br><font class="text_small">'.formatDateThai($data->updated_at).' '.formatTimeThai($data->updated_at).' น.'.'</font></li>
                                        </ul>
                                    </div>
                                </div>';
                                    }
                                    // have book and e-book only 
                                    
                                    if($data->approve_status && ($data->book_available && $data->book_available == "y") ) {
                    $html .= '  <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                        <ul class="timeline">
                                            <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                            <li class="check active"><font class="text_normal">คำสั่งซื้อมีการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->getTranfer->inform_date).' '.formatTimeThai($data->getTranfer->inform_date).' น.'.'</font></li>
                                            <li class="check_pay active"><font class="text_normal">ตรวจสอบการชำระเงิน</font><br><font class="text_small">'.formatDateThai($data->date_paid).' '.formatTimeThai($data->paid_time).' น.'.'</font></li>
                                            <li class="approve_icon"><font class="text_small">อนุมัติ, จัดส่ง</font></li>
                                        </ul>
                                    </div>
                                </div>';
                                    }
                   
                                }

                    $html .= '<div class="row py-2">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Pay-in Slip</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">โอนมายังธนาคาร</td>
                                                        <td width="60%" class="box-text-values">'.$data->getTranfer->bank_tranfer.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">

                                                        <td class="box-text">ผู้โอน</td>
                                                        <td class="box-text-values">'.$data->getTranfer->username.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">วันที่</td>
                                                        <td class="box-text-values">'.formatDateThai($data->getTranfer->tranfer_date.' '.$data->getTranfer->tranfer_time).'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">เวลา</td>
                                                        <td class="box-text-values">'.formatTimeThai($data->getTranfer->tranfer_date.' '.$data->getTranfer->tranfer_time).' น.</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">จำนวน</td>
                                                        <td class="box-text-values">'.number_format(round((float)$data->getTranfer->amount,2),2).' บาท</td>
                                                    </tr>                                            
                                                </tbody>
                                                
                                            </table>

                                            <div class="row div-image-slip">
                                                <div class="col">
                                                    <div class="" style="" >  
                                                        <div class="text-center">
                                                            <a data-gallery="photoviewer" data-title="'.$data->getImageSlip[0]->filename.'" data-group="a" id="show-img-photoviewer" 
                                                                href="'.url('storage/slip-images/'.$data->getImageSlip[0]->filename).'">
                                                                <img src="'.asset('storage/slip-images/thumbnail/'.$data->getImageSlip[0]->filename).'" data-img="'.asset('storage/slip-images/'.$data->getImageSlip[0]->filename).'" id="show-img" class="text-center image-slip show-image-payin" alt="">
                                                            </a>
                                                        </div>
                                                    
                                                        <div class="small-img">
                                                            <img src="'.url('img/icon_pages/online_icon_right@2x.png').'" class="icon-left text-left" alt="" id="prev-img">
                                                            <div class="small-container text-center">
                                                                <div id="small-img-roll">';
                                                                foreach ($data->getImageSlip as $image_slip){
                                                $html .= '            <img src="'.asset('storage/slip-images/thumbnail/'.$image_slip->filename).'" data-img="'.asset('storage/slip-images/'.$image_slip->filename).'" class="show-small-img image-slip-small text-center cropped2" alt="">';
                                                                }
                                                $html .= '      </div>
                                                            </div>
                                                            <img src="'.url('img/icon_pages/online_icon_right@2x.png').'" class="icon-right" alt="" id="next-img">
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>

                                           

                                        </div>

                                            
                                        
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-4">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Customer Order</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">ประเภทหนังสือ</td>
                                                        <td width="60%" class="box-text-values">';
                                                            if($data->book_available == "y" ){
                                                $html .= '           <span class="right badge badge-danger noti-book-type" >Book</span>';
                                                            }
                                                            if($data->approve_status){
                                                $html .= '           <span class="right badge badge-danger noti-ebook-type" >E-Book</span>
                                                                    <span class="right badge badge-danger noti-book-type-order" style="background-color: white" data-toggle="popover" data-content="รออนุมัติ E-Book" data-trigger="hover" data-placement="bottom" data-original-title="" title="">!</span>';
                                                            }
                                                                        
                                                                          
                                               $html .= '</td>
                                                    </tr>
                                                    <tr class="spaceUnder">

                                                        <td class="box-text">รวมราคาสินค้า</td>
                                                        <td class="box-text-values">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">รวมสุทธิ</td>
                                                        <td class="box-text-values-total font-medium">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                    </tr>
                                                
                                                </tbody>
                                            </table>
                                            
                                            <a class="btn btn-light btn_des_order_new_style mt-4" data-toggle="collapse" href="#action_des_order_new" role="button" aria-expanded="false" aria-controls="action_des_order_new">
                                                รายละเอียดการสั่งซื้อ
                                                <img class="icon_des_order_new_style" src="'.url('img/icon_pages/arrow_down.png').'">
                                            </a>
                                            
                                            <div class="collapse " id="action_des_order_new" style="min-height:100px;">
                                                <div class="">
                                                    <div class="" style="padding-right: 0 ;padding-left: 0;">
                                                        <div class=" table-responsive" style="padding-left:0;padding-right:0">
                                                            <div >
                                                            
                                                                <table class="text-left" style="width:100%;">
                                                                    
                                                                
                                                                    <tbody >';
                                                                    if($data->book_available == "y"){ //Book Data
                                                                        $iBookSum = 0;
                                                                        $bookHeaderShow = "true";
                                                                        foreach ($data->getOrderTran as $val){
                                                                            if($val->is_ebook == "false"){
                                                                                $iBookSum += 1 ;
                                                                            }
                                                                        }
                                                                        foreach ($data->getOrderTran as $val){
                                                                            if($val->is_ebook == "false"){
                                                                                $sumTotalBook += $val->net ;
                                                                                $sumTotalQuantitys += $val->quantitys;
                
                                                        $html .= '   <tr class="table-body-type-book  spaceUnderSty2 highlighted">';
                                                                        if($bookHeaderShow == "true"){
                                                        $html .= '      <td  colspan="" rowspan="'.$iBookSum.'" class="table-header-type-book"><font class="table-header-type">Book</font></td>';
                                                                            
                                                                        }
                                                        $html .= '      <td  colspan="" ><img src="'.url('storage/book-images/'.($val->photo ?? '')).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                        <td  colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                        <td  colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                                        <td  colspan="2" class="box-text-values ';
                                                                        
                                                                        if($bookHeaderShow == "true"){
                                                        $html .= '      table-body-tr-top ';    
                                                                            $bookHeaderShow = "false";
                                                                        }
                                                                                    
                                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                    </tr> ';
                
                                                                            } 
                                                                        }
                
                                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                                        <td colspan="2" class="table-body-des-default"></td>
                                                                        <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ Book</td>
                                                                        <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalBook,2),2).' บาท</td>
                                                                    </tr> 
                                                                    
                                                                    ';
                                                                        
                                                                    }
                                                    
                                                                    if($data->approve_status){ //E-Book Data
                                                                        $iEBookSum = 0;
                                                                        $eBookHeaderShow = "true";
                                                                        foreach ($data->getOrderTran as $val){
                                                                            if($val->is_ebook == "true"){
                                                                                $iEBookSum += 1 ;
                                                                            }
                                                                        }
                                                                        foreach ($data->getOrderTran as $val){
                                                                        
                                                                            if($val->is_ebook == "true"){
                                                                                $sumTotalEBook += $val->net ;
                                                                                $sumTotalQuantitys += $val->quantitys;
                                                                            
                                                        $html .= '   <tr class="table-body-type-ebook  spaceUnderSty2 highlighted">';
                                                                        if($eBookHeaderShow == "true"){
                                                        $html .= '      <td colspan="" rowspan="'.$iEBookSum.'" class="table-header-type-ebook"><font class="table-header-type">E-Book</font></td>';
                    
                                                                        }
                                                        $html .= '      
                                                                        <td colspan="" ><img src="'.url('storage/book-images/'.$val->photo).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                        <td colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                        <td colspan="" class="box-text-values text-right"><font class="num-text">'.$val->quantitys.'</font></td>
                                                                        <td colspan="2" class="box-text-values ';
                                                                        
                                                                        if($eBookHeaderShow == "true"){
                                                        $html .= '      table-body-tr-top ';    
                                                                            $eBookHeaderShow = "false";
                                                                        }
                                                                                                        
                                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                    </tr> ';
                
                                                                            }
                                                                        }
                
                                                        $html .= '  <tr class="table-body-type-ebook  spaceUnderSty2">
                                                                        <td colspan="2" class="table-body-des-default"></td>

                                                                        <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ E-Book</td>
                                                                        <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalEBook,2),2).' บาท</td>
                                                                    </tr> 
                                                                    
                                                                    ';
                                                                        
                                                                    }
                                                        $html .= '  <tr class="spaceUnderSty2">
                                                                        <td colspan="8" class=""></td>   
                                                                    </tr>';
                
                                                        $html .= '  <tr class="spaceUnder">
                                                                        <td colspan="3" class=""></td>                                                                       
                                                                        <td colspan="3" class="box-text-values text-left pl-4">รวมรายการทั้งหมด</td>                                                                        
                                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                                    </tr>
                                                                    <tr class="spaceUnder">
                                                                        <td colspan="3" class=""></td>                                                                 
                                                                        <td colspan="3" class="box-text-values text-left pl-4">ค่าจัดส่ง</td>                                          
                                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->transport_rate,2),2).' บาท</td>
                                                                    </tr>
                                                                    <tr class="spaceUnder">
                                                                        <td colspan="3" class=""></td>                                                                      
                                                                        <td colspan="3" class="box-text-values text-total-sub text-left pl-4">รวมสุทธิ</td>
                                                                        <td colspan="2" class="box-text-values-total text-right text-total-sum pr-4">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                                    </tr>';
                                                                    
                
                                                                                
                                                            $html .= '</tbody>
                                                                </table>
                                                            </div>
                                                            
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>';

                        $html .= '  
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Shipping Address</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>
                                                    
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">ผู้สั่งซื้อ</td>
                                                        <td width="60%" class="box-text-values">'.$data->fullname.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">Username</td>
                                                        <td class="box-text-values">'.$data->username.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">เบอร์โทรศัพท์</td>
                                                        <td class="box-text-values">'.$data->phone.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">email</td>
                                                        <td class="box-text-values">'.($data->getUser->email ?? "").'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">ที่อยู่ในการจัดส่ง</td>
                                                        <td class="box-text-values">'.$data->tranfer_address.' ตำบล '.$data->address_subdistric.' อำเภอ '.$data->address_distric.' จังหวัด '.$data->address_province.' รหัสไปรษณีย์ '.$data->address_zipcode.'</td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                                            // have e-book only
                                            $ebookDisableNextBtn = "";
                                            if($data->approve_status && (!$data->book_available || $data->book_available == "n")){
                                                $ebookDisableNextBtn = " disabled ";
                                           
                                            }else{

                        $html .= '          <div class="express-box-header-and-body">
                                            
                                                <form id="theForm" action="'.url('admin/order').'" method="POST" typeForm="" class="form-inline">
                                                    <input type="hidden" name="_token" value="'.csrf_token().'" />
                                                    
                                                    <div class="form-group w-100">
                                                        <font class="mr-2 " style="width:20%">เลขพัสดุ</font>
                                                        <input type="text" class="form-control express-input" style="width:60%" id="tracking_number" name="tracking_number" placeholder="  ระบุเลขพัสดุ" value="'.$data->tracking_number.'">

                                                    </div>
                                                </form>
                                            </div>'; 

                                            }
                    $html_footer .= '<div class="modal-footer order_status_footer">
                                        <a href="javascript:void(0)" class="btn btn-paid-success ml-2 submitEMS '.$ebookDisableNextBtn.'"  
                                            data-channel-ems="cViewModal" 
                                            data-id="'.$data->id.'" 
                                            data-val="'.$data->order_status.'" 
                                            data-id-tran="'.$data->getTranfer->id.'" data-fn="NextStage"><img src="'.url('img/icon_pages/correct.png').'"> <font>ยืนยันและอนุมัติ</font></a>
                                        <a href="javascript:void(0)" class="btn btn-paid-sendback ml-2 mr-4 btnRej disabled" 
                                            data-id="'.$data->id.'" 
                                            data-val="'.$data->order_status.'" 
                                            data-id-tran="'.$data->getTranfer->id.'" data-fn="rollback" ><img src="'.url('img/icon_pages/sendback.png').'"> <font>ส่งกลับ</font></a>
                                    </div>';
                        
                        $html .= '                    
                                        </div>
                                    </div>
                                </div>';

                                    
                    $html .= '      </div>
                                    
                                                
                    
                                </div> ';
                    

                    
                   
                            }

                            elseif($data->order_status == "ยกเลิก"){

                    $html .= '  <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                                        <ul class="timeline">
                                            <li class="wait-pay cancel_status active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->order_date.' '.$data->order_time).' '.formatTimeThai($data->order_date.' '.$data->order_time).' น.'.'</font></li>
                                            <li class="cancel_icon cancel_status active"><font class="text_normal">ยกเลิกการสั่งซื้อ</font><br><font class="text_small">'.formatDateThai($data->updated_at).' '.formatTimeThai($data->updated_at).' น.'.'</font></li>
                                        </ul>
                                    </div>
                                </div>';

                    $html .='<div class="box-des py-2">
                                <div class="">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Customer Order</font>
                                        </div>
                                        <div class="express-box-body ">
                                            <div class="row">
                
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <table class="" style="width:100%">
                                                        
                                                        <tbody>
                                                            <tr class="spaceUnder">
                                                                <td width="40%" class="box-text">ประเภทหนังสือ</td>
                                                                <td width="60%" class="box-text-values">';
                                                                if($data->book_available == "y" ){
                                                    $html .= '           <span class="right badge badge-danger noti-book-type" >Book</span>';
                                                                }
                                                                if($data->approve_status){
                                                    $html .= '           <span class="right badge badge-danger noti-ebook-type" >E-Book</span>
                                                                        <span class="right badge badge-danger noti-book-type-order" style="background-color: white" data-toggle="popover" data-content="รออนุมัติ E-Book" data-trigger="hover" data-placement="bottom" data-original-title="" title="">!</span>';
                                                                }
                                                                    
                                                                    
                                                      $html .= '</td>
                                                            </tr>
                                                            <tr class="spaceUnder">
                
                                                                <td class="box-text">รวมราคาหนังสือ</td>
                                                                <td class="box-text-values">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                            </tr>
                                                            <tr class="spaceUnder">
                                                                <td class="box-text">ค่าจัดส่ง</td>
                                                                <td class="box-text-values">'.number_format(round((float)$data->transport_rate,0),0).' บาท ('.$data->transport.')</td>
                                                            </tr>
                                                            <tr class="spaceUnder">
                                                                <td class="box-text">รวมสุทธิ</td>
                                                                <td class="box-text-values-total font-medium">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                                    <a class="btn btn-light btn_des_order_new_style" data-toggle="collapse" href="#action_des_order_new" role="button" aria-expanded="false" aria-controls="action_des_order_new">
                                                        รายละเอียดการสั่งซื้อ
                                                        <img class="icon_des_order_new_style" src="'.url('img/icon_pages/arrow_down.png').'">
                                                    </a>
                
                                                    <div class="collapse " id="action_des_order_new">
                                                    <div class="">
                                                        <div class="" style="padding-right: 0 ;padding-left: 0;">
                                                            <div class=" table-responsive" style="padding-left:0;padding-right:0">
                                                                <div >
                                                                
                                                                    <table class="text-left" style="width:100%;">
                                                                        
                                                                    
                                                                        <tbody >';
                                                                        if($data->book_available == "y"){ //Book Data
                                                                            $iBookSum = 0;
                                                                            $bookHeaderShow = "true";
                                                                            foreach ($data->getOrderTran as $val){
                                                                                if($val->is_ebook == "false"){
                                                                                    $iBookSum += 1 ;
                                                                                }
                                                                            }
                                                                            foreach ($data->getOrderTran as $val){
                                                                                if($val->is_ebook == "false"){
                                                                                    $sumTotalBook += $val->net ;
                                                                                    $sumTotalQuantitys += $val->quantitys;
                    
                                                            $html .= '   <tr class="table-body-type-book  spaceUnderSty2 highlighted">';
                                                                            if($bookHeaderShow == "true"){
                                                            $html .= '      <td  colspan="" rowspan="'.$iBookSum.'" class="table-header-type-book"><font class="table-header-type">Book</font></td>';
                                                                                
                                                                            }
                                                            $html .= '      <td  colspan="" ><img src="'.url('storage/book-images/'.($val->photo ?? '')).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                            <td  colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                            <td  colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                                            <td  colspan="2" class="box-text-values ';
                                                                            
                                                                            if($bookHeaderShow == "true"){
                                                            $html .= '      table-body-tr-top ';    
                                                                                $bookHeaderShow = "false";
                                                                            }
                                                                                        
                                                            $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                        </tr> ';
                    
                                                                                } 
                                                                            }
                    
                                                            $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                                            <td colspan="2" class="table-body-des-default"></td>
                                                                            <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ Book</td>
                                                                            <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalBook,2),2).' บาท</td>
                                                                        </tr> 
                                                                        
                                                                        ';
                                                                            
                                                                        }
                                                        
                                                                        if($data->approve_status){ //E-Book Data
                                                                            $iEBookSum = 0;
                                                                            $eBookHeaderShow = "true";
                                                                            foreach ($data->getOrderTran as $val){
                                                                                if($val->is_ebook == "true"){
                                                                                    $iEBookSum += 1 ;
                                                                                }
                                                                            }
                                                                            foreach ($data->getOrderTran as $val){
                                                                            
                                                                                if($val->is_ebook == "true"){
                                                                                    $sumTotalEBook += $val->net ;
                                                                                    $sumTotalQuantitys += $val->quantitys;
                                                                                
                                                            $html .= '   <tr class="table-body-type-ebook  spaceUnderSty2 highlighted">';
                                                                            if($eBookHeaderShow == "true"){
                                                            $html .= '      <td colspan="" rowspan="'.$iEBookSum.'" class="table-header-type-ebook"><font class="table-header-type">E-Book</font></td>';
                        
                                                                            }
                                                            $html .= '      
                                                                            <td colspan="" ><img src="'.url('storage/book-images/'.$val->photo).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                                            <td colspan="4" class="box-text-values">'.$val->book_name.'</td>
                                                                            <td colspan="" class="box-text-values text-right"><font class="num-text">'.$val->quantitys.'</font></td>
                                                                            <td colspan="2" class="box-text-values ';
                                                                            
                                                                            if($eBookHeaderShow == "true"){
                                                            $html .= '      table-body-tr-top ';    
                                                                                $eBookHeaderShow = "false";
                                                                            }
                                                                                                            
                                                            $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                                        </tr> ';
                    
                                                                                }
                                                                            }
                    
                                                            $html .= '  <tr class="table-body-type-ebook  spaceUnderSty2">
                                                                            <td colspan="2" class="table-body-des-default"></td>
            
                                                                            <td colspan="4" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ E-Book</td>
                                                                            <td colspan="3" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalEBook,2),2).' บาท</td>
                                                                        </tr> 
                                                                        
                                                                        ';
                                                                            
                                                                        }
                                                            $html .= '  <tr class="spaceUnderSty2">
                                                                            <td colspan="8" class=""></td>   
                                                                        </tr>';
                    
                                                            $html .= '  <tr class="spaceUnder">
                                                                            <td colspan="3" class=""></td>                                                                       
                                                                            <td colspan="3" class="box-text-values text-left pl-4">รวมรายการทั้งหมด</td>                                                                        
                                                                            <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                                        </tr>
                                                                        <tr class="spaceUnder">
                                                                            <td colspan="3" class=""></td>                                                                 
                                                                            <td colspan="3" class="box-text-values text-left pl-4">ค่าจัดส่ง</td>                                          
                                                                            <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->transport_rate,2),2).' บาท</td>
                                                                        </tr>
                                                                        <tr class="spaceUnder">
                                                                            <td colspan="3" class=""></td>                                                                      
                                                                            <td colspan="3" class="box-text-values text-total-sub text-left pl-4">รวมสุทธิ</td>
                                                                            <td colspan="2" class="box-text-values-total text-right text-total-sum pr-4">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                                        </tr>';
                                                                        
                    
                                                                                    
                                                                $html .= '</tbody>
                                                                    </table>
                                                                </div>
                                                                
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                
                            </div>';
                            }
                            // <ul class="timeline">
                            //         <li class="wait-pay active"><font class="text_normal">คำสั่งซื้อ</font><br><font class="text_small">21 ธ.ค. 2563 13.34 น.</font></li>
                            //         <li class="check active"><font class="text_normal">คำสั่งซื้อมีการชำระเงิน</font><br><font class="text_small">21 ธ.ค. 2563 13.34 น.</font></li>
                            //         <li class="check_pay "><font class="text_normal">ตรวจสอบการชำระเงิน</font><br><font class="text_small">21 ธ.ค. 2563 13.34 น.</font></li>
                            //         <li class="approve_icon "><font class="text_normal">อนุมัติ, จัดส่ง</font><br><font class="text_small">21 ธ.ค. 2563 13.34 น.</font></li>
                            // </ul>';
                    return response()->json(['success'=>'Item View successfully.' , 'html' => $html , 'html_footer' => $html_footer]);
                }  

                if($request->fn === "viewOrderDetail"){
                    $sumTotalBook = 0 ;
                    $sumTotalEBook = 0 ;
                    $sumTotalQuantitys = 0 ;
                    

                    $data = OrderMas::with(['getTranfer','getImageSlip','getUser','getOrderTran'])->where("id" , $request->order_id)->first();
                    $html = '';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Pay-in Slip</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">เลขที่สั่งซื้อ</td>
                                                        <td width="60%" class="box-text-values">'.$data->id.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                
                                                        <td class="box-text">วันที่ - เวลา</td>
                                                        <td class="box-text-values">'.formatDateThai($data->order_date.' '.$data->order_time).' <img src="'.url('img/icon_pages/time.png').'"> '.formatTimeThai($data->order_date.' '.$data->order_time).' น. </td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">ผู้สั่งซื้อ</td>
                                                        <td class="box-text-values">'.$data->fullname.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">Username</td>
                                                        <td class="box-text-values">'.$data->username.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">เบอร์โทรศัพท์</td>
                                                        <td class="box-text-values">'.$data->phone.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">email</td>
                                                        <td class="box-text-values">'.($data->getUser->email ?? "").'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">ที่อยู่ในการจัดส่ง</td>
                                                        <td class="box-text-values">'.$data->tranfer_address.' ตำบล '.$data->address_subdistric.' อำเภอ '.$data->address_distric.' จังหวัด '.$data->address_province.' รหัสไปรษณีย์ '.$data->address_zipcode.'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                                ';
                                          
                                    
                                $html .= '      
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Customer Order</font>
                                        </div>
                                        <div class="express-box-body table-responsive" style="padding-left:0;padding-right:0">
                                            <div style="padding-left:30px;padding-right:30px">
                                            
                                                <table class="text-left" style="width:100%;">
                                                    
                                                    <thead>
                                                        <tr class="spaceUnderSty2">
                                                            <th colspan=""></th>
                                                            <th colspan="" width="5%" ></th>
                                                            <th colspan="" width="15%" class="text-left box-text" >ISBN</th>
                                                            <th colspan="" width="25%" class="box-text" >รายการ</th>
                                                            <th colspan="" width="10%" class="box-text" >จำนวน</th>
                                                            <th colspan="" width="15%" class="box-text" >ราคา/เล่ม</th>
                                                            <th colspan="" width="10%" class="box-text" >ส่วนลด</th>
                                                            <th colspan="" width="20%" class="box-text" >รวม</th>
                                                            
                                                        </tr>                                                   
                                                    </thead>
                                                    <tbody >';
                                                    
                                                   
                                                    if($data->book_available == "y"){ //Book Data
                                                        $iBookSum = 0;
                                                        $bookHeaderShow = "true";
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "false"){
                                                                $iBookSum += 1 ;
                                                            }
                                                        }
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "false"){
                                                                $sumTotalBook += $val->net ;
                                                                $sumTotalQuantitys += $val->quantitys;
                                                                // (count($data->getOrderTran)-1)

                                        $html .= '   <tr class="table-body-type-book  spaceUnderSty2 highlighted">';
                                                        if($bookHeaderShow == "true"){
                                        $html .= '      <td colspan="" rowspan="'.$iBookSum.'" class="table-header-type-book"><font class="table-header-type">Book</font></td>';
                                                        
                                                        }
                                        
                                        $html .= '      <td colspan="" ><img src="'.url('storage/book-images/'.($val->photo ?? '')).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                        <td colspan="" class="box-text-values">'.$val->ISBN.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->book_name.'</td>
                                                        <td colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                        <td colspan="" class="box-text-values">'.$val->product_price.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->percent_discount.'%</td>
                                                        <td colspan="" class="box-text-values ';
                                                        if($bookHeaderShow == "true"){
                                        $html .= '      table-body-tr-top ';    
                                        $bookHeaderShow = "false";
                                                        }
                                                   
                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                    </tr> ';
                                                        

                                                            } 
                                                        }

                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                        <td colspan="3" class="table-body-default"></td>
                                                        <td colspan="1" class="box-text-values table-body-default"></td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ Book</td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalBook,2),2).' บาท</td>
                                                    </tr> 
                                                    
                                                    ';
                                                           
                                                    }
                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                        <td colspan="8" class="table-body-default"></td>   
                                                    </tr>';

                                                    if($data->approve_status){ //E-Book Data
                                                        $iEBookSum = 0;
                                                        $eBookHeaderShow = "true";
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "true"){
                                                                $iEBookSum += 1 ;
                                                            }
                                                        }
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "true"){
                                                                $sumTotalEBook += $val->net ;
                                                                $sumTotalQuantitys += $val->quantitys;
                                                            
                                        $html .= '   <tr class="table-body-type-ebook  spaceUnderSty2 highlighted">';
                                                        if($eBookHeaderShow == "true"){
                                        $html .= '      <td colspan="" rowspan="'.$iEBookSum.'" class="table-header-type-ebook"><font class="table-header-type">E-Book</font></td>';

                                                        }
                                        $html .= '      
                                                        <td colspan="" ><img src="'.url('storage/book-images/'.$val->photo).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                        <td colspan="" class="box-text-values">'.$val->ISBN.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->book_name.'</td>
                                                        <td colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                        <td colspan="" class="box-text-values">'.$val->product_price.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->percent_discount.'%</td>
                                                        <td colspan="" class="box-text-values ';
                                                        
                                                        if($eBookHeaderShow == "true"){
                                        $html .= '      table-body-tr-top ';    
                                                            $eBookHeaderShow = "false";
                                                        }
                                                                       
                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                    </tr> ';

                                                            }
                                                        }

                                        $html .= '  <tr class="table-body-type-ebook  spaceUnderSty2">
                                                        <td colspan="3" class="table-body-default"></td>
                                                        <td colspan="1" class="box-text-values table-body-default"></td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ E-Book</td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalEBook,2),2).' บาท</td>
                                                    </tr> 
                                                    
                                                    ';
                                                        
                                                    }
                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                        <td colspan="8" class="table-body-default"></td>   
                                                    </tr>';

                                        $html .= '  <tr class="spaceUnder">
                                                        <td colspan="3" class=""></td>
                                                        <td colspan="1" class="box-text-values "></td>
                                                        <td colspan="2" class="box-text-values text-left pl-4">รวมรายการทั้งหมด</td>
                                                        <td colspan="1" class="box-text-values">'.$sumTotalQuantitys.' รายการ</td>
                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td colspan="3" class=""></td>
                                                        <td colspan="1" class="box-text-values "></td>
                                                        <td colspan="2" class="box-text-values text-left pl-4">ค่าจัดส่ง</td>
                                                        <td colspan="1" class="box-text-values">'.$data->transport.'</td>
                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->transport_rate,2),2).' บาท</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td colspan="3" class=""></td>
                                                        <td colspan="1" class="box-text-values "></td>
                                                        <td colspan="2" class="box-text-values text-total-sub text-left pl-4">รวมสุทธิ</td>
                                                        <td colspan="2" class="box-text-values-total text-right text-total-sum pr-4">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                    </tr>';
                                                    

                                                                
                                            $html .= '</tbody>
                                                </table>
                                            </div>
                                       
                                        </div>
                                    </div>
                                </div>';

                    return response()->json(['success'=>'Item View successfully.' , 'html' => $html ]);
                
                }
                
                if($request->fn === "checkSlip"){
                    $data = OrderMas::with(['getTranfer','getImageSlip' ,'getOrderTran'])->where("id" , $request->order_id)->first();
                    $sumTotalBook = 0 ;
                    $sumTotalEBook = 0 ;
                    $sumTotalQuantitys = 0 ;
                    $isDisableAction = '';

                    if($data->order_status == "ชำระเงินแล้ว"){
                        $isDisableAction = ' disabled ';
                    }

                    $html = '';
                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Pay-in Slip</font>
                                        </div>
                                        <div class="express-box-body">
                                            <table class="" style="width:100%">
                                                
                                                <tbody>                                                    
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">เลขที่สั่งซื้อ</td>
                                                        <td width="60%" class="box-text-values">'.$data->id.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td width="40%" class="box-text">โอนมายังธนาคาร</td>
                                                        <td width="60%" class="box-text-values">'.$data->getTranfer->bank_tranfer.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">

                                                        <td class="box-text">ผู้โอน</td>
                                                        <td class="box-text-values">'.$data->getTranfer->username.'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">วันที่</td>
                                                        <td class="box-text-values">'.formatDateThai($data->getTranfer->tranfer_date.' '.$data->getTranfer->tranfer_time).'</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">เวลา</td>
                                                        <td class="box-text-values">'.formatTimeThai($data->getTranfer->tranfer_date.' '.$data->getTranfer->tranfer_time).' น.</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td class="box-text">จำนวน</td>
                                                        <td class="box-text-values">'.number_format(round((float)$data->getTranfer->amount,0),0).' บาท</td>
                                                    </tr>                                            
                                                </tbody>
                                            </table>

                                            <div class="row div-image-slip">
                                                <div class="col">
                                                    <div class="" style="" >  
                                                        <div class="text-center">
                                                            <a data-gallery="photoviewer" data-title="'.$data->getImageSlip[0]->filename.'" data-group="a" id="show-img-photoviewer" 
                                                                href="'.url('storage/slip-images/'.$data->getImageSlip[0]->filename).'">
                                                                <img src="'.asset('storage/slip-images/thumbnail/'.$data->getImageSlip[0]->filename).'" data-img="'.asset('storage/slip-images/'.$data->getImageSlip[0]->filename).'" id="show-img" class="text-center image-slip show-image-payin" alt="">
                                                            </a>
                                                           
                                                        </div>
                                                    
                                                        <div class="small-img">
                                                            <img src="'.url('img/icon_pages/online_icon_right@2x.png').'" class="icon-left text-left" alt="" id="prev-img">
                                                            <div class="small-container container2 text-center">
                                                                <div id="small-img-roll">';
                                                                foreach ($data->getImageSlip as $image_slip){
                                                $html .= '            <img src="'.asset('storage/slip-images/thumbnail/'.$image_slip->filename).'" data-img="'.asset('storage/slip-images/'.$image_slip->filename).'" class="show-small-img image-slip-small text-center cropped2" alt="">';
                                                                }
                                                $html .= '      </div>
                                                            </div>
                                                            <img src="'.url('img/icon_pages/online_icon_right@2x.png').'" class="icon-right" alt="" id="next-img">
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 mt-4">
                                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                                        
                                        <div class="express-box-header">
                                        <font class="">Customer Order</font>
                                        </div>
                                        <div class="express-box-body table-responsive" style="padding-left:0;padding-right:0">
                                            <div style="padding-left:30px;padding-right:30px">
                                            
                                                <table class="text-left" style="width:100%;">
                                                    
                                                    <thead>
                                                        <tr class="spaceUnderSty2">
                                                            <th colspan=""></th>
                                                            <th colspan="" width="5%" ></th>
                                                            <th colspan="" width="15%" class="text-left box-text" >ISBN</th>
                                                            <th colspan="" width="25%" class="box-text" >รายการ</th>
                                                            <th colspan="" width="10%" class="box-text" >จำนวน</th>
                                                            <th colspan="" width="15%" class="box-text" >ราคา/เล่ม</th>
                                                            <th colspan="" width="10%" class="box-text" >ส่วนลด</th>
                                                            <th colspan="" width="20%" class="box-text" >รวม</th>
                                                            
                                                        </tr>                                                   
                                                    </thead>
                                                    <tbody >';
                                                    if($data->book_available == "y"){ //Book Data
                                                        $iBookSum = 0;
                                                        $bookHeaderShow = "true";
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "false"){
                                                                $iBookSum += 1 ;
                                                            }
                                                        }
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "false"){
                                                                $sumTotalBook += $val->net ;
                                                                $sumTotalQuantitys += $val->quantitys;

                                        $html .= '   <tr class="table-body-type-book  spaceUnderSty2 highlighted">';
                                                        if($bookHeaderShow == "true"){
                                        $html .= '      <td colspan="" rowspan="'.$iBookSum.'" class="table-header-type-book"><font class="table-header-type">Book</font></td>';
                                                            
                                                        }
                                        $html .= '      <td colspan="" ><img src="'.url('storage/book-images/'.($val->photo ?? '')).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                        <td colspan="" class="box-text-values">'.$val->ISBN.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->book_name.'</td>
                                                        <td colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                        <td colspan="" class="box-text-values">'.$val->product_price.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->percent_discount.'%</td>
                                                        <td colspan="" class="box-text-values ';
                                                        
                                                        if($bookHeaderShow == "true"){
                                        $html .= '      table-body-tr-top ';    
                                                            $bookHeaderShow = "false";
                                                        }
                                                                       
                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                    </tr> ';

                                                            } 
                                                        }

                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                        <td colspan="3" class="table-body-default"></td>
                                                        <td colspan="1" class="box-text-values table-body-default"></td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ Book</td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalBook,2),2).' บาท</td>
                                                    </tr> 
                                                    
                                                    ';
                                                           
                                                    }
                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                        <td colspan="8" class="table-body-default"></td>   
                                                    </tr>';
                                                    if($data->approve_status){ //E-Book Data
                                                        $iEBookSum = 0;
                                                        $eBookHeaderShow = "true";
                                                        foreach ($data->getOrderTran as $val){
                                                            if($val->is_ebook == "true"){
                                                                $iEBookSum += 1 ;
                                                            }
                                                        }
                                                        foreach ($data->getOrderTran as $val){
                                                           
                                                            if($val->is_ebook == "true"){
                                                                $sumTotalEBook += $val->net ;
                                                                $sumTotalQuantitys += $val->quantitys;
                                                            
                                        $html .= '   <tr class="table-body-type-ebook  spaceUnderSty2 highlighted">';
                                                        if($eBookHeaderShow == "true"){
                                        $html .= '      <td colspan="" rowspan="'.$iEBookSum.'" class="table-header-type-ebook"><font class="table-header-type">E-Book</font></td>';
    
                                                        }
                                        $html .= '      
                                                        <td colspan="" ><img src="'.url('storage/book-images/'.$val->photo).'" width="65px" height="65px" class="text-center cropped2 image-slip-product-small"></td>
                                                        <td colspan="" class="box-text-values">'.$val->ISBN.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->book_name.'</td>
                                                        <td colspan="" class="box-text-values "><font class="num-text">'.$val->quantitys.'</font></td>
                                                        <td colspan="" class="box-text-values">'.$val->product_price.'</td>
                                                        <td colspan="" class="box-text-values">'.$val->percent_discount.'%</td>
                                                        <td colspan="" class="box-text-values ';
                                                        
                                                        if($eBookHeaderShow == "true"){
                                        $html .= '      table-body-tr-top ';    
                                                            $eBookHeaderShow = "false";
                                                        }
                                                                                           
                                        $html .= '      text-right pr-4">'.number_format(round((float)$val->net,2),2).' บาท</td>
                                                    </tr> ';

                                                            }
                                                        }

                                        $html .= '  <tr class="table-body-type-ebook  spaceUnderSty2">
                                                        <td colspan="3" class="table-body-default"></td>
                                                        <td colspan="1" class="box-text-values table-body-default"></td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-left text-left pl-4">รวมรายการ E-Book</td>
                                                        <td colspan="2" class="box-text-values table-body-tr-bottom-right text-right text-total-sub pr-4">'.number_format(round((float)$sumTotalEBook,2),2).' บาท</td>
                                                    </tr> 
                                                    
                                                    ';
                                                        
                                                    }
                                        $html .= '  <tr class="table-body-type-book  spaceUnderSty2">
                                                        <td colspan="8" class="table-body-default"></td>   
                                                    </tr>';

                                        $html .= '  <tr class="spaceUnder">
                                                        <td colspan="3" class=""></td>
                                                        <td colspan="1" class="box-text-values "></td>
                                                        <td colspan="2" class="box-text-values text-left pl-4">รวมรายการทั้งหมด</td>
                                                        <td colspan="1" class="box-text-values">'.$sumTotalQuantitys.' รายการ</td>
                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->net_price,2),2).' บาท</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td colspan="3" class=""></td>
                                                        <td colspan="1" class="box-text-values "></td>
                                                        <td colspan="2" class="box-text-values text-left pl-4">ค่าจัดส่ง</td>
                                                        <td colspan="1" class="box-text-values">'.$data->transport.'</td>
                                                        <td colspan="2" class="box-text-values text-right pr-4">'.number_format(round((float)$data->transport_rate,2),2).' บาท</td>
                                                    </tr>
                                                    <tr class="spaceUnder">
                                                        <td colspan="3" class=""></td>
                                                        <td colspan="1" class="box-text-values "></td>
                                                        <td colspan="2" class="box-text-values text-total-sub text-left pl-4">รวมสุทธิ</td>
                                                        <td colspan="2" class="box-text-values-total text-right text-total-sum pr-4">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                                    </tr>';
                                                    

                                                                
                                            $html .= '</tbody>
                                                </table>
                                            </div>
                                            <hr style="background-color: #D0D8DF;border:1px solid #D0D8DF">
                                            
                                            <div class="modal-footer ">
                                                <a href="javascript:void(0)" class="btn btn-paid-success ml-2 btnNext '.$isDisableAction.'" 
                                                    data-id="'.$data->id.'" 
                                                    data-val="'.$data->order_status.'" 
                                                    data-id-tran="'.$data->getTranfer->id.'" data-fn="NextStage"><img src="'.url('img/icon_pages/correct.png').'"> <font>ยืนยันและอนุมัติ</font></a>
                                                <a href="javascript:void(0)" class="btn btn-paid-sendback ml-2 mr-4 btnRej '.$isDisableAction.'" 
                                                    data-id="'.$data->id.'" 
                                                    data-val="'.$data->order_status.'" 
                                                    data-id-tran="'.$data->getTranfer->id.'" data-fn="rollback" ><img src="'.url('img/icon_pages/sendback.png').'"> <font>ส่งกลับ</font></a>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>';

                    return response()->json(['success'=>'Item View successfully.' , 'html' => $html ]);
                
                }

                if($request->fn === "viewEMS"){ //ดูข้อมูล EMS

                    $data = OrderMas::with(['getUser'])->where("id" , $request->order_id)->first();
                    $html = '';
       $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-4">
                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                        
                        <div class="express-box-header">
                        <font class="">Shipping Address</font>
                        </div>
                        <div class="express-box-body">
                            <table class="" style="width:100%">
                                
                                <tbody>
                                    <tr class="spaceUnder">
                                        <td width="40%" class="box-text">เลขที่สั่งซื้อ</td>
                                        <td width="60%" class="box-text-values">'.$data->id.'</td>
                                    </tr>
                                    <tr class="spaceUnder">

                                        <td class="box-text">วันที่ - เวลา</td>
                                        <td class="box-text-values">'.formatDateThai($data->order_date.' '.$data->order_time).' <img src="'.url('img/icon_pages/time.png').'"> '.formatTimeThai($data->order_date.' '.$data->order_time).' น. </td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">ผู้สั่งซื้อ</td>
                                        <td class="box-text-values">'.$data->fullname.'</td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">Username</td>
                                        <td class="box-text-values">'.$data->username.'</td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">เบอร์โทรศัพท์</td>
                                        <td class="box-text-values">'.$data->phone.'</td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">email</td>
                                        <td class="box-text-values">'.($data->getUser->email ?? "").'</td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">ที่อยู่ในการจัดส่ง</td>
                                        <td class="box-text-values">'.$data->tranfer_address.' ตำบล '.$data->address_subdistric.' อำเภอ '.$data->address_distric.' จังหวัด '.$data->address_province.' รหัสไปรษณีย์ '.$data->address_zipcode.'</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 mt-4">
                    <div class="express-box mr-2 ml-2" style="padding-right: 0 ;padding-left: 0;">
                        
                        <div class="express-box-header">
                        <font class="">Customer Order</font>
                        </div>
                        <div class="express-box-body">
                            <table class="" style="width:100%">
                                
                                <tbody>
                                    <tr class="spaceUnder">
                                        <td width="40%" class="box-text">รวมราคาสินค้า</td>
                                        <td width="60%" class="box-text-values">'.number_format(round((float)$data->net_price,2),2).'</td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">ค่าจัดส่ง</td>
                                        <td class="box-text-values">'.number_format(round((float)$data->transport_rate,0),0).' บาท ('.$data->transport.')</td>
                                    </tr>
                                    <tr class="spaceUnder">
                                        <td class="box-text">รวมสุทธิ</td>
                                        <td class="box-text-values-total font-medium">'.number_format(round((float)($data->net_price + $data->transport_rate),2),2).' บาท</td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="express-box mr-2 ml-2 mt-4" style="padding-right: 0 ;padding-left: 0;">
                        
                        <div class="express-box-header-and-body">
                            
                            <form id="theForm" action="'.url('admin/order').'" method="POST" typeForm="" class="form-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                
                                <div class="form-group w-100">
                                    <font class="mr-2 " style="width:20%">เลขพัสดุ</font>
                                    <input type="text" class="form-control express-input" style="width:50%" id="tracking_number_transport" name="tracking_number_transport" placeholder="  ระบุเลขพัสดุ" value="'.$data->tracking_number.'">
                                    <button type="button" class="btn btn-paid-success express-btn-success ml-2 submitEMS" data-channel-ems="cTransport"  data-id="'.$data->id.'" style="width:20%"><img src="'.url('img/icon_pages/correct.png').'"> <font>ยืนยัน</font></button>                            
         
                                
                                </div>
                                </form>
                        </div>
                    </div>
                </div>';
     
           
                    return response()->json(['success'=>'Item View successfully.' , 'html' => $html]);
                } 
                
                
                          
            }else{ // ข้อมูลทั้งหมด
                $webconfig = WebConfig::first();

                $data = OrderMas::with(['getTranfer','getReason'])
                ->where('order_mas.show_status' , 'y');
                // ->orWhereNull('order_mas.show_status');
                // if($request->status && $request->status != "all"){
                //     $data->where('order_mas.order_status' , $status_text);
                // }


                if(!empty($request->filters)){
                    switch($request->filters) {
                        case "filtersCheckAll":

                            break;
                        case "filtersCheckSendback":
                            // $data = $data->whereNotNull('order_sendback.description');
                            $data = $data->whereHas('getReason', function($query) {
                                $query->whereNotNull("description");
                            });
                            break;
                        case "filtersCheckWaitSend": //รอจัดส่ง
                            $data = $data->where('tracking_number' , null)->where('book_available' , 'y');
                            break;
                        case "filtersCheckSended": //จัดส่งแล้ว
                            $data = $data->whereNotNull('tracking_number')->where('book_available' , 'y');
                            break;
                        case "filtersCheckWaitApproveEbook":
                            $data = $data->where('approve_status' , "n")->whereNull('approve_date')->whereNull('approve_time');                         
                            break;
                        case "filtersCheckApprovedEbook":
                            $data = $data->where('approve_status' , "y")->whereNotNull('approve_date')->whereNotNull('approve_time');                         
                            break;
                        case "filtersCheckCancelPeriod":
                            
                            $data = $data->where('created_at', '<', Carbon::now()->subDays($webconfig->cancel_time)->toDateTimeString());
                            // $data = $data->where('approve_status' , "y")->whereNotNull('approve_date')->whereNotNull('approve_time');                         
                            break;
                            
                    }
            
                }

                if($request->status && $request->status != "all"){
                    $data = $data->where('order_mas.order_status' , $status_text);
                    if($status_text == "ชำระเงินแล้ว"){
                        $data = $data->orderBy('order_mas.id','DESC');
                        // $data = $data->orderByRaw(DB::raw("FIELD(book_available, 'y') DESC","FIELD(tracking_number, '') ASC"));
                        if($request->status === "sent"){
                            $data = $data->whereNotNull('tracking_number')->where('book_available' , 'y');
                        }
                    }else{
                        $data = $data->orderBy('order_mas.id','DESC');
                    }

                    
                    
                    
                }else{
                    $data = $data->orderBy('order_mas.id','DESC');
                }

                $data = $data->get(); 
            }
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('book_type', function($row){
                $html = "";       
                // have e-book only
                if($row->approve_status && (!$row->book_available || $row->book_available == "n" || $row->book_available == "") ) {
                    $html = '<strong class="text-color_main">E-Book</strong> ';
                    if($row->approve_status == "y"){
                        $html .= '<span class="right badge badge-success noti-book-type-order-yes" data-toggle="popover" data-content="อนุมัติ E-Book" data-trigger="hover" data-placement="bottom" ><i class="fas fa-check" style="color:#4DD0B5"></i></span>';
                    }else{
                        $html .= '<span class="right badge badge-danger noti-book-type-order" data-toggle="popover" data-content="รออนุมัติ E-Book" data-trigger="hover" data-placement="bottom">!</span>' ;                
                    }
                }
                // have book only  
                if(!$row->approve_status && (!$row->book_available ||  $row->book_available == "y") ) {
                    $html = '<strong class="text-color_main">Book</strong> ' ;
                }

                // have book and e-book only 
                if($row->approve_status && ($row->book_available && $row->book_available == "y") ) {
                    $html = '<strong class="text-color_main">Book<br/>E-Book</strong> ';
                    if($row->approve_status == "y"){
                        $html .= '<span class="right badge badge-success noti-book-type-order-yes" data-toggle="popover" data-content="อนุมัติ E-Book" data-trigger="hover" data-placement="bottom" ><i class="fas fa-check" style="color:#4DD0B5"></i></span>';
                    }else{
                        $html .= '<span class="right badge badge-danger noti-book-type-order" data-toggle="popover" data-content="รออนุมัติ E-Book" data-trigger="hover" data-placement="bottom">!</span>' ;                
                    }
                }


                return $html ;
            })
            ->addColumn('order_status_action', function($row){
                $btn = "";
                switch($row->order_status) {
                    case 'รอชำระเงิน':
                        $btn .= '<span class="badge badge-warning payment-status-wait"><i class="fas fa-circle"></i> '.$row->order_status.'</span>';
                        if(!empty($row->getReason[0])){
                            $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-html="true"  data-content="';

                            foreach ($row->getReason as $key=>$val){                                
                                $btn .=  'ส่งกลับ('.($key+1).') :'.$val->description .'<br>';                                
                            }
                            $btn .= '" data-trigger="hover" data-placement="bottom"> '.count($row->getReason).' <img src="'.url('img/icon_pages/reback.png').'" alt="" sizes="30" srcset="" ></span>';                            
                        }
                        $webconfig = WebConfig::first();
                        if($row->created_at < Carbon::now()->subDays($webconfig->cancel_time)->toDateTimeString()){
                            $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-content="หมายเหตุ : คำสั่งซื้อหมดอายุ" data-trigger="hover" data-placement="bottom"> <img src="'.url('img/icon_pages/icon_cancel.png').'" alt="" sizes="30" srcset="" ></span>';
                        }
                        break;
                    case 'รอตรวจสอบ':
                        $btn .= '<h5><span class="badge badge-info payment-status-check"><i class="fas fa-circle"></i> '.$row->order_status.'</span>';
                        if(!empty($row->getReason[0])){
                            $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-html="true"  data-content="';

                            foreach ($row->getReason as $key=>$val){                                
                                $btn .=  'ส่งกลับ('.($key+1).') :'.$val->description .'<br>';                                
                            }
                            $btn .= '" data-trigger="hover" data-placement="bottom"> '.count($row->getReason).' <img src="'.url('img/icon_pages/reback.png').'" alt="" sizes="30" srcset="" ></span>';                            
                        }                    
                        $btn .= '</h5>';
                        
                        
                        break;    
                    case 'ส่งกลับแก้ไข':
                        $btn .= '<h5><span class="badge badge-warning ">'.$row->order_status.'</span>';
                        $btn .= '</h5>';
                        
                        break; 
                    case 'ชำระเงินแล้ว':
                        $btn .= '<h5><span class="badge badge-success payment-status-success"><i class="fas fa-circle"></i> '.$row->order_status.'</span></h5>';
                        break;
                    case 'ขอคืนเงิน':
                        $btn .= '<h5><span class="badge badge-dark payment-status-refund"><i class="fas fa-circle"></i> '.$row->order_status.'</span></h5>';
                        break;
                        
                    case 'ส่งสินค้าแล้ว':
                        $btn .= '<h5><span class="badge badge-dark">'.$row->order_status.'</span></h5>';
                        break;
                        
                    case 'ยกเลิก':
                        $btn .= '<h5><span class="badge badge-dark payment-status-cancel"><i class="fas fa-circle"></i> '.$row->order_status.'</span>';
                        if($row->reason){
                            $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-content="หมายเหตุ : '.$row->reason.'" data-trigger="hover" data-placement="bottom"> <img src="'.url('img/icon_pages/icon_cancel.png').'" alt="" sizes="30" srcset="" ></span></h5>';
                        }
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn ;
            })
            ->addColumn('action', function($row){
                $btn = '';
                $isDivAction = '';
                $isDivCancel = '';
                $isViewSlip = '';
                $isViewEMS = '';
                if($row->order_status == 'รอชำระเงิน'){
                    $isDivAction = '';
                    $isDivCancel = '';
                    $isViewSlip = 'disabled_action';
                    $isViewEMS = 'disabled_action';

                }elseif($row->order_status == 'รอตรวจสอบ'){
                    $isDivAction = '';
                    $isDivCancel = 'disabled_action';
                    $isViewSlip = '';
                    $isViewEMS = 'disabled_action';

                }elseif($row->order_status == 'ชำระเงินแล้ว'){
                    $isDivAction = '';
                    $isDivCancel = 'disabled_action';
                    $isViewSlip = '';
                    $isViewEMS = '';
                    //e-book only
                    if($row->approve_status && (!$row->book_available || $row->book_available == "n")){
                        $isViewEMS = 'disabled_action';
                    }

                }elseif($row->order_status == 'ขอคืนเงิน'){
                    $isDivAction = '';
                    $isDivCancel = 'disabled_action';
                    $isViewSlip = '';
                    $isViewEMS = '';

                }elseif($row->order_status == 'ยกเลิก'){
                    $isDivAction = 'disabled_action';
                    $isDivCancel = 'disabled_action';
                    $isViewSlip = 'disabled_action';
                    $isViewEMS = 'disabled_action';

                }
    $btn .= '       <div class="dropdown d-inline '.$isDivAction.'">
                        <a class="btn btn-light order_action" href="javascript:void(0) "  id="order_action" data-toggle="dropdown" >
                            <img src="'.url('img/icon_pages/arrow_down.png').'"></a>
                        </a>
                    
                        <div class="dropdown-menu div_action" aria-labelledby="order_action ">
                            <a class="dropdown-item '.$isViewSlip.' checkSlipBtn" href="javascript:void(0)" data-id="'.$row->id.'" ><img src="'.url('img/icon_pages/slip_mini.png').'"> <font class="ml-2">ตรวจสอบสลิป</font></a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item '.$isViewEMS.' viewEMSBtn"  href="javascript:void(0)" data-id="'.$row->id.'" data-ems="'.$row->tracking_number.'"><img src="'.url('img/icon_pages/car_mini.png').'"> <font class="ml-2">การจัดส่ง</font></a>
                        </div>
                    </div>';

    $btn .= '       <a class="d-inline btn btn-light order_action_cancel deleteBtn '.$isDivCancel.'" 
                            data-id="'.$row->id.'" 
                            data-val="'.$row->order_status.'" data-fn="rollback"  href="javascript:void(0) " id="action_cancel_btn">
                        <img src="'.url('img/icon_pages/close.png').'"></a>
                    </a>';
                return $btn ;
            })
            ->rawColumns(['action','order_status_action','book_type'])
            ->make(true);
        }
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tranfer_db = Tranfer::find($id);

        // $order = OrderMas::with(['getProduct','getOrderTran' => function($query){
        //     $query->where('order_tran.is_ebook' ,'=' , 'false');
        //     $query->where('product.buffet', '!=' , 'true');
        // }])->where('id' ,$id)
        // ->first();
        
        // $order_ebook = OrderMas::with(['getProduct','getOrderTran' => function($query){
        //     $query->where('order_tran.is_ebook' ,'=' , 'true');
        // }])->where('id' ,$id)
        // ->first();

        // $order_buffet = OrderMas::with(['getOrderTran' => function($query){
        //     $query->where('order_tran.is_ebook' ,'=' , 'false');
        //     $query->where('product.buffet' ,'=', 'true');
        // }])->where('id' ,$id)        
        // ->first();

        // DD($order_buffet);
        $order = OrderMas::with(['getOrderTran'])->find($id);
    
        $is_ebook = in_array("true", Arr::pluck($order->getOrderTran, 'is_ebook')) ;
        $is_book = in_array("false", Arr::pluck($order->getOrderTran, 'is_ebook')) ;
        $is_buffet = in_array("true", Arr::pluck($order->getProduct, 'buffet')) ;

        // DD($is_ebook);
                $quantitys_sum = OrderTran::select(DB::raw('sum(quantitys) as quantitys_sum'))
                     ->where('order_id', $id)
                     ->first();

        if (empty($order->toArray()) || empty($quantitys_sum->quantitys_sum)){
            abort(404);
        }else{
            $user = User::find($order->user_id);
        }


    //     if (empty($order->toArray()) && empty($order_buffet->toArray()) && empty($order_ebook->toArray())){
    //         abort(404);
    //     }

    //     if(!empty($order_ebook->toArray())){
    //        $user = User::find($order_ebook->user_id);
    //     }
    //    if(!empty($order->toArray())){
    //        $user = User::find($order->user_id);
    //     }
    //     if(!empty($order_buffet->toArray())){
    //        $user = User::find($order_buffet->user_id);
    //     }

    //     if (empty($quantitys_sum->quantitys_sum)){
    //         abort(404);
    //     }

        return view('order.detail' , [
            'orders' => $order,
            // 'order_ebooks' => $order_ebook,
            'i' => '0',
            'quantitys_sum' => $quantitys_sum ,
            'user' => $user ,
            'is_ebook' => $is_ebook ,
            'is_book' => $is_book ,
            'is_buffet' => $is_buffet ,
            
            
            
            // 'order_buffets' => $order_buffet ,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if(!$id){
        //     return response()->json(['error'=>'ID not found form front-end.']);
        // }
        // $orderMas = OrderMas::find($id);
        // return response()->json(['success'=>'success' , 'tracking_number' , '99999999999999999']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!empty($request->fn) ){
            if($request->fn === "trash"){
                // revert
                switch($request->stagePresent) {
                    case 'รอชำระเงิน':
                        $status_revert = "รอชำระเงิน";
                        $status_show = "y";
                        //return '<h5><span class="badge badge-warning">'+data.order_status+'</span></h5>';
                        break;
                    case 'รอตรวจสอบ':
                        $status_revert = "รอตรวจสอบ";
                        $status_show = "y";
                        //return '<h5><span class="badge badge-warning">'+data.order_status+'</span></h5>';
                        break; 
                    case 'ชำระเงินแล้ว':
                        $status_revert = "ชำระเงินแล้ว";
                        $status_show = "y";
                        //return '<h5><span class="badge badge-success">'+data.order_status+'</span></h5>';
                        break;
                    case 'ส่งสินค้าแล้ว':
                        $status_revert = "ชำระเงินแล้ว";
                        $status_show = "y";
                        //return '<h5><span class="badge badge-dark">'+data.order_status+'</span></h5>';
                        break;
                    default:
                        $status_revert = "-";  
                        $status_show = "y";
                }
                OrderMas::find($id)->update([
                    'show_status' => $status_show,
                    'order_status' => $status_revert , 
                ]);

                
                return response()->json(['success'=>'Item Re-Order successfully.' , 'status' => $request->fn]);
            }else if($request->fn === "NextStage"){
                // $tmp_carts = DB::table('order_tran as t1')
                // ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
                // ->select('t1.*' , 't2.stock') 
                // ->selectRaw('SUM(t1.quantitys) AS sum_quantity')
                // ->where('t1.order_id' , $id)
                // ->groupBy('t1.book_id')
                // ->orderBy('t2.book_name' , 'ASC')        
                // ->get(); 

                
                // return response()->json(['success'=>'Item Change Status successfully.' , 'val' => $tmp_carts->all()]);
                // next
                $status_next = "";
                $status_show ="y";
                switch($request->stagePresent) {
                    case 'รอชำระเงิน':
                        $status_next = "ชำระเงินแล้ว";
                        //return '<h5><span class="badge badge-warning">'+data.order_status+'</span></h5>';
                        break;
                    case 'รอตรวจสอบ':
                        $status_next = "ชำระเงินแล้ว";
                        //return '<h5><span class="badge badge-warning">'+data.order_status+'</span></h5>';
                        break;
                    case 'ชำระเงินแล้ว':
                        $status_next = "ส่งสินค้าแล้ว";
                        $status_show = "y";
                        //return '<h5><span class="badge badge-success">'+data.order_status+'</span></h5>';
                        break;
                    case 'ส่งสินค้าแล้ว':
                        $status_next = "ส่งสินค้าแล้ว";
                        $status_show = "y";
                        //return '<h5><span class="badge badge-dark">'+data.order_status+'</span></h5>';
                        break;
                    default:
                        $status_next = "-";  
                }
                $order_mas = OrderMas::find($id);
                $order_mas->update([
                    'order_status' => $status_next,
                    'show_status' => $status_show
                ]);
                //$order_tran = OrderTran::where('order_id',$id)->get();

                $tmp_carts = DB::table('order_tran as t1')
                ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
                ->select('t1.*' , 't2.stock') 
                ->selectRaw('SUM(t1.quantitys) AS sum_quantity')
                ->where('t1.order_id' , $id)
                ->groupBy('t1.book_id')
                ->orderBy('t2.book_name' , 'ASC')        
                ->get(); 

                
                return response()->json(['success'=>'Item Change Status successfully.' , 'status_next' => $status_next]);
            }

        }
        // if(($request->has('fn')){}
        OrderMas::find($id)->update([
            'tracking_number' => $request->tracking_number,
        ]);
        return response()->json(['success'=>'Item Re-Order successfully.' , 'status' => $request->tracking_number]);

      
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
        }
        //return response()->json(['success'=>'0000000000000' ,'all'=>$tranfer->account_tranfer ]);
        if(!empty($request->fn) ){
            $tranfer =  Tranfer::where('account_tranfer',$id)->first();
            if(!empty($tranfer)){
                $tranfer->delete();
               // return response()->json(['success'=>'0000000000000'  ]);
            }
            
           $order_mas = OrderMas::find($id)->delete();

           OrderTran::where('order_id',$id)->delete(); 

           

            return response()->json(['success'=>'Record deleted Successfully.' , 'status' => $request->fn]);
        }else{
            $tmp_carts = OrderTran::select('*')->selectRaw('SUM(order_tran.quantitys) AS sum_quantity')
                ->where('order_tran.order_id' , $id)
                ->groupBy('order_tran.book_id')  
                ->get(); 
            foreach($tmp_carts as $tmp_cart){
                $product = Product::where('id',$tmp_cart->book_id)->where('is_ebook',"false")->first();
                if(!empty($product)){
                    // $total_stock = $product->stock + $tmp_cart->sum_quantity; // สินค้าคงคลัง +
                    // $stock_sold = $product->stock_sold + $tmp_cart->sum_quantity; //สินค้าขายแล้ว + 
                    $stock_hold = $product->stock_hold - $tmp_cart->sum_quantity; //สินค้าติดจอง -
                    $stock_remain = $product->stock_remain + $tmp_cart->sum_quantity; //สินค้าพร้อมขาย -
                    $product->update([
                        // 'stock'=> $total_stock ,
                        'stock_hold' => $stock_hold ,
                        'stock_remain' => $stock_remain ,
                    ]);   
                    // OrderMas::find($id)->update([
                    //     'stock'=> $total_stock ,
                    //     'stock_hold' => $stock_hold ,
                    //     'stock_remain' => $stock_remain ,
                    //     'show_status' => "y",
                    //     'order_status' => "ยกเลิก",
                    // ]);
                }
            }
            OrderMas::updateOrCreate(['id' => $id],[
                'show_status' => "y",
                'order_status' => "ยกเลิก",
                'reason' => $request->reason,
                
            ]);
            return response()->json(['success'=>'Record Deleted To Trash Successfully.', 'status' => $request->fn]);
        }
        
    }
}
