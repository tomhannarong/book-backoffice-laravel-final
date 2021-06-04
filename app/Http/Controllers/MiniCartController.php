<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discount;
use App\TmpCart;
use App\Buffet;
use App\FavorBook;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class MiniCartController extends Controller
{
    public function index(){
        abort(404);
    }
    public function show_mini(Request $request){

        //$token = Token::where('token', '=', $request->input(token))->firstOrFail();

        if(request()->ajax()) {

            $user = null;
            $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $username = $user->username ;
            }else {

                $html =' <a href="';
            if($request->type === "ebook"){
                $html .=   url("ebook/productsEbook");
            }else{
                $html .=   url("products");
            }
            $html .='" class="select_icon_hover" >
                            <i style="color:red;" class="fas fa-shopping-cart"></i>
                            <span>0</span>
                        </a>';
                        
                return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
            }
            if(!empty($request->fn)){
                if($request->fn === "delete_mini"){
                    if($request->type === "ebook"){
                        TmpCart::where('book_id',$request->book_id)->where('username',$username)->where('is_ebook','true')->delete();
                    }else{
                        TmpCart::where('book_id',$request->book_id)->where('username',$username)->delete();
                    }
                }
           }
        
        $discount_percen=0;
        $total_discount=0;
        $total_book_price=0;
        $quantity_all =0;
        $sum_quantity_buffet_all = 0 ;
        $discounts = Discount::all();
        $buffets = Buffet::all();
        $html = '';
        //variable buffet
        $html_buffet_tfoot = '';
        $price_buffet = 0; 
        $book_buffet_check = '';
        $buffet_book_number = 0 ;
        $buffet_pro_count  = 0 ; 
        $sum_pridce_buf_final = 0;
        $sum_price_buffet_all = 0;
        $total_book_price_all = 0 ;
        // end variable buffet
    
        // if($request->type === "book"){
            $count_can_discount = DB::table('tmp_cart as t1')
            ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
            ->selectRaw('SUM(t1.quantity) AS count_can_discount')
            ->where('user_id' , $user->id)
            ->where('t2.can_discount' , 'true')
            ->where('t2.public_show' , 'true')
            ->where('t1.is_ebook','=', 'false')
            // ->distinct('t1.book_id')
            //->count('t1.id');
            ->first();

            $tmp_carts = DB::table('tmp_cart as t1')
            ->leftJoin('product as t2' , 't1.book_id' ,'t2.id' )
            ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart','t2.blame_images','t2.stock','t1.username') 
            ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            ->where('user_id' , $user->id)
            ->where('t2.public_show' , 'true')
            ->where('t2.buffet','<>', 'true')
            ->where('t1.is_ebook','=', 'false')
            ->groupBy('t1.book_id')
            ->orderBy('t2.book_name' , 'ASC')
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
            ->select('t1.book_id' ,'t2.book_name','t2.can_discount','t2.price','t2.blame_product','t2.buffet','t2.picture','t1.id as id_cart','t2.blame_images','t2.stock','t1.username') 
            ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            ->where('user_id' , $user->id)
            ->where('t2.public_show' , 'true')
            ->where('t2.buffet','=', 'true')
            ->where('t1.is_ebook','=', 'false')
            ->groupBy('t1.book_id')
            ->orderBy('t2.book_name' , 'ASC')
            ->get();

            if($tmp_carts->toArray()){
                foreach ($tmp_carts as $tmp_cart){
                    if($tmp_cart->sum_quantity > $tmp_cart->stock){
                        $sum = $tmp_cart->sum_quantity - $tmp_cart->stock ;
                        $sum_final = $tmp_cart->sum_quantity - $sum ;

                        TmpCart::where('book_id',$tmp_cart->book_id)->delete();
                        if($sum_final != 0){
                            TmpCart::create([
                                'book_id' => $tmp_cart->book_id ,
                                'username' => $tmp_cart->username ,
                                'quantity' => $sum_final ,
                                'blame_product' => $tmp_cart->blame_product ,
                                'buffet' => $tmp_cart->buffet ,
                                'can_discount' => $tmp_cart->can_discount ,
                                'user_id' => $user->id ,
                            ]);
                        }
                    }
                }

                foreach ($tmp_carts as $tmp_cart){
                    
                    if($tmp_cart->can_discount){   
                        if($tmp_cart->can_discount == "true"){                                      
                            foreach ($discounts as $discount){
                                if(($count_can_discount->count_can_discount >= $discount->quantity_min) && ($count_can_discount->count_can_discount <= $discount->quantity_max)){
                                    $discount_percen = $discount->discount ;
                                }
                            }
                            $total_discount +=  (($tmp_cart->price * $tmp_cart->sum_quantity) * $discount_percen / 100);
                        }                        
                    }
                    $quantity_all += $tmp_cart->sum_quantity;
                    $total_book_price += $tmp_cart->price * $tmp_cart->sum_quantity ;
                }
            }
            if($tmp_carts_ebooks->toArray()){
                foreach ($tmp_carts_ebooks as $tmp_cart){                     
                    $quantity_all += $tmp_cart->sum_quantity;
                    $total_book_price += $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
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
                        }                        
                    }
                    $quantity_all += $tmp_cart->sum_quantity;
                    //$total_book_price += $tmp_cart->price * $tmp_cart->sum_quantity ;

                    $sum_quantity_buffet_all += $tmp_cart->sum_quantity ;
                    $sum_price_buffet_all += $tmp_cart->price * $tmp_cart->sum_quantity ;
                }
                            
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
                                $html_buffet_tfoot .= '<span style="color: red;">[ ขาดอีก '.($buffet_book_number-$sum_quantity_buffet_all).' เล่ม ] <u style="color:DodgerBlue;">'.$buffet_book_number.' เล่ม '.number_format(round((float)$price_buffet,2),2).' บาท</u></span>';                                                            
                                $sum_pridce_buf_final = $sum_price_buffet_all;  
                                $total_book_price_all += $sum_price_buffet_all;  
                                $total_book_price += $sum_price_buffet_all;
                            }else if($book_buffet_check == 'no'){
                                //$html_buffet_tfoot .= '<span>ครบ '.$buffet_book_number.' เล่ม</span>';
                                $sum_pridce_buf_final = $price_buffet;  
                                $total_book_price_all += $price_buffet;  
                                $total_book_price += $price_buffet;
                            }
                            // $html .='<tr style="background-color: Wheat;border: 2px solid DarkGoldenRod">
                            //                 <th colspan="3">รวมรายการบุฟเฟ่ต์</th>
                            //                 <th><span>'.$sum_quantity_buffet_all.'</span> เล่ม '.$html_buffet_tfoot.'</th>
                            //                 <th colspan="4"><span class="">'.number_format(round((float)$sum_pridce_buf_final,2),2).'</span> บาท</th> 
                            //             </tr>';

            }

        // }
        // else if($request->type === "ebook"){
        
            // $tmp_carts_ebooks = DB::table('tmp_cart as t1')
            // ->leftJoin('ebook_product as t2' , 't1.book_id' ,'t2.id' )
            // ->select('t1.book_id' ,'t2.product_name','t2.alias_price','t2.product_price','t2.product_image','t1.id as id_cart','t1.username') 
            // ->selectRaw('SUM(t1.quantity) AS sum_quantity')
            // ->where('user_id' , $user->id)
            // ->where('t2.public_show' , 'true')
            // ->where('t1.is_ebook','=', 'true')
            // ->groupBy('t1.book_id')
            // ->orderBy('t2.product_name' , 'ASC')
            // ->get();

            

        //     $tmp_carts_ebooks = TmpCart::with(['getProduct' => function($query){
        //         $query->where('public_show', 'true');
        //         $query->orderBy('book_name','ASC');
        //     }])->select('*',DB::raw('sum(quantity) as sum_quantity'))
        //     ->where('is_ebook', 'true')
        //     ->where('user_id', $user->id)  
        //     ->groupBy('book_id')          
        //     ->get();

        //     if($tmp_carts_ebooks->toArray()){
        //         foreach ($tmp_carts_ebooks as $tmp_cart){                     
        //             $quantity_all += $tmp_cart->sum_quantity;
        //             $total_book_price += $tmp_cart->getProduct->product_price * $tmp_cart->sum_quantity ;
        //         }
        //     }

        // }
        
        
        $html .=' <a href="';
        if($request->type === "ebook"){
            $html .=   url("ebook/cart");
        }else{
            $html .=   url("cart");
        }
        $html .='" class="select_icon_hover" >
                        <i style="color:red;" class="fas fa-shopping-cart"></i>
                        <span>'.$quantity_all.'</span>
                    </a>
                    <div class="cart-hover" style="border: 5px solid WhiteSmoke; ">
                        <div class="select-items">
                            <table>
                                <tbody>';
        // if($request->type === "ebook"){                        
            if($tmp_carts_ebooks->toArray()){  // this e-books only
                                        $html .='<tr>
                                            <th colspan="3" class="text-center" style="background-color: Khaki;border: 2px solid DarkGoldenRod;">รายการ E-Books</th>                           
                                        </tr>';
                                        
                                foreach($tmp_carts_ebooks as $tmp_cart){
                                    
                                $html .='<tr>
                                            <td class="si-pic"> ';                                                       
                                                if(!empty($tmp_cart->getProduct->picture)){           
                                                    // $html .='<img style="background-color: HoneyDew; " width="70" height="90" src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" > ';                                                                                           
                                                    
                                                    //  pic_test 
                                                    $html .='<img style="background-color: HoneyDew; " width="70" height="90" src="'.asset("storage/book-images/".$tmp_cart->getProduct->picture).'"> ';                                                                                           
                                                    
                                                }else{
                                                    $html .='<img style="background-color: HoneyDew;" src="'.asset("img/no_pic.png").'" >';                                                                                                                      
                                                }
                    
                                    $html .='</td>
                                            <td class="si-text">
                                                <div class="product-selected">
                                                <p>'.$tmp_cart->getProduct->product_price .' x '.$tmp_cart->sum_quantity.'</p>';
                                                    
                                                $html .='<a href="'.url("ebook/productsEbook/detail/".$tmp_cart->getProduct->id).'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'.$tmp_cart->getProduct->book_name.'</h6></a>';
                                                        
                                    $html .='   </div>
                                            </td>
                                            <td class="si-close">
                                            <a href="javascript:void(0)" class="delete_mini"  data-id-cart="'.$tmp_cart->id.'" data-id-book="'.$tmp_cart->getProduct->id.'" data-type="ebook" ><font color="Maroon"><i class="far fa-times-circle fa-2x"></i></font></a>
                                            </td>
                                        </tr>';
                                }
            }
        // }
        // if($request->type === "book"){
            if($tmp_carts->toArray()){
                            $html .='<tr>
                                <th colspan="3" class="text-center" style="background-color: Khaki;border: 2px solid DarkGoldenRod;">รายการหนังสือปกติ</th>                           
                            </tr>';
                            
                    foreach($tmp_carts as $tmp_cart){
                        
                    $html .='<tr>
                                <td class="si-pic"> ';                                                       
                                    if($tmp_cart->picture){           
                                        // $html .='<img style="background-color: HoneyDew; " width="70" height="90" src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" > ';                                                                                           
                                        
                                        //  pic_test 
                                        $html .='<img style="background-color: HoneyDew; " width="70" height="90" src="'.asset("img/books_test.jpg").'"> ';                                                                                           
                                        
                                    }else{
                                        $html .='<img style="background-color: HoneyDew;" src="'.asset("img/no_pic.png").'" >';                                                                                                                      
                                    }

                        $html .='</td>
                                <td class="si-text">
                                    <div class="product-selected">
                                    <p>'.$tmp_cart->price.' x '.$tmp_cart->sum_quantity.'</p>';
                                        if($tmp_cart->blame_product == 'y'){
                                            $html .='<a href="'.url("products/blame/detail/".$tmp_cart->book_id).'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'.$tmp_cart->book_name.'</h6></a>';
                                                }else{
                                            $html .='<a href="'.url("products/detail/".$tmp_cart->book_id).'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'.$tmp_cart->book_name.'</h6></a>';
                                            
                                                }
                        $html .='   </div>
                                </td>
                                <td class="si-close">
                                <a href="javascript:void(0)" class="delete_mini"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" data-type="book"><font color="Maroon"><i class="far fa-times-circle fa-2x"></i></font></a>
                                </td>
                            </tr>';
                    }
            }
        
            if($tmp_carts_buffet->toArray()){
                        $html .='<tr>
                            <th class="text-center" colspan="3" style="background-color: Khaki;border: 2px solid DarkGoldenRod;">รายการบุฟเฟ่ต์</th>                           
                        </tr>';
                    foreach($tmp_carts_buffet as $tmp_cart){
                    $html .='<tr>
                                <td class="si-pic"> ';                                                       
                                    if($tmp_cart->picture){           
                                        // $html .='<img style="background-color: HoneyDew; " width="70" height="90" src="'.asset("storage/book-images/thumbnail/".$tmp_cart->picture).'" > ';                                                                                           
                                    
                                        //  pic_test 
                                        $html .='<img style="background-color: HoneyDew; " width="70" height="90" src="'.asset("img/books_test.jpg").'"> ';                                                                                           
                                        
                                    }else{
                                        $html .='<img style="background-color: HoneyDew;" src="'.asset("img/no_pic.png").'" >';                                                                                                                      
                                    }
                        $html .='</td>
                                <td class="si-text">
                                    <div class="product-selected">
                                    <p>'.$tmp_cart->price.' x '.$tmp_cart->sum_quantity.'</p>
                                        <h6>'.$tmp_cart->book_name.'</h6>
                                    </div>
                                </td>
                                <td class="si-close">
                                <a href="javascript:void(0)" class="delete_mini"  data-id-cart="'.$tmp_cart->id_cart.'" data-id-book="'.$tmp_cart->book_id.'" data-type="book" ><font color="Maroon"><i class="far fa-times-circle fa-2x"></i></font></a>
                                </td>
                            </tr>';
                    }
                    $html .='<tr>
                            <th class="text-center" colspan="3" style="background-color: PowderBlue;border: 2px solid DarkCyan;"><u><h6>รวมรายการบุฟเฟ่ต์</h6></u></th>                           
                        </tr>';
                    $html .='<tr>
                            <td class="text-center" colspan="3" >
                            <h5><span style="color: DarkGoldenRod;"></span></h5>
                            <h6>
                            <span style="color: green;">'.$sum_quantity_buffet_all.' เล่ม </span><span style="color: green;"> : '.number_format(round((float)$sum_pridce_buf_final,2),2).' บาท </span><br>'.$html_buffet_tfoot.'
                            </h6>
                            </td>                           
                        </tr>';
                        // $html .='<tr style="background-color: Wheat;border: 2px solid DarkGoldenRod">
                        //                         <th colspan="3">รวมรายการบุฟเฟ่ต์</th>
                        //                         <th><span>'.$sum_quantity_buffet_all.'</span> เล่ม '.$html_buffet_tfoot.'</th>
                        //                         <th colspan="4"><span class="">'.number_format(round((float)$sum_pridce_buf_final,2),2).'</span> บาท</th> 
                        //                     </tr>';
            }
        // }

                        $html .='</tbody>
                                </table>
                            </div>                            
                            <div class="select-total">
                                <span>รวม:</span>
                                <h5 >'.number_format(round((float)$total_book_price,2),2).' บาท</h5>
                            </div>
                            <div class="select-total">
                                <span>ส่วนลด: ['.$discount_percen.'%] </span>
                                <h5 >'.number_format(round((float)$total_discount,2),2).' บาท</h5>
                            </div>
                            <div class="select-total">                                   
                                <span>รวมทั้งหมด:</span>
                                <h5 >'.number_format(round((float)($total_book_price-$total_discount),2),2).' บาท</h5>
                            </div>
                            <div class="select-button">';
                            $html .=' <a href="';
                                if($request->type === "ebook"){
                                    $html .=   url("ebook/cart");
                                }else{
                                    $html .=   url("cart");
                                }
                                $html .='" class="primary-btn view-card hvr-grow">VIEW CARD</a>';
                            $html .=' <a href="';
                                if($request->type === "ebook"){
                                    $html .=   url("ebook/cart/checkOut");
                                }else{
                                    $html .=   url("cart/checkOut");
                                }
                                $html .='" class="primary-btn checkout-btn hvr-grow">CHECK OUT</a>
                            </div>
                        </div>';

            

       
            
           return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
        }

         
        
        //return(['html' => $html]);
    }

    public function show_mini_heart(Request $request){

        //$token = Token::where('token', '=', $request->input(token))->firstOrFail();

        if(request()->ajax()) {

            $html ='';
            $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            }else {
                
                $html .=' <a href="';
            if($request->type === "ebook"){
                $html .=   url("ebook/favorBook");
            }else{
                $html .=   url("favorBook");
            }
            $html .='" class="select_icon_hover" >
                            <i style="color:red" class="far fa-heart" ></i>
                            <span>0</span>
                            
                        </a>';
                return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
            }
            if(!empty($request->fn)){
                $type_val ='';
                if($request->type === "ebook"){
                    $type_val = "true";
                }else{
                    $type_val = "false";
                }
                if($request->fn === "delete_mini_heart"){
                    FavorBook::where('book_id',$request->book_id)->where('user_id' , $user->id)->where('is_ebook' , $type_val)->delete();
                    //return response()->json(['success'=>'fetch data success.' , '123123'=> $request->book_id]);
                }
                if($request->fn === "add_mini_heart"){
                    FavorBook::create([
                        'book_id' => $request->book_id , 
                        'user_id' => $user->id ,
                        'is_ebook' =>  $type_val
                    ]);
                    //return response()->json(['success'=>'fetch data success.' , '123123'=> $request->book_id]);
                }
                if($request->fn === "show"){
                
                }
           }
    
            // if($request->type === "ebook"){
            //     $favor_books = FavorBook::leftJoin('ebook_product as t2' , 'favor_book.book_id' ,'t2.id' )
            //     ->leftJoin('users as t3' , 'favor_book.user_id' ,'t3.id' )
            //     ->select( 'favor_book.id as favor_book_id','favor_book.book_id','t2.product_name as book_name','favor_book.is_ebook')
            //     ->where('user_id' , $user->id)
            //     ->where('is_ebook' , $type_val)
            //     ->get(); 
            // }else{
                
            // }
            $favor_books = FavorBook::leftJoin('product as t2' , 'favor_book.book_id' ,'t2.id' )
                ->leftJoin('users as t3' , 'favor_book.user_id' ,'t3.id' )
                ->select( 'favor_book.id as favor_book_id','favor_book.book_id','t2.book_name' ,'t2.blame_product','favor_book.is_ebook')
                ->where('user_id' , $user->id)

                ->get(); 
                                // DD($favor_books->all());
        $favor_books_count = $favor_books->count();

        //return response()->json(['success'=>'fetch data success.' , 'favor_books'=> $favor_books->all()]);
        if($favor_books->toArray()){
            $html .=' <a href="';
            if($request->type === "ebook"){
                $html .=   url("ebook/favorBook");
            }else{
                $html .=   url("favorBook");
            }
            $html .='" class="select_icon_hover" >
                        <i style="color:red" class="far fa-heart" ></i>
                        <span>'.$favor_books_count.'</span>
                    </a>
                    <div class="heart-hover" style="border: 5px solid WhiteSmoke; ">
                                        <div class="select-items">
                                            <table>
                                            <tbody>
                                                <tr>
                                                    <th colspan="3" class="text-center" style="background-color: Khaki;border: 2px solid DarkGoldenRod;">หนังสือโปรด</th>                           
                                                </tr>';

                                            foreach($favor_books as $favor_book){     
                                    $html .='   <tr style="background-color: white;border: 2px solid DarkGoldenRod;">
                                                    <td colspan="2" class="si-text">
                                                        <div class="product-selected">';
                                                    if($favor_book->is_ebook === "false"){ // this book 
                                                        if($favor_book->blame_product == 'y'){
                                                            $html .='<a href="'.url("products/blame/detail/".$favor_book->book_id).'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'.$favor_book->book_name.'</h6></a>';
                                                                }else{
                                                            $html .='<a href="'.url("products/detail/".$favor_book->book_id).'" class="select_hover" style="text-shadow: 0 0 0.2em DeepSkyBlue"><h6>'.$favor_book->book_name.'</h6></a>';                                                            
                                                        }
                                                    }else{ // this e-book
                                                        $html .='<a href="'.url("ebook/productsEbook/detail/".$favor_book->book_id).'" class="" style=""><h6>'.$favor_book->book_name.'</h6></a>';
                                                            
                                                    }
                                                        
                                               $html .='</div>
                                                    </td>
                                                    <td class="si-close text-center">
                                                    <a href="javascript:void(0)" class="delete_mini_heart "  data-id-favor="'.$favor_book->favor_book_id.'" data-id-book="'.$favor_book->book_id.'" data-type="'.$request->type.'" ><font color="Maroon"><i class="far fa-times-circle fa-1x"></i></font></a>
                                                    </td>
                                                </tr>';
                                            }
                                                
                                $html .='</table>
                                        </div>                            
                                        <div class="select-button">';
                                        if($favor_book->is_ebook === "false"){ // this book 
                                            $html .='     <a href="'.url("favorBook").'" class="primary-btn checkout-btn hvr-grow"><font size="4px">ดูทั้งหมด</font></a>';
                                        }else{ // this e-book 
                                            $html .='     <a href="'.url("ebook/favorBook").'" class="primary-btn checkout-btn hvr-grow"><font size="4px">ดูทั้งหมด</font></a>';
                                        }
                                        
                                
                            $html .='   </div>
                        </div>';
           return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
        }else{
            $html .=' <a href="';
            if($request->type === "ebook"){
                $html .=   url("ebook/favorBook");
            }else{
                $html .=   url("favorBook");
            }
            $html .='" class="select_icon_hover" >
                        <i style="color:red" class="far fa-heart" ></i>
                        <span>0</span>
                    </a>';
            return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
       }
        
        }

         
        
        //return(['html' => $html]);
    }

}
