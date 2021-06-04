<?php

namespace App\Http\Controllers;

use App\Publisher;
use App\TmpCart;
use App\Transport;
use App\Discount;
use App\Payment;
use App\Product;
use App\Buffet;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TmpCartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    { 
        $user = null;
        $username = '';
        $sum_quantity_all = 0;
        $total_book_price_all = 0 ;
        $total_final = 0 ;
            
        if (Auth::check()) {
            $user = Auth::user();
            $username = $user->username ;
        }

        $publishers = Publisher::all();
        $transports = Transport::all();
        $discounts = Discount::all();
        $payments =  Payment::all();
        $buffets = Buffet::all();
   
        if(request()->ajax()) { 
            
            $html = '';
            $val_discount = 0 ;
            $sum_quantity_all = 0;
            $total_book_price_all = 0 ;
            $total_final = 0 ;
            $sum_price_buffet_all = 0;

               if(!empty($request->fn)){
                    $tmp = TmpCart::leftJoin('product','tmp_cart.book_id' ,'product.id')->where('tmp_cart.id',$request->id_cart)
                    ->select('tmp_cart.*' , 'product.stock','product.stock_remain')->first();
                     //return response()->json(['success'=>'fetch data success.' , '555555' => $request->all() ]);
                    if($request->fn === "qua_minus"){
                        if($tmp->quantity == 1){
                            $tmp->delete();
                        }else{
                            $tmp->update([
                                'quantity' => $tmp->quantity-1
                            ]);
                        }
                    }
                    if($request->fn === "qua_plus"){
                        $tmp_carts = TmpCart::leftJoin('product as t2' , 'tmp_cart.book_id' ,'t2.id' )
                            ->select('tmp_cart.*' ,'tmp_cart.book_id' ,'t2.book_name' ,'t2.stock','t2.stock_remain') 
                            ->selectRaw('SUM(tmp_cart.quantity) AS sum_quantity')
                            ->where('user_id' , $user->id)
                            ->where('tmp_cart.book_id',$request->id_book)
                            ->groupBy('tmp_cart.book_id')
                            ->first();
                            //return response()->json(['success'=>'fetch data success.' , '555555' => $tmp_carts->sum_quantity ]);
                        if(($tmp_carts->sum_quantity+1) > $tmp_carts->stock_remain){
                            return response()->json(['error'=>'สินค้าหมด']);
                        }
                        
                        $tmp->update([
                            'quantity' => $tmp->quantity+1
                        ]);
                    }
                    if($request->fn === "delete"){
                        TmpCart::where('book_id',$request->id_book)->where('username' ,$username )->delete();

                    }
               }
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
            ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart','t2.blame_images') 
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
            ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart','t2.blame_images') 
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
            //return response()->json(['success'=>'fetch data success.' , 'tmp_carts' => $tmp_carts->toArray() , 'tmp_carts_buffet' => $tmp_carts_buffet->toArray() ]);
                            
                    if($tmp_carts_ebooks->toArray()){
                        $sum_quantity_ebook_all = 0 ;
                        $sum_price_ebook_final = 0 ; 
                        $html .= '<tr>                                
                                            <th colspan="8" >รายการ E-Book </th>                           
                                        </tr>';
                        foreach ($tmp_carts_ebooks as $tmp_cart){

                            $html .= '                            
                            <tr>
                                <td colspan="2" class="cart-pic first-row">';
                                    if(!empty($tmp_cart->getProduct->picture)){
                                        // $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" >';                                                       
                                        //  pic_test 
                                        $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("storage/book-images/".$tmp_cart->getProduct->picture).'" >';                                                                                                        
                            
                                    }else{
                                        $html .='<img style="background-color: HoneyDew;" class="img-thumbnail " src="'.asset("img/no_pic.png").'" >';                                                                 
                                    }
                                    
                            $html .= '  </td>
                                <td class="cart-title first-row">
                                    <h5>'.$tmp_cart->getProduct->book_name.'</h5>
                                </td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                            <div class="form-inline">
                                                <a href="javascript:void(0)" class="qua_minus disabled"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-minus-square fa-2x"></i></font></a>
                                                <input readonly type="text" size="2" class="form-control qua_change" id="quantity'.$tmp_cart->id.'" data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" value="'.$tmp_cart->sum_quantity.'" onkeypress="return isNumber(event)"/>
                                                
                                                <a href="javascript:void(0)" class="qua_plus disabled"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-plus-square fa-2x"></i></font></a>
                                            </div>
                                        
                                    </div>
                                </td>
                                <td class="first-row">
                                    <font color="DarkRed">
                                        <b>';
                                            
                                                    $html .= '0';
                                                    $html .= '<span>%</span>';
                                            
                                $html .= '</b>
                                    </font>
                                </td>
                                <td class="first-row">
                                    <font color="DarkBlue">';
                                        if(!empty($tmp_cart->getProduct->product_price)){
                                            $html .= '<b>'.number_format(round((float)$tmp_cart->getProduct->product_price,2),2).' บาท</b>';
                                        }
                            $html .= '</font>
                                </td>                                
                                <td class="total-price first-row"> ';
                                    $total_book_price = $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                                    $html .= ''.number_format(round((float)$total_book_price,2),2).' บาท';
                                    
                                    $total_book_price_all += $total_book_price ;
                                    $sum_price_ebook_final += $total_book_price ;
                                    
                                $html .= '</td> 
                                <td class="close-td first-row"><a href="javascript:void(0)" class="delete"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" data-type="ebook" ><font color="red"><i class="far fa-times-circle fa-2x"></i></font></a></td> 
                            </tr>';
                            $sum_quantity_all += $tmp_cart->sum_quantity;
                            $sum_quantity_ebook_all += $tmp_cart->sum_quantity ;
                        }
                        $html .='<tr >
                                        <th colspan="3">รวม E-Book </th>
                                        <th><span>'.$sum_quantity_ebook_all.'</span> เล่ม</th>
                                        <th colspan="4"><span class="">'.number_format(round((float)$sum_price_ebook_final,2),2).'</span> บาท</th> 
                                    </tr>';
                        
                    }


                    if($tmp_carts->toArray()){
                        $sum_quantity_book_all = 0 ;
                        $sum_price_book_final = 0 ;
                        $html .= '<tr>                                
                                            <th colspan="8" >รายการหนังสือปกติ</th>                           
                                        </tr>';
                        foreach ($tmp_carts as $tmp_cart){

                            $html .= '                            
                            <tr>
                                <td colspan="2" class="cart-pic first-row">';
                                    if($tmp_cart->picture){
                                        // $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" >';                                                       
                                        //  pic_test 
                                        $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("img/books_test.jpg").'" >';                                                                                                        
                              
                                    }else{
                                        $html .='<img style="background-color: HoneyDew;" class="img-thumbnail " src="'.asset("img/no_pic.png").'" >';                                                                 
                                    }
                                    
                            $html .= '  </td>
                                <td class="cart-title first-row">
                                    <h5>'.$tmp_cart->book_name.'</h5>
                                </td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                            <div class="form-inline">
                                                <a href="javascript:void(0)" class="qua_minus"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-minus-square fa-2x"></i></font></a>
                                                <input readonly type="text" size="2" class="form-control qua_change" id="quantity'.$tmp_cart->id_cart.'" data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" value="'.$tmp_cart->sum_quantity.'" onkeypress="return isNumber(event)"/>
                                                  
                                                <a href="javascript:void(0)" class="qua_plus"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-plus-square fa-2x"></i></font></a>
                                            </div>
                                        
                                    </div>
                                </td>
                                <td class="first-row">
                                    <font color="DarkRed">
                                        <b>';
                                            if($tmp_cart->can_discount){   
                                                if($tmp_cart->can_discount == "true"){  
                                                    //return response()->json(['success'=>'fetch data success.' , 'count_can_discount' => $count_can_discount->count_can_discount]);                                    
                                                    foreach ($discounts as $discount){
                                                        if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                                            $html .= ''.$discount->discount;
                                                            $val_discount = $discount->discount ;
                                                        }
                                                    }
                                                    //return response()->json(['success'=>'fetch data success.' , 'val' => $val_discount]);
                                                    $html .= '<span>%</span>';
                                                }else{
                                                    $html .= '0';
                                                    $html .= '<span>%</span>';
                                                } 
                                            }
                                $html .= '</b>
                                    </font>
                                </td>
                                <td class="first-row">
                                    <font color="DarkBlue">';
                                        if($tmp_cart->price){
                                            $html .= '<b>'.number_format(round((float)$tmp_cart->price,2),2).' บาท</b>';
                                        }
                            $html .= '</font>
                                </td>                                
                                <td class="total-price first-row"> ';
                                    if($tmp_cart->can_discount){
                                        if($tmp_cart->can_discount == "true"){
                                            $total_book_price = ($tmp_cart->price * $tmp_cart->sum_quantity) - (($tmp_cart->price * $tmp_cart->sum_quantity) * $val_discount / 100);
                                            $html .= ''.number_format(round((float)$total_book_price,2),2).' บาท';
                                        }else{
                                            $total_book_price = $tmp_cart->price * $tmp_cart->sum_quantity ;
                                            $html .= ''.number_format(round((float)$total_book_price,2),2).' บาท';
                                        }
                                    }
                                    
                                    $total_book_price_all += $total_book_price ;
                                    $sum_price_book_final  += $total_book_price ;
                                    
                                $html .= '</td> 
                                <td class="close-td first-row"><a href="javascript:void(0)" class="delete"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" ><font color="OrangeRed"><i class="far fa-times-circle fa-2x"></i></font></a></td> 
                            </tr>';
                            $sum_quantity_all += $tmp_cart->sum_quantity;
                            $sum_quantity_book_all += $tmp_cart->sum_quantity ;
                        }
                            $html .='<tr >
                                        <th colspan="3">รวมรายการหนังสือปกติ</th>
                                        <th><span>'.$sum_quantity_book_all.'</span> เล่ม</th>
                                        <th colspan="4"><span class="">'.number_format(round((float)$sum_price_book_final,2),2).'</span> บาท</th> 
                                    </tr>';
                    }
                    if($tmp_carts_buffet->toArray()){
                        $sum_quantity_buffet_all = 0 ;
                        $html .= '<tr>                                
                                            <th colspan="8" >รายการบุฟเฟ่ต์</th>                           
                                        </tr>';
                        foreach ($tmp_carts_buffet as $tmp_cart){

                            $html .= '                            
                            <tr>
                                <td colspan="2" class="cart-pic first-row">';
                                    if($tmp_cart->picture){
                                        // $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" >';                                                       
                                        //  pic_test 
                                        $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("img/books_test.jpg").'" >';                                                                                       
                                    }else{
                                        $html .='<img style="background-color: HoneyDew;" class="img-thumbnail " src="'.asset("img/no_pic.png").'" >';                                                                 
                                    }
                                    
                            $html .= '  </td>
                                <td class="cart-title first-row">
                                    <h5>'.$tmp_cart->book_name.'</h5>
                                </td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                            <div class="form-inline">
                                                <a href="javascript:void(0)" class="qua_minus"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-minus-square fa-2x"></i></font></a>
                                                <input readonly type="text" size="2" class="form-control qua_change" id="quantity'.$tmp_cart->id_cart.'" data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" value="'.$tmp_cart->sum_quantity.'" onkeypress="return isNumber(event)"/>
                                                  
                                                <a href="javascript:void(0)" class="qua_plus"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-plus-square fa-2x"></i></font></a>
                                            </div>
                                        
                                    </div>
                                </td>
                                <td class="first-row">
                                    <font color="DarkRed">
                                        <b>';
                                            if($tmp_cart->can_discount){   
                                                if($tmp_cart->can_discount == "true"){                                      
                                                    foreach ($discounts as $discount){
                                                        if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                                            $html .= ''.$discount->discount;
                                                            $val_discount = $discount->discount ;
                                                        }
                                                    }
                                                    $html .= '<span>%</span>';
                                                }else{
                                                    $html .= '0';
                                                    $html .= '<span>%</span>';
                                                } 
                                            }
                                $html .= '</b>
                                    </font>
                                </td>
                                <td class="first-row">
                                    <font color="DarkBlue">';
                                        if($tmp_cart->price){
                                            $html .= '<b>'.number_format(round((float)$tmp_cart->price,2),2).' บาท</b>';
                                        }
                            $html .= '</font>
                                </td>                                
                                <td class="total-price first-row"> ';
                                    if($tmp_cart->can_discount){
                                        if($tmp_cart->can_discount == "true"){
                                            $total_book_price = ($tmp_cart->price * $tmp_cart->sum_quantity) - (($tmp_cart->price * $tmp_cart->sum_quantity) * $val_discount / 100);
                                            $html .= ''.number_format(round((float)$total_book_price,2),2).' บาท';
                                        }else{
                                            $total_book_price = $tmp_cart->price * $tmp_cart->sum_quantity ;
                                            $html .= ''.number_format(round((float)$total_book_price,2),2).' บาท';
                                        }
                                    }
                                    
                                    //$total_book_price_all += $total_book_price ;
                                    $sum_price_buffet_all += $total_book_price ;
                                    
                                $html .= '</td> 
                                <td class="close-td first-row"><a href="javascript:void(0)" class="delete"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" ><font color="OrangeRed"><i class="far fa-times-circle fa-2x"></i></font></a></td> 
                            </tr>';
                            $sum_quantity_all += $tmp_cart->sum_quantity;
                            $sum_quantity_buffet_all += $tmp_cart->sum_quantity ;
                            
                        }
                        $html_buffet_tfoot = '';
                        $price_buffet = 0; 
                        $book_buffet_check = '';
                        $buffet_book_number = 0 ;
                        $buffet_pro_count  = 0 ; 
                        $sum_pridce_buf_final = 0;
                        foreach ($buffets as $buffet){
                            if($sum_quantity_buffet_all <= $buffet->book_number && $sum_quantity_buffet_all >= $buffet_pro_count+1 ){
                                $book_buffet_check = 'yes'; //รวมแล้วสินค้าไม่ถึงเป้า   
                                $buffet_book_number = $buffet->book_number ;    
                                $price_buffet = $buffet->total_price;  
                                $buffet_pro_count  = $buffet->book_number ;   
                                       
                            }
                            if($sum_quantity_buffet_all == $buffet->book_number){
                                $book_buffet_check = 'no'; //รวมแล้วสินค้าถึงเป้า  
                                $buffet_book_number = $buffet->book_number ;
                                $price_buffet = $buffet->total_price; 
                                //$html_buffet_tfoot .= '<span></span>';
                            }
                        }
                        if($book_buffet_check == 'yes'){
                            $html_buffet_tfoot .= '<span style="color: red;"> ขาดอีก '.($buffet_book_number-$sum_quantity_buffet_all).' เล่ม <br>'.$buffet_book_number.' เล่ม '.number_format(round((float)$price_buffet,2),2).' บาท</span>';                                                            
                            $sum_pridce_buf_final = $sum_price_buffet_all;  
                            $total_book_price_all += $sum_price_buffet_all;  
                        }else if($book_buffet_check == 'no'){
                            $html_buffet_tfoot .= '<span style="color:red;">(เหมา)</span>';
                            $sum_pridce_buf_final = $price_buffet;  
                            $total_book_price_all += $price_buffet;  
                        }
                        $html .='<tr >
                                        <th colspan="3">รวมรายการบุฟเฟ่ต์</th>
                                        <th><span>'.$sum_quantity_buffet_all.'</span> เล่ม '.$html_buffet_tfoot.'</th>
                                        <th colspan="4"><span class="">'.number_format(round((float)$sum_pridce_buf_final,2),2).'</span> บาท</th> 
                                    </tr>';

                    }
                            
                            $transports_last = Transport::all()->last();

                            
                            $html_total_book_price_all = ''.number_format(round((float)$total_book_price_all,2),2) ;
                            
                            $html_transport = '';
                            if(!empty($request->transport_name) || !empty($request->transport_rate) ){
                               $total_final = $total_book_price_all + $request->transport_rate ;
                               $html_transport = '<font color="ForestGreen"><i class="fas fa-truck-moving"></i> ค่าจัดส่ง [ '.$request->transport_name.' ]</font> <span>'.$request->transport_rate.' บาท</span>';
                            }else{
                                $total_final = $total_book_price_all + $transports_last->transport_rate ;
                                $html_transport = '<font color="ForestGreen"><i class="fas fa-truck-moving"></i> ค่าจัดส่ง [ '.$transports_last->transport.' ]</font> <span>'.$transports_last->transport_rate.' บาท</span>';
                            }
                            
                            $html_total_final = ''.number_format(round((float)$total_final,2),2) ;
                            

                            //
                            //

             return response()->json(['success'=>'fetch data success.' , 'html'=> $html ,
             'total_final'=>$total_final,'html_total_final'=>$html_total_final ,
             'total_book_price_all' => $total_book_price_all ,'html_total_book_price_all'=> $html_total_book_price_all ,
             'sum_quantity_all' => $sum_quantity_all , 'html_transport' => $html_transport , 'val' => $val_discount
               ]);
             
        }
        

        //DD($count_can_discount);
        
        
        return view("front-end.cart" ,[
            'publishers' => $publishers ,
            'transports' => $transports ,
            //'tmp_carts' => $tmp_carts ,
            // 'discounts' => $discounts ,
            'payments' => $payments ,
            'sum_quantity_all' => $sum_quantity_all ,
            // 'count_can_discount' => $count_can_discount ,
            'total_book_price_all' => $total_book_price_all ,
            'total_final' => $total_final, 
        ]);
    }
    public function indexEbook(Request $request)
    {
        
        
        $user = null;
        $username = '';
        $sum_quantity_all = 0;
        $total_book_price_all = 0 ;
        $total_final = 0 ;
        if (Auth::check()) {
            $user = Auth::user();
            $username = $user->username ;
        }
        $publishers = Publisher::all();
        $transports = Transport::all();
        $discounts = Discount::all();
        $payments =  Payment::all();
        $buffets = Buffet::all();
   
        if(request()->ajax()) { 
            
            $html = '';
            $val_discount = 0 ;
            $sum_quantity_all = 0;
            $total_book_price_all = 0 ;
            $total_final = 0 ;
            $sum_price_buffet_all = 0;

               if(!empty($request->fn)){
                    if($request->fn === "delete"){
                        TmpCart::where('book_id',$request->id_book)->where('username' , $username)->delete();
                    }
               }
            // $tmp_carts_ebooks = DB::table('tmp_cart as t1')
            // ->leftJoin('ebook_product as t2' , 't1.book_id' ,'t2.id' )
            // ->select('t1.book_id' ,'t2.product_name','t2.alias_price','t2.product_price','t2.product_image','t1.id as id_cart') 
            // ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            // ->where('user_id' , $user->id)
            // ->where('t2.public_show' , 'true')
            // ->where('t1.is_ebook','=', 'true')
            // ->groupBy('t1.book_id')
            // // ->orderBy('t1.created_at' , 'ASC')
            // ->orderBy('t2.product_name' , 'ASC')
            // // ->orderBy('t1.id' , 'ASC')            
            // ->get();

            $tmp_carts_ebooks = TmpCart::with(['getProduct' => function($query){
                $query->where('public_show', 'true');
                $query->orderBy('book_name','ASC');
            }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
            ->where('is_ebook', 'true')
            ->where('user_id', $user->id)  
            ->groupBy('book_id')          
            ->get();
            // DD($tmp_carts_ebooks->all());

                    if($tmp_carts_ebooks->toArray()){
                        foreach ($tmp_carts_ebooks as $tmp_cart){

                            $html .= '                            
                            <tr>
                                <td colspan="2" class="cart-pic first-row">';
                                    if(!empty($tmp_cart->getProduct->picture)){
                                        // $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" >';                                                       
                                        //  pic_test 
                                        $html .='<img style="background-color: HoneyDew;" width="150" height="150" class="img-thumbnail " src="'.asset("storage/book-images/".$tmp_cart->getProduct->picture).'" >';                                                                                                        
                            
                                    }else{
                                        $html .='<img style="background-color: HoneyDew;" class="img-thumbnail " src="'.asset("img/no_pic.png").'" >';                                                                 
                                    }
                                    
                            $html .= '  </td>
                                <td class="cart-title first-row">
                                    <h5>'.$tmp_cart->getProduct->book_name.'</h5>
                                </td>
                                <td class="qua-col first-row">
                                    <div class="quantity">
                                            <div class="form-inline">
                                                <a href="javascript:void(0)" class="qua_minus disabled"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-minus-square fa-2x"></i></font></a>
                                                <input readonly type="text" size="2" class="form-control qua_change" id="quantity'.$tmp_cart->id.'" data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" value="'.$tmp_cart->sum_quantity.'" onkeypress="return isNumber(event)"/>
                                                
                                                <a href="javascript:void(0)" class="qua_plus disabled"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" name="quantity" data-value="'.$tmp_cart->sum_quantity.'"><font color="MidnightBlue"><i class="far fa-plus-square fa-2x"></i></font></a>
                                            </div>
                                        
                                    </div>
                                </td>
                                <td class="first-row">
                                    <font color="DarkRed">
                                        <b>';
                                            
                                                    $html .= '0';
                                                    $html .= '<span>%</span>';
                                             
                                $html .= '</b>
                                    </font>
                                </td>
                                <td class="first-row">
                                    <font color="DarkBlue">';
                                        if(!empty($tmp_cart->getProduct->product_price)){
                                            $html .= '<b>'.number_format(round((float)$tmp_cart->getProduct->product_price,2),2).' บาท</b>';
                                        }
                            $html .= '</font>
                                </td>                                
                                <td class="total-price first-row"> ';
                                    $total_book_price = $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
                                    $html .= ''.number_format(round((float)$total_book_price,2),2).' บาท';
                                    
                                    $total_book_price_all += $total_book_price ;
                                    
                                $html .= '</td> 
                                <td class="close-td first-row"><a href="javascript:void(0)" class="delete"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->book_id.'" data-type="ebook" ><font color="red"><i class="far fa-times-circle fa-2x"></i></font></a></td> 
                            </tr>';
                            $sum_quantity_all += $tmp_cart->sum_quantity;
                            
                        }
                           
                    }
                    
                            
                            $transports_last = Transport::all()->last();

                            
                            $html_total_book_price_all = ''.number_format(round((float)$total_book_price_all,2),2) ;
                            
                            

                            $total_final = $total_book_price_all ;
                            
                            $html_total_final = ''.number_format(round((float)$total_final,2),2) ;
                            

             return response()->json(['success'=>'fetch data success.' , 'html'=> $html ,
             'total_final'=>$total_final,'html_total_final'=>$html_total_final ,
             'total_book_price_all' => $total_book_price_all ,'html_total_book_price_all'=> $html_total_book_price_all ,
             'sum_quantity_all' => $sum_quantity_all 
               ]);
             
        }
        

        //DD($count_can_discount);
        
        
        return view("front-end-ebook.cart" ,[
            'publishers' => $publishers ,
            'transports' => $transports ,
            //'tmp_carts' => $tmp_carts ,
            // 'discounts' => $discounts ,
            'payments' => $payments ,
            'sum_quantity_all' => $sum_quantity_all ,
            // 'count_can_discount' => $count_can_discount ,
            'total_book_price_all' => $total_book_price_all ,
            'total_final' => $total_final, 
        ]);
    }

    public function create()
    {
    
    }

    public function store(Request $request)
    {
        //DD();

        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        }

        if(request()->ajax()) {
            if(empty($request->type)){ // this books only
                if(!empty($request->fn)){
                

                
                    $product = Product::find($request->id_book);
                    //return response()->json(['success'=>'ลดเรียบร้อยค่ะ' , 'qua' => $product->id]);
                    if($request->fn === "qua_minus"){
                        if($request->qua <= 1){
                            return response()->json(['success'=>'ลดเรียบร้อยค่ะ' , 'qua' => 1]);
                        }else{
                            $qua = $request->qua - 1  ;   
                            return response()->json(['success'=>'ลดเรียบร้อยค่ะ' , 'qua' => $qua]);
                        }
                    }else if($request->fn === "qua_plus"){
                        $tmp= TmpCart::where('user_id',$user->id)
                        ->where('book_id',$request->id_book)
                        ->select('*')
                        ->selectRaw('SUM(quantity) AS sum_quantity')
                        ->groupBy('book_id')
                        ->first();
                        
                        if(!empty($tmp)){
                            //return response()->json(['success'=>'เจอแล้ว 1' , 'val'=> $tmp->sum_quantity]);         
                            if(($tmp->sum_quantity+$request->qua+1) > $product->stock_remain){
                                return response()->json(['error'=>'สินค้าหมด']);
                            }else{
                                $qua = $request->qua+1 ;
                                return response()->json(['success'=>'เพิ่มเรียบร้อยค่ะ' , 'qua' => $qua]);   
                            }              
                        }else{
                            if(($request->qua+1) > $product->stock_remain){
                                return response()->json(['error'=>'สินค้าหมด']);
                            }else{
                                $qua = $request->qua+1 ;
                                return response()->json(['success'=>'เพิ่มเรียบร้อยค่ะ' , 'qua' => $qua]);
                            } 
                        }
                        
                            
                    }
               }
               $product_stock = Product::find($request->product_id);
               $tmp_stock = TmpCart::where('tmp_cart.user_id' , $user->id)
                                   ->where('tmp_cart.book_id' , $request->product_id)
                                   ->selectRaw('SUM(tmp_cart.quantity) AS sum_quantity')->first();
                                   $sum_quantity_count = 0 ;
                                   if(empty($tmp_stock->sum_quantity)){
                                       //$tmp_stock->sum_quantity = 0 ;
                                       $sum_quantity_count = 0 ;
                                       //return response()->json(['error'=>'Over Stock' , 'val1'=> $tmp_stock->sum_quantity ]);                                
                                   }else{
                                       $sum_quantity_count = $tmp_stock->sum_quantity ;
                                   }
                                   $qua = 0;
                                   
                                   if(!empty($request->qua)){
                                        $qua = $request->qua; 
                                        $total_qua = $sum_quantity_count + $qua ;
                                        if( $total_qua > $product_stock->stock_remain ){
                                           return response()->json(['error'=>'สินค้าหมด' ]);
                                       }
                                   }else{
                                        $qua_check =  1 + $sum_quantity_count ;
                                        $qua = 1 ;
                                       if( $qua_check > $product_stock->stock_remain ){
                                           return response()->json(['error'=>'สินค้าหมด' ]);
                                       }
                                   }
                                   $type = 'false';
            }else{ // this e-books only
                $qua = 1 ;
                $type = 'true';
            }
                               
   
           $tmp_cart = TmpCart::create([
               'blame_product' => $request->blame_product ?? 'n' ,
               'buffet' => $request->buffet ?? 'false'  ,
               'can_discount' => $request->can_discount ,
               'user_id' => $request->user_id ,
               'book_id' => $request->product_id  ,
               'username' => $request->username , 
               'quantity' => $qua , 
               'is_ebook' => $type , 
               
           ]);
           return response()->json(['success'=>'Item saved successfully.' , 'data' => $request->all() ]);

        }  
    }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $product = Product::find($id);
        $booktype = BookType::all();
        $publisher = Publisher::all();
        if (!$product){
            abort(404);
        }
        //DD($product->all());
        return view("products.edit-product" , [
           'booktypes' => $booktype ,
           'publishers' => $publisher,
           'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
