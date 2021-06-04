<?php

namespace App\Http\Controllers;

use App\Publisher;
use App\TmpCart;
use App\Transport;
use App\Discount;
use App\Payment;
use App\OrderMas;
use App\OrderTran;
use App\User;
use App\Product;
use App\Buffet;
use App\Address;
use App\OrderMasEbook;
use App\OrderTranEbook;
use App\WebConfig;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //DD($request->all());
        $html = '';
        $user = null;
        $sum_quantity_all = 0;
        $total_book_price_all = 0 ;
        $total_sub = 0 ;
        $discount_percen=0;
        $total_discount=0;
        $total_final = 0 ;
        //variable buffet 
        $sum_price_buffet_all = 0;
        $sum_quantity_buffet_all = 0;
        $buffet_book_number = 0 ;
        $book_buffet_check = '';
        $price_buffet = 0; 
        $buffet_pro_count  = 0 ; 
        $sum_pridce_buf_final = 0;
        $html_buffet_tfoot = '';
        $buffet_check = '';
        //end variable buffet
        if (Auth::check()) {
            $user = Auth::user();
        }
        if(request()->ajax()) {
            if(!empty($request->fn)){
                if($request->fn === "show"){
                    if(!empty($request->id)){
                        Address::where('user_id' , $user->id)->update(['default' => 'false']);
                        Address::find($request->id)->update(['default' => 'true']);
                    }
                    $address = Address::where('user_id' , $user->id)->get();
                    $html = '';
                    // <a href="javascript:void(0)" class="btn btn-sm btn-dark"> default </a> 
                    foreach ($address as $address){
                    $html .='<div class="card p-1 ">
                    <div class="card-header" style="padding:5px" id="headingOne  align-self-center">
                        <div class="text-center  row align-self-center">
                            <a href="javascript:void(0)" class="btn col-md-10 change_address align-self-center" data-id="'.$address->id.'" 
                            data-fullname="'.$address->fullname.'" data-tel="'.$address->tel.'" 
                            data-address="'.$address->address.'"  data-subdistric="'.$address->subdistric.'"  data-distric="'.$address->distric.'" 
                            data-province="'.$address->province.'" data-zipcode="'.$address->zipcode.'" style="';
                            if($address->default == "true"){
                                $html .= 'color:green';
                            }else{
                                $html .= 'color:black';
                            }
                            $html .= '" >
                                <font size="2">'.$address->fullname.' '.$address->tel.' '.$address->address.' '.$address->subdistric.' '.$address->distric.' '.$address->province.' '.$address->zipcode.'</font>
                            </a>';
                            if($address->default == "true"){
                                $html .= '<div class="col-md-2 align-self-center text-center">';
                                $html .= '<i class="fas fa-check " style="color:red"></i> ';
                                // $html .= ' <a href="javascript:void(0)" ><i class="far fa-trash-alt" style="color:black"></i></a>';
                                $html .= '</div>';
                            }else{
                                $html .= '<div class="col-md-2 align-self-center text-center">';
                                $html .= ' <a href="javascript:void(0)" class="btnDelAddress" data-id="'.$address->id.'"><i class="far fa-trash-alt " style="color:black"></i></a>';
                                $html .= '</div>';
                            }
                            $html .= '  
                        </div>
                        <div class="text-center ">
                        
                         
                        </div>
                    </div>
                </div>';
                    }
                
                    return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);

                }
            }
        }
        $publishers = Publisher::all();
        $transports = Transport::all();
        $discounts = Discount::all();
        $payments =  Payment::all();
        $buffets = Buffet::all();
        

        

            $count_can_discount = DB::table('tmp_cart as t1')
            ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
            ->selectRaw('SUM(t1.quantity) AS count_can_discount')
            ->where('user_id' , $user->id)
            ->where('t2.can_discount' , 'true')
            ->where('t2.public_show' , 'true')
            ->where('t1.is_ebook','=', 'false')
            ->first();

            $tmp_carts = DB::table('tmp_cart as t1')
            ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
            ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart') 
            ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            ->where('user_id' , $user->id)
            ->where('t2.public_show' , 'true')
            ->where('t2.buffet','<>', 'true')
            ->where('t1.is_ebook','=', 'false')
            ->groupBy('t1.book_id')
            // ->orderBy('t1.created_at' , 'ASC')
            ->orderBy('t2.book_name' , 'ASC')
            // ->orderBy('t1.id' , 'ASC')            
            ->get();    

            // $tmp_carts_ebooks = DB::table('tmp_cart as t1')
            // ->leftJoin('ebook_product as t2' , 't1.book_id' ,'t2.id' )
            // ->select('t1.book_id' ,'t2.product_name','t2.alias_price','t2.product_price','t2.product_image','t1.id as id_cart') 
            // ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            // ->where('user_id' , $user->id)
            // ->where('t2.public_show' , 'true')
            // ->where('t1.is_ebook','=', 'true')
            // ->groupBy('t1.book_id')
            // ->orderBy('t1.created_at' , 'ASC')
            // ->orderBy('t2.product_name' , 'ASC')
            // ->orderBy('t1.id' , 'ASC')            
            // ->get(); 

            $tmp_carts_ebooks = TmpCart::with(['getProduct' => function($query){
                $query->where('public_show', 'true');
                $query->orderBy('book_name','ASC');
            }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
            ->where('is_ebook', 'true')
            ->where('user_id', $user->id)  
            ->groupBy('book_id')          
            ->get();


            $tmp_carts_buffet = DB::table('tmp_cart as t1')
            ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
            ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart') 
            ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            ->where('user_id' , $user->id)
            ->where('t2.public_show' , 'true')
            ->where('t2.buffet','=', 'true')
            ->where('t1.is_ebook','=', 'false')
            ->groupBy('t1.book_id')
            // ->orderBy('t1.created_at' , 'ASC')
            ->orderBy('t2.book_name' , 'ASC')
            // ->orderBy('t1.id' , 'ASC')            
            ->get(); 

            if($tmp_carts->toArray()){
                foreach ($tmp_carts as $tmp_cart){
                    if($tmp_cart->can_discount){   
                        if($tmp_cart->can_discount == "true"){                                      
                            foreach ($discounts as $discount){
                                if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                    
                                    $discount_percen = $discount->discount ;
                                }
                            }
                            $total_discount +=  (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
                            // $html .= '<span>%</span>';
                        }else{
                            // $html .= '0';
                            // $html .= '<span>%</span>';
                        } 
                    }
                        $total_sub += $tmp_cart->price * $tmp_cart->sum_quantity ;

                    if($tmp_cart->can_discount){
                        if($tmp_cart->can_discount == "true"){
                            $total_book_price = ($tmp_cart->price * $tmp_cart->sum_quantity) - (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
                        }else{
                            $total_book_price = $tmp_cart->price * $tmp_cart->sum_quantity ;
                        }
                    }
                    
                    $total_book_price_all += $total_book_price ;
                    $sum_quantity_all += $tmp_cart->sum_quantity;

                        $total_final = $total_book_price_all ;
                }
            }
            if($tmp_carts_ebooks->toArray()){
                foreach ($tmp_carts_ebooks as $tmp_cart){
                    
                    $total_sub += $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                    $total_book_price = $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                    $total_book_price_all += $total_book_price ;
                    $sum_quantity_all += $tmp_cart->sum_quantity;
                    $total_final = $total_book_price_all ;
                }
            }

            if($tmp_carts_buffet->toArray()){
                foreach ($tmp_carts_buffet as $tmp_cart){
                    if($tmp_cart->can_discount){   
                        if($tmp_cart->can_discount == "true"){                                      
                            foreach ($discounts as $discount){
                                if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                    
                                    $discount_percen = $discount->discount ;
                                }
                            }
                            $total_discount +=  (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
                            // $html .= '<span>%</span>';
                        }else{
                            // $html .= '0';
                            // $html .= '<span>%</span>';
                        } 
                    }
                        //$total_sub += $tmp_cart->price * $tmp_cart->sum_quantity ;
                        

                    if($tmp_cart->can_discount){
                        if($tmp_cart->can_discount == "true"){
                            $total_book_price = ($tmp_cart->price * $tmp_cart->sum_quantity) - (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
                        }else{
                            $total_book_price = $tmp_cart->price * $tmp_cart->sum_quantity ;
                        }
                    }
                    
                    //total_book_price_all += $total_book_price ;
                    $sum_quantity_all += $tmp_cart->sum_quantity;

                    $sum_price_buffet_all += $total_book_price ;
                    $sum_quantity_buffet_all += $tmp_cart->sum_quantity ;

                        //$total_final = $total_book_price_all ;
                }

                foreach ($buffets as $buffet){
                    if($sum_quantity_buffet_all <= $buffet->book_number && $sum_quantity_buffet_all >= $buffet_pro_count+1 ){
                        $book_buffet_check = 'yes'; //รวมแล้วสินค้าไม่ถึงเป้า   
                        $buffet_book_number = $buffet->book_number ;    
                        $price_buffet = $buffet->total_price;  
                        $buffet_pro_count  = $buffet->book_number ; 
                        $buffet_check = 'false';    
                               
                    }
                    if($sum_quantity_buffet_all == $buffet->book_number){
                        $book_buffet_check = 'no'; //รวมแล้วสินค้าถึงเป้า  
                        $buffet_book_number = $buffet->book_number ;
                        $price_buffet = $buffet->total_price; 
                        //$html_buffet_tfoot .= '<span></span>';
                        $buffet_check = 'true';  
                    }
                }
                if($book_buffet_check == 'yes'){
                    $html_buffet_tfoot .= '<br><font style="color: green;">'.$sum_quantity_buffet_all.' เล่ม </font> <font style="color: red;">[ ขาดอีก '.($buffet_book_number-$sum_quantity_buffet_all).' เล่ม ] <u style="color:DodgerBlue;">'.$buffet_book_number.' เล่ม '.number_format(round((float)$price_buffet,2),2).' บาท</u></font>';                                                            
                    $sum_pridce_buf_final = $sum_price_buffet_all;  
                    $total_book_price_all += $sum_price_buffet_all;  
                    $total_book_price += $sum_price_buffet_all;
                    $total_sub += $sum_price_buffet_all;
                }else if($book_buffet_check == 'no'){
                    //$html_buffet_tfoot .= '<span>ครบ '.$buffet_book_number.' เล่ม</span>';
                    $html_buffet_tfoot .= '<br><font style="color: green;">'.$sum_quantity_buffet_all.' เล่ม <u style="color:DodgerBlue;">'.number_format(round((float)$price_buffet,2),2).' บาท</u></font>';                                                            
                    
                    $sum_pridce_buf_final = $price_buffet;  
                    $total_book_price_all += $price_buffet;  
                    $total_book_price += $price_buffet;
                    $total_sub += $price_buffet;
                }
                $total_final = $total_book_price_all ;

            }
            $address = Address::where('user_id' , $user->id)->where('default' , 'true')->first(); 
            // DD($address->toArray());


        return view("front-end.check-out" ,[
            'publishers' => $publishers ,
            'transports' => $transports ,
            'payments' => $payments ,
            'tmp_carts' => $tmp_carts ,
            'sum_quantity_all' => $sum_quantity_all ,
            'count_can_discount' => $count_can_discount ,
            'discount_percen' => $discount_percen ,
            'total_discount' => $total_discount ,
            'total_book_price_all' => $total_book_price_all ,
            'total_sub' => $total_sub , 
            'total_final' => $total_final, 
            'user' => $user ,
            'tmp_carts_buffet' => $tmp_carts_buffet ,
            'sum_quantity_buffet_all' => $sum_quantity_buffet_all ,
            'sum_pridce_buf_final' => $sum_pridce_buf_final ,
            'html_buffet_tfoot' => $html_buffet_tfoot ,
            'buffet_check' => $buffet_check ,
            'tmp_carts_ebooks' =>  $tmp_carts_ebooks ,
            'address' => $address
        ]);
    }
    public function indexEbook(Request $request)
    {

        //DD($request->all());
        $html = '';
        $user = null;
        $sum_quantity_all = 0;
        $total_book_price_all = 0 ;
        $total_sub = 0 ;
        $discount_percen=0;
        $total_discount=0;
        $total_final = 0 ;
        //variable buffet 
        $sum_price_buffet_all = 0;
        $sum_quantity_buffet_all = 0;
        $buffet_book_number = 0 ;
        $book_buffet_check = '';
        $price_buffet = 0; 
        $buffet_pro_count  = 0 ; 
        $sum_pridce_buf_final = 0;
        $html_buffet_tfoot = '';
        $buffet_check = '';
        //end variable buffet
        if (Auth::check()) {
            $user = Auth::user();
        }
        $publishers = Publisher::all();
        $transports = Transport::all();
        $discounts = Discount::all();
        $payments =  Payment::all();
        $buffets = Buffet::all();

          
            $tmp_carts_ebooks = DB::table('tmp_cart as t1')
            ->leftJoin('ebook_product as t2' , 't1.book_id' ,'t2.id' )
            ->select('t1.book_id' ,'t2.product_name','t2.alias_price','t2.product_price','t2.product_image','t1.id as id_cart') 
            ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            ->where('user_id' , $user->id)
            ->where('t2.public_show' , 'true')
            ->where('t1.is_ebook','=', 'true')
            ->groupBy('t1.book_id')
            // ->orderBy('t1.created_at' , 'ASC')
            ->orderBy('t2.product_name' , 'ASC')
            // ->orderBy('t1.id' , 'ASC')            
            ->get(); 

            if($tmp_carts_ebooks->toArray()){
                foreach ($tmp_carts_ebooks as $tmp_cart){
                    
                    $total_sub += $tmp_cart->product_price * $tmp_cart->sum_quantity ;
                    $total_book_price = $tmp_cart->product_price * $tmp_cart->sum_quantity ;
                    $total_book_price_all += $total_book_price ;
                    $sum_quantity_all += $tmp_cart->sum_quantity;
                    $total_final = $total_book_price_all ;
                }
            }
            
        return view("front-end-ebook.check-out" ,[
            'publishers' => $publishers ,
            'transports' => $transports ,
            'payments' => $payments ,
            'sum_quantity_all' => $sum_quantity_all ,
            'discount_percen' => $discount_percen ,
            'total_discount' => $total_discount ,
            'total_book_price_all' => $total_book_price_all ,
            'total_sub' => $total_sub , 
            'total_final' => $total_final, 
            'user' => $user ,
            'sum_quantity_buffet_all' => $sum_quantity_buffet_all ,
            'sum_pridce_buf_final' => $sum_pridce_buf_final ,
            'html_buffet_tfoot' => $html_buffet_tfoot ,
            'buffet_check' => $buffet_check ,
            'tmp_carts_ebooks' => $tmp_carts_ebooks ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
        }
        // DD($request->all());
        if(request()->ajax()) {
            $validator = Validator::make($request->all(), [
                'name'=> 'required',
                'tel'=> 'required',
                'full_address'=> 'required',
                'subdistric'=> 'required',
                'distric'=> 'required',
                'province'=> 'required',
                'zipcode'=> 'required',
            ],
            [
                'name.required' => 'กรุณากรอกชื่อ-สกุลผู้สั่งซื้อ',
                'tel.required' => 'กรุณากรอกเบอร์โทรศัพท์',
                'full_address.required' => 'กรุณากรอกบ้านเลขที่ , ถนน',
                'subdistric.required' => 'กรุณากรอกตำบล',
                'distric.required' => 'กรุณากรอกอำเภอ',
                'province.required' => 'กรุณากรอกจังหวัด',
                'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
            ]);
            if ($validator->passes()) {
                
                $address = Address::where('user_id' , $user->id)->update(['default' => 'false']);
                Address::create([
                    'fullname' => $request->name ,
                    'tel' => $request->tel ,
                    'address' => $request->full_address ,
                    'subdistric' => $request->subdistric ,
                    'distric' => $request->distric ,
                    'province' => $request->province ,
                    'zipcode' => $request->zipcode ,
                    'user_id' => $request->user_id ,
                    'default' => 'true'
                ]);
                return response()->json(['success'=>'Item saved successfully.' ]);     
            }
            return response()->json(['error'=>$validator->errors()->all()]);
            
        }
        // DD($request->all());
        // DD($request->all());
        
        // $html = '';
        // $user = null;
        // $sum_quantity_all = 0;
        // $total_book_price_all = 0 ;
        // $total_sub = 0 ;
        // $discount_percen=0;
        // $total_discount=0;
        // $total_final = 0 ;
        // $transport_select = '' ;
        // //variable buffet 
        // $sum_price_buffet_all = 0;
        // $sum_quantity_buffet_all = 0;
        // $buffet_book_number = 0 ;
        // $book_buffet_check = '';
        // $price_buffet = 0; 
        // $buffet_pro_count  = 0 ; 
        // $sum_pridce_buf_final = 0;
        // $html_buffet_tfoot = '';
        // $buffet_check = '';
        // //end variable buffet
        // if (Auth::check()) {
        //     $user = Auth::user();
        // }
        // $publishers = Publisher::all();
        // $transports = Transport::all();
        // $discounts = Discount::all();
        // $payments =  Payment::all();
        // $buffets = Buffet::all();

        //     $count_can_discount = DB::table('tmp_cart as t1')
        //     ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
        //     ->selectRaw('SUM(t1.quantity) AS count_can_discount')
        //     ->where('user_id' , $user->id)
        //     ->where('t2.can_discount' , 'true')
        //     ->where('t2.public_show' , 'true')
        //     ->where('t1.is_ebook','=', 'false')
        //     ->first();

        //     $tmp_carts = DB::table('tmp_cart as t1')
        //     ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
        //     ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart') 
        //     ->selectRaw('SUM(t1.quantity) AS sum_quantity')
        //     ->where('user_id' , $user->id)
        //     ->where('t2.public_show' , 'true')
        //     ->where('t2.buffet','<>', 'true')
        //     ->where('t1.is_ebook','=', 'false')
        //     ->groupBy('t1.book_id')
        //     // ->orderBy('t1.created_at' , 'ASC')
        //     ->orderBy('t2.book_name' , 'ASC')
        //     // ->orderBy('t1.id' , 'ASC')            
        //     ->get(); 

        //     $tmp_carts_buffet = DB::table('tmp_cart as t1')
        //     ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
        //     ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart') 
        //     ->selectRaw('SUM(t1.quantity) AS sum_quantity')
        //     ->where('user_id' , $user->id)
        //     ->where('t2.public_show' , 'true')
        //     ->where('t2.buffet','=', 'true')
        //     ->where('t1.is_ebook','=', 'false')
        //     ->groupBy('t1.book_id')
        //     // ->orderBy('t1.created_at' , 'ASC')
        //     ->orderBy('t2.book_name' , 'ASC')
        //     // ->orderBy('t1.id' , 'ASC')            
        //     ->get();     
        //     if($tmp_carts->toArray()){
        //         foreach ($tmp_carts as $tmp_cart){
        //             if($tmp_cart->can_discount){   
        //                 if($tmp_cart->can_discount == "true"){                                      
        //                     foreach ($discounts as $discount){
        //                         if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                    
        //                             $discount_percen = $discount->discount ;
        //                         }
        //                     }
        //                     $total_discount +=  (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
        //                     // $html .= '<span>%</span>';
        //                 }else{
        //                     // $html .= '0';
        //                     // $html .= '<span>%</span>';
        //                 } 
        //             }
        //                 $total_sub += $tmp_cart->price * $tmp_cart->sum_quantity ;

        //             if($tmp_cart->can_discount){
        //                 if($tmp_cart->can_discount == "true"){
        //                     $total_book_price = ($tmp_cart->price * $tmp_cart->sum_quantity) - (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
        //                 }else{
        //                     $total_book_price = $tmp_cart->price * $tmp_cart->sum_quantity ;
        //                 }
        //             }
                    
        //             $total_book_price_all += $total_book_price ;
        //             $sum_quantity_all += $tmp_cart->sum_quantity;

        //                 $total_final = $total_book_price_all ;
        //         }
        //     } 

        //     if($tmp_carts_buffet->toArray()){
        //         foreach ($tmp_carts_buffet as $tmp_cart){
        //             if($tmp_cart->can_discount){   
        //                 if($tmp_cart->can_discount == "true"){                                      
        //                     foreach ($discounts as $discount){
        //                         if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                    
        //                             $discount_percen = $discount->discount ;
        //                         }
        //                     }
        //                     $total_discount +=  (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
        //                     // $html .= '<span>%</span>';
        //                 }else{
        //                     // $html .= '0';
        //                     // $html .= '<span>%</span>';
        //                 } 
        //             }
        //                 //$total_sub += $tmp_cart->price * $tmp_cart->sum_quantity ;
                        

        //             if($tmp_cart->can_discount){
        //                 if($tmp_cart->can_discount == "true"){
        //                     $total_book_price = ($tmp_cart->price * $tmp_cart->sum_quantity) - (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
        //                 }else{
        //                     $total_book_price = $tmp_cart->price * $tmp_cart->sum_quantity ;
        //                 }
        //             }
                    
        //             //total_book_price_all += $total_book_price ;
        //             $sum_quantity_all += $tmp_cart->sum_quantity;

        //             $sum_price_buffet_all += $total_book_price ;
        //             $sum_quantity_buffet_all += $tmp_cart->sum_quantity ;

        //                 //$total_final = $total_book_price_all ;
        //         }

        //         foreach ($buffets as $buffet){
        //             if($sum_quantity_buffet_all <= $buffet->book_number && $sum_quantity_buffet_all >= $buffet_pro_count+1 ){
        //                 $book_buffet_check = 'yes'; //รวมแล้วสินค้าไม่ถึงเป้า   
        //                 $buffet_book_number = $buffet->book_number ;    
        //                 $price_buffet = $buffet->total_price;  
        //                 $buffet_pro_count  = $buffet->book_number ; 
        //                 $buffet_check = 'false';  
                               
        //             }
        //             if($sum_quantity_buffet_all == $buffet->book_number){
        //                 $book_buffet_check = 'no'; //รวมแล้วสินค้าถึงเป้า  
        //                 $buffet_book_number = $buffet->book_number ;
        //                 $price_buffet = $buffet->total_price; 
        //                 //$html_buffet_tfoot .= '<span></span>';
        //                 $buffet_check = 'true';  
        //             }
        //         }
        //         if($book_buffet_check == 'yes'){
        //             $html_buffet_tfoot .= '<br><font style="color: green;">'.$sum_quantity_buffet_all.' เล่ม </font> <font style="color: red;">[ ขาดอีก '.($buffet_book_number-$sum_quantity_buffet_all).' เล่ม ] <u style="color:DodgerBlue;">'.$buffet_book_number.' เล่ม '.number_format(round((float)$price_buffet,2),2).' บาท</u></font>';                                                            
        //             $sum_pridce_buf_final = $sum_price_buffet_all;  
        //             $total_book_price_all += $sum_price_buffet_all;  
        //             $total_book_price += $sum_price_buffet_all;
        //             $total_sub += $sum_price_buffet_all;
        //         }else if($book_buffet_check == 'no'){
        //             //$html_buffet_tfoot .= '<span>ครบ '.$buffet_book_number.' เล่ม</span>';
        //             $html_buffet_tfoot .= '<br><font style="color: green;">'.$sum_quantity_buffet_all.' เล่ม <u style="color:DodgerBlue;">'.number_format(round((float)$price_buffet,2),2).' บาท</u></font>';                                                            
                    
        //             $sum_pridce_buf_final = $price_buffet;  
        //             $total_book_price_all += $price_buffet;  
        //             $total_book_price += $price_buffet;
        //             $total_sub += $price_buffet;
        //         }
        //         $total_final = $total_book_price_all ;

        //     }


        //         if(!empty($request->transport)){
        //             $transport_select = Transport::find($request->transport) ;
        //             $total_final = $total_book_price_all + $transport_select->transport_rate;
        //         }else{
        //             $total_final = $total_book_price_all + 0;
        //         }
           
            
        // return view("front-end.check-out" ,[
        //     'publishers' => $publishers ,
        //     'transports' => $transports ,
        //     'payments' => $payments ,
        //     'tmp_carts' => $tmp_carts ,
        //     'sum_quantity_all' => $sum_quantity_all ,
        //     'count_can_discount' => $count_can_discount ,
        //     'discount_percen' => $discount_percen ,
        //     'total_discount' => $total_discount ,
        //     'total_book_price_all' => $total_book_price_all ,
        //     'total_sub' => $total_sub , 
        //     'total_final' => $total_final,
        //     'transport_select' => $transport_select ,
        //     'select_transport_id' => $request->transport , 
        //     'user' => $user ,
        //     'tmp_carts_buffet' => $tmp_carts_buffet ,
        //     'sum_quantity_buffet_all' => $sum_quantity_buffet_all ,
        //     'sum_pridce_buf_final' => $sum_pridce_buf_final ,
        //     'html_buffet_tfoot' => $html_buffet_tfoot ,
        //     'buffet_check' => $buffet_check ,
              
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //DD($request->all(),  $id);
        if(request()->ajax()) {

            // if(!empty($request->is_ebook)){ // this e-books only

            //     $user = User::find($id);
            //     $date = date('Y-m-d');
            //     $time = date('H:i:s');
            //     $order_mas = OrderMasEbook::create([
            //         'order_date' => $date ,
            //         'order_time' => $time ,
            //         'username' => $user->username ,
            //         'total_order' => $request->net_price ,
            //         'order_status' => 'p' ,
            //         'approve_status' => 'n' ,
            //     ]);
                

            //     $tmp_carts_ebooks = TmpCart::with(['getProduct' => function($query){
            //         $query->where('public_show', 'true');
            //         $query->orderBy('book_name','ASC');
            //     }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
            //     ->where('is_ebook', 'true')
            //     ->where('user_id', $user->id)  
            //     ->groupBy('book_id')          
            //     ->get();

            //     // $tmp_carts_ebooks = DB::table('tmp_cart as t1')
            //         // ->leftJoin('ebook_product as t2' , 't1.book_id' ,'t2.id' )
            //         // ->select('t1.book_id' ,'t2.product_name','t2.alias_price','t2.product_price','t2.product_image','t1.id as id_cart','t1.username') 
            //         // ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            //         // ->where('user_id' , $user->id)
            //         // ->where('t2.public_show' , 'true')
            //         // ->where('t1.is_ebook','=', 'true')
            //         // ->groupBy('t1.book_id')
            //         // ->orderBy('t2.product_name' , 'ASC')          
            //         // ->get(); 

            //         foreach ($tmp_carts_ebooks as $tmp_cart){
            //             $order_tran = new OrderTranEbook();
            //             $order_tran->order_id = $order_mas->id;
            //             $order_tran->product_id = $tmp_cart->book_id;
            //             $order_tran->username = $tmp_cart->username;
            //             $order_tran->product_price = $tmp_cart->alias_price;
            //             $order_tran->product_qty = $tmp_cart->sum_quantity;
            //             $order_tran->total_price = $tmp_cart->product_price;
            //             $order_tran->order_status = "n";
            //             $order_tran->order_date = date('Y-m-d H:i:s');
            //             $order_tran->save();
            //             // $total_book_price = $tmp_cart->product_price * $tmp_cart->sum_quantity ;
            //             //     $order_tran->net = $total_book_price;
            //         }

            //     $tmp_carts = TmpCart::where('user_id',$id)->where('is_ebook', 'true');
            //     $tmp_carts->delete();
            //     return response()->json(['success'=>'Item saved successfully.' ,'is_ebook'=>'true']);     

            // }else{ // this order book only

                
                $user = User::find($id);
                $user->update([
                    // 'name' => $request->name ,
                    // 'tel' => $request->tel ,
                    'name_send' => $request->name ,
                    'phone_send' => $request->tel ,
                    'address_full' => $request->full_address ,
                    'distric' => $request->distric ,
                    'subdistric' => $request->subdistric ,
                    'province' => $request->province ,
                    'zipcode' => $request->zipcode ,
                ]);
                
                $tmp_carts_ebooks = TmpCart::with(['getProduct' => function($query){
                    $query->where('public_show', 'true');
                    $query->orderBy('book_name','ASC');
                }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
                ->where('is_ebook', 'true')
                ->where('user_id', $user->id)  
                ->groupBy('book_id')          
                ->get();

                

                $tmp_carts = TmpCart::with(['getProduct' => function($query){
                    $query->where('public_show', 'true');
                    $query->orderBy('book_name','ASC');                    
                }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
                // ->where('buffet' ,'!=', 'true')
                ->where('is_ebook', 'false')
                ->where('user_id', $user->id)  
                ->groupBy('book_id')          
                ->get();
                // return response()->json(['warning'=>'สินค้าหมด' ,'item_out'=> $tmp_carts->all() ]); 

                
                
                // return response()->json(['success'=>'Item saved successfully.' ,'tmp_carts'=> $tmp_carts ]); 

                // $tmp_carts = DB::table('tmp_cart as t1')
                // ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
                // ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart') 
                // ->selectRaw('SUM(t1.quantity) AS sum_quantity')
                // ->where('user_id' , $user->id)
                // ->where('t2.public_show' , 'true')
                // ->where('t2.buffet' ,'<>', 'true')
                // ->where('t1.is_ebook','=', 'false')
                // ->groupBy('t1.book_id')
                // ->orderBy('t2.book_name' , 'ASC')          
                // ->get(); 

                $tmp_carts_buffets = TmpCart::with(['getProduct' => function($query){
                    $query->where('public_show', 'true');
                    $query->orderBy('book_name','ASC');
                }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
                ->where('buffet' ,'=', 'true')
                ->where('is_ebook', 'false')
                ->where('user_id', $user->id)  
                ->groupBy('book_id')          
                ->get();

                // return response()->json(['success'=>'Item saved successfully.' ,'tmp_carts'=> $tmp_carts->all() ,'tmp_carts_ebooks'=> $tmp_carts_ebooks->all() ,'tmp_carts_buffets'=> $tmp_carts_buffets->all() ]); 

                // $tmp_carts_buffets = DB::table('tmp_cart as t1')
                // ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
                // ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart') 
                // ->selectRaw('SUM(t1.quantity) AS sum_quantity')
                // ->where('user_id' , $user->id)
                // ->where('t2.public_show' , 'true')
                // ->where('t2.buffet' ,'=', 'true')
                // ->where('t1.is_ebook','=', 'false')
                // ->groupBy('t1.book_id')
                // ->orderBy('t2.book_name' , 'ASC')        
                // ->get();

                // return response()->json(['warning'=>'สินค้าหมด' ,'item_out'=> $tmp_carts ]); 
                if(!empty($tmp_carts->toArray())){
                    $arr_item = [];
                    foreach ($tmp_carts as $tmp_cart){
                        // return response()->json(['warning'=>'สินค้าหมด' ,'item_out'=> $tmp_cart->getProduct->stock_remain ]); 
                        if($tmp_cart->sum_quantity > (int)$tmp_cart->getProduct->stock_remain){
                            array_push($arr_item, (int)$tmp_cart->getProduct->book_name);
                        }
                    }
                    if(!empty($arr_item)){
                        return response()->json(['warning'=>'สินค้าหมด' ,'item_out'=> $arr_item ]); 
                    }
                }
                // return response()->json(['warning'=>'สินค้าหมด' ,'item_out'=> $tmp_carts->all() ]); 

                if(!empty($tmp_carts_buffets->toArray())){
                    $arr_item = [];
                    foreach ($tmp_carts_buffets as $tmp_cart){
                        if($tmp_cart->sum_quantity > $tmp_cart->getProduct->stock_remain){
                            array_push($arr_item, $tmp_cart->getProduct->book_name);
                        }
                    }
                    if(!empty($arr_item)){
                        return response()->json(['warning'=>'สินค้าหมด' ,'item_out'=> $arr_item ]); 
                    }
                }
                

                $date = date('Y-m-d');
                $time = date('H:i:s');
                if(!empty($tmp_carts_ebooks->toArray())){
                    $book_available = 'n';
                    $approve_status = 'n';
                    $transport_rate = '';
                    $transport_name = '';
                }
                if(!empty($tmp_carts->toArray()) || !empty($tmp_carts_buffets->toArray())){
                    $transport = Transport::find($request->transport);
                    $book_available = 'y';
                    $approve_status = NULL;
                    $transport_rate = $transport->transport_rate;
                    $transport_name = $transport->transport;
                }
                if((!empty($tmp_carts->toArray()) || !empty($tmp_carts_buffets->toArray())) && !empty($tmp_carts_ebooks->toArray())){
                    $transport = Transport::find($request->transport);
                    $book_available = 'y';
                    $approve_status = 'n';
                    $transport_rate = $transport->transport_rate;
                    $transport_name = $transport->transport;
                }
                
                $order_mas = OrderMas::create([
                    'order_date' => $date ,
                    'order_time' => $time ,
                    'username' => $user->username ,
                    'transport' => $transport_name ,
                    'transport_rate' => $transport_rate ,
                    'net_price' => $request->net_price ,
                    'order_status' => 'รอชำระเงิน' ,
                    'show_status' => 'y' ,
                    'tranfer_address' => $request->full_address ,
                    'fullname' => $request->name ,
                    'phone' => $request->tel ,       
                    'address_subdistric' => $request->subdistric ,
                    'address_distric' => $request->distric ,
                    'address_province' => $request->province ,
                    'address_zipcode' => $request->zipcode ,                 
                    'user_id' => $id ,
                    'book_available' => $book_available ,
                    'approve_status' => $approve_status
                ]);
        
                if(!empty($tmp_carts_ebooks->toArray())){
                    $web_config = WebConfig::first();
                    foreach ($tmp_carts_ebooks as $tmp_cart){
                    
                        $order_tran = new OrderTran();
                        $order_tran->order_id = $order_mas->id;
                        $order_tran->book_id = $tmp_cart->book_id;
                        $order_tran->quantitys = $tmp_cart->sum_quantity;
                        $order_tran->price = $tmp_cart->getProduct->price;
                        $order_tran->product_price = $tmp_cart->getProduct->product_price;
                        $order_tran->username = $user->username ;
                        $order_tran->is_ebook = "true" ;
                        $order_tran->approve_status = $approve_status ;

                        $order_tran->percent_discount = 0;
                        $order_tran->discount = 0;
                        $total_book_price = $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                        $order_tran->net = $total_book_price;

                        $order_tran->save();

                    }
                }

                if(!empty($tmp_carts->toArray())){

                    foreach ($tmp_carts as $tmp_cart){
                        $order_tran = new OrderTran();
                        $order_tran->order_id = $order_mas->id;
                        $order_tran->book_id = $tmp_cart->book_id;
                        $order_tran->quantitys = $tmp_cart->sum_quantity;
                        $order_tran->price = $tmp_cart->getProduct->price;
                        $order_tran->product_price = $tmp_cart->getProduct->product_price;
                        $order_tran->username = $user->username ;
                        $order_tran->is_ebook = "false" ;
                        $order_tran->approve_status = $approve_status ;

                        if(!empty($tmp_cart->can_discount)){   
                            if($tmp_cart->can_discount == "true"){                                
                                $discount_book = (($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity) * $request->discount_percen / 100);

                                $order_tran->percent_discount = $request->discount_percen;
                                $order_tran->discount = $discount_book;
                                
                                $total_book_price = ($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity) - (($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity) * $request->discount_percen / 100);
                                $order_tran->net = $total_book_price;
                                
                            }else{
                                $order_tran->percent_discount = 0;
                                $order_tran->discount = 0;
                                $total_book_price = $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                                $order_tran->net = $total_book_price;
                            } 
                        }
                        $order_tran->save();

                        $product = Product::find($tmp_cart->book_id);
                        $stock_remain = $product->stock_remain - $tmp_cart->sum_quantity; //สินค้าพร้อมขายใหม่ -
                        $stock_hold = $product->stock_hold + $tmp_cart->sum_quantity; //สินค้าติดจองใหม่ +

                        $product->update([
                            'stock_remain' => $stock_remain ,
                            'stock_hold' => $stock_hold
                        ]);
                    }
                }
                // return response()->json(['success'=>'Item saved successfully.' ,'le'=> $tmp_carts_buffets->toArray() ]); 
                
                if(!empty($tmp_carts_buffets->toArray())){

                    foreach ($tmp_carts_buffets as $tmp_cart){
                        $order_tran = new OrderTran();
                        $order_tran->order_id = $order_mas->id;
                        $order_tran->book_id = $tmp_cart->book_id;
                        $order_tran->quantitys = $tmp_cart->sum_quantity;
                        $order_tran->price = $tmp_cart->getProduct->price;
                        $order_tran->product_price = $tmp_cart->getProduct->product_price;
                        $order_tran->username = $user->username ;
                        $order_tran->is_ebook = "false" ;
                        if(!empty($tmp_cart->can_discount)){   
                            if($tmp_cart->can_discount == "true"){                                
                                $discount_book = (($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity) * $request->discount_percen / 100);

                                $order_tran->percent_discount = $request->discount_percen;
                                $order_tran->discount = $discount_book;
                                
                                $total_book_price = ($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity) - (($tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity) * $request->discount_percen / 100);
                                $order_tran->net = $total_book_price;
                                
                            }else{
                                $order_tran->percent_discount = 0;
                                $order_tran->discount = 0;
                                $total_book_price = $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                                $order_tran->net = $total_book_price;
                            } 
                        }
                        if(!empty($request->buffet_check)){
                            if($request->buffet_check == "true"){
                                $order_tran->net = $request->sum_pridce_buf_final;
                            }
                        }
                        $order_tran->save();

                        $product = Product::find($tmp_cart->book_id);
                        $stock_remain = $product->stock_remain - $tmp_cart->sum_quantity; //สินค้าพร้อมขายใหม่ -
                        $stock_hold = $product->stock_hold + $tmp_cart->sum_quantity; //สินค้าติดจองใหม่ +

                        $product->update([
                            'stock_remain' => $stock_remain ,
                            'stock_hold' => $stock_hold
                        ]);
                    }
                }

                $tmp_carts = TmpCart::where('user_id',$id);
                $tmp_carts->delete();
                return response()->json(['success'=>'Item saved successfully.' ]);      

            // }
            
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        
        if(request()->ajax()) {
            
            if(!empty($request->fn)){   
                if($request->fn === "delete_address"){
                    $address = Address::find($id)->delete();
                    return response()->json(['success'=>'Item Delete successfully.' ]);     
                }
            }
        }
        
    }
}
