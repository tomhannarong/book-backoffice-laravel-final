<?php

namespace App\Http\Controllers;


use App\BestSellerEbook;
use App\BestSeller;
use App\BookType;
use App\Buffet;
use App\contactUs;
use App\Discount;
use App\FavorBook;
use App\OrderMas;
use App\OrderTran;
use App\Payment;
use App\Product;
use App\Publisher;
use App\TmpCart;
use App\Tranfer;
use App\Transport;
use App\User;
use App\WaitFiction;
use App\Privacy;
use App\ApproveEbook;
use App\OrderMasEbook;
use App\OrderTranEbook;
use App\ProductEbook;
use App\TranferEbook;
use App\Daily;
use App\News;
use App\BoardPost;
use App\BoardReply;
use App\ProductLink;
use App\ProductGalleryPhoto;


use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    // init
    // php artisan storage:link
    // composer require intervention/image
    // composer require yajra/laravel-datatables-oracle
    // composer require mews/captcha

    // max_allowed_packet=500M
    // max_execution_time = 1200

    //change bank in ebook_payment
    // SELECT COUNT(t2.payment) ,t2.payment , t2.payment_id FROM ebook_order_payment t1 , ebook_payment t2 WHERE t1.payment_id = t2.payment_id GROUP BY t2.payment
    //UPDATE ebook_order_payment SET payment_id = "Apple ID" WHERE payment_id ="15"

    public function index(){
            // $this->data_ebook_bestseller();
        // $this->data_best_seller();
        // $this->data_book_type();
        // $this->data_buffet();
        // $this->data_discount();
        // $this->data_order_mas();
        // $this->data_order_tran();
        // $this->data_payment();
        // $this->data_product();
        // $this->data_publisher();
        // $this->data_tmp_cart();
        // $this->data_tranfer();
        // $this->data_transport();
        // $this->data_mem();
        // $this->data_wait_fiction();
        // $this->data_privacy();
        
        // $this->data_ebook_approve_ebook();
        // $this->data_ebook_order_mas();
        // $this->data_ebook_order_tran();
        // $this->data_ebook_order_payment();
        // $this->data_ebook_product(); //วิธีใช้ เอาไฟล์รูปและไฟล์ pdf อันเก่า ไปใส่ไว้ใน storage
        // $this->data_move_photo_product();
        // $this->data_daily();
        // $this->data_web_news();
        // $this->data_board_post();
        // $this->data_board_reply();
        
        
        
    }
    public function data_ebook_bestseller(){
        $obj = DB::connection('mysql2')
        ->table("ebook_bestseller as t1")
        ->select('t1.best_id as id','t1.product_id','t1.seq','t1.post_date','t1.ip','t1.pv','t1.sale_qty','t1.device','t1.best_type')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = BestSellerEbook::insert($t);
            }
        }else{
            $status = BestSellerEbook::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_best_seller(){
        $obj = DB::connection('mysql2')
        ->table("best_seller as t1")
        ->leftJoin('product as t2', 't1.book_name', '=', 't2.book_name')
        ->select('t1.top_id as id','t1.top','t1.book_name','t1.alias','t1.price','t1.pim_time','t1.isbn','t1.writer','t1.pages',
        't1.book_description','t1.picture','t1.pim_year','t1.publisher_id','t1.book_type_id','t1.attachment','t2.book_id')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);

        $array_final = array();

        foreach (array_chunk($array,100) as $t){
            
            foreach($t as $detail) {
            
                array_push($array_final, [
                    'id' => $detail['id'] , 
                    'top' => $detail['top'] ,
                    'book_name' => $detail['book_name'] ,
                    'alias' => $detail['alias'] ,
                    'price' => $detail['price'] ,
                    'pim_time' => $detail['pim_time'] ,
                    'isbn' => $detail['isbn'] ,
                    'writer' => $detail['writer'] ,
                    'pages' => $detail['pages'] ,
                    'book_description' => $detail['book_description'] ,
                    'picture' => str_replace("files/", "",$detail['picture']) ,
                    'pim_year' => $detail['pim_year'] ,
                    'publisher_id' => $detail['publisher_id'] ,
                    'book_type_id' => $detail['book_type_id'] ,
                    'attachment' => str_replace("attachment/", "",$detail['attachment']) ,
                    'book_id' => $detail['book_id'] ,
                ]); 

            }
        }

        $status = true;
        if(count($array_final)>1000){
            foreach (array_chunk($array_final,1000) as $t)  
            {
                $status = BestSeller::insert($t);
            }
        }else{
            $status = BestSeller::insert($array_final);
        }
        if($status){
            return "DONE";
        }else{
            return "NO WAY";
        }
    }
    public function data_book_type(){
        $obj = DB::connection('mysql2')
        ->table("book_type as t1")
        ->select('t1.book_type_id as id','t1.book_type')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = BookType::insert($t);
            }
        }else{
            $status = BookType::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_buffet(){
        $obj = DB::connection('mysql2')
        ->table("buffet as t1")
        ->select('t1.book_number','t1.total_price','t1.book_price')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Buffet::insert($t);
            }
        }else{
            $status = Buffet::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_discount(){
        $obj = DB::connection('mysql2')
        ->table("discount as t1")
        ->select('t1.discount_id as id','t1.quantity_min','t1.quantity_max','t1.discount')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Discount::insert($t);
            }
        }else{
            $status = Discount::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    
    public function data_order_mas(){
        $obj = DB::connection('mysql2')
        ->table("order_mas as t1")
        ->leftJoin('mem as t2', 't1.username', '=', 't2.username')
        ->select('t1.order_id as id','t1.order_date','t1.order_time','t1.username','payment','transport','transport_rate','net_price',
        'order_status','show_status','tranfer_address','tracking_number','confirmation','date_paid','fullname','address_subdistric',
        'address_distric','address_province','address_zipcode',
        't2.mem_id as user_id')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);   
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = OrderMas::insert($t);
            }
        }else{
            $status = OrderMas::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_order_tran(){
        $obj = DB::connection('mysql2')
        ->table("order_tran as t1")
        ->select('t1.order_id','t1.book_id','t1.quantity as quantitys','t1.price','t1.percent_discount','t1.discount','t1.net')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = OrderTran::insert($t);
            }
        }else{
            $status = OrderTran::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_payment(){
        $obj = DB::connection('mysql2')
        ->table("payment as t1")
        ->select('t1.payment_id as id','t1.payment','t1.payment_description')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Payment::insert($t);
            }
        }else{
            $status = Payment::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_product(){
        $obj = DB::connection('mysql2')
        ->table("product as t1")
        ->select('t1.book_id as id','t1.book_name','t1.book_type_id','t1.writer','t1.alias','t1.price','t1.pages'
        ,'t1.book_description',
        't1.picture','t1.attachment','t1.stock','t1.on_market','t1.ISBN','t1.pim_time','t1.pim_year','t1.publisher_id','t1.tag_description','t1.tag_keyword',
        't1.blame_product','t1.serie_product','t1.blame_position','t1.blame_images','t1.show_blame','t1.blog_url','t1.youtube_url','t1.buffet','t1.stock_total',
        't1.stock_hold','t1.stock_remain','t1.stock_sold','t1.public_show','t1.can_discount','t1.book_weight')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);

        $array_final = array();

        foreach (array_chunk($array,100) as $t){
            
            foreach($t as $detail) {

                $product_link = ProductLink::create(['product_name' => $detail['book_name']]);
            
                array_push($array_final, [
                    'id' => $detail['id'] , 
                    'book_name' => $detail['book_name'] ,
                    'book_type_id' => $detail['book_type_id'] ,
                    'writer' => $detail['writer'] ,
                    'alias' => $detail['alias'] ,
                    'price' => $detail['price'] ,
                    'pages' => $detail['pages'] ,
                    'book_description' => $detail['book_description'] ,
                    'picture' => str_replace("files/", "",$detail['picture']) ,
                    'attachment' => str_replace("attachment/", "",$detail['attachment']) ,
                    'stock' => $detail['stock'] ,
                    'on_market' => $detail['on_market'] ,
                    'ISBN' => $detail['ISBN'] ,
                    'pim_time' => $detail['pim_time'] ,
                    'pim_year' => $detail['pim_year'] ,
                    'publisher_id' => $detail['publisher_id'] ,
                    'tag_description' => $detail['tag_description'] ,
                    'tag_keyword' => $detail['tag_keyword'] ,
                    'blame_product' => $detail['blame_product'] ,
                    'serie_product' => $detail['serie_product'] ,
                    'blame_position' => $detail['blame_position'] ,
                    'blame_images' => str_replace("files/blame_img/", "",$detail['blame_images']) ,
                    'show_blame' => $detail['show_blame'] ,
                    'blog_url' => $detail['blog_url'] ,
                    'youtube_url' => $detail['youtube_url'] ,
                    'buffet' => $detail['buffet'] ,
                    'stock_total' => $detail['stock_total'] ,
                    'stock_hold' => $detail['stock_hold'] ,
                    'stock_remain' => $detail['stock_remain'] ,
                    'stock_sold' => $detail['stock_sold'] ,
                    'public_show' => $detail['public_show'] ,
                    'can_discount' => $detail['can_discount'] ,
                    'book_weight' => $detail['book_weight'] ,
                    'product_price' => $detail['price'] ,
                    'is_ebook' => 'false',
                    'promote_link' =>  $product_link->id,
                    
                ]); 

            }
        }

        $status = true;
        if(count($array_final)>1000){
            foreach (array_chunk($array_final,1000) as $t)  
            {
                $status = Product::insert($t);
            }
        }else{
            $status = Product::insert($array_final);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_publisher(){
        $obj = DB::connection('mysql2')
        ->table("publisher as t1")
        ->select('t1.publisher_id as id','t1.publisher')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Publisher::insert($t);
            }
        }else{
            $status = Publisher::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_tmp_cart(){
        $obj = DB::connection('mysql2')
        ->table("tmp_cart as t1")
        ->leftJoin('mem as t2', 't1.username', '=', 't2.username')
        ->select('t1.book_id','t1.username','t1.quantity','t1.blame_product','t1.buffet','t1.can_discount',
        't2.mem_id as user_id')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = TmpCart::insert($t);
            }
        }else{
            $status = TmpCart::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_tranfer(){
        $obj = DB::connection('mysql2')
        ->table("tranfer as t1")
        ->select('t1.tranfer_id as id','t1.tranfer_date','t1.tranfer_time','t1.inform_date','t1.attach_slip','t1.amount'
        ,'t1.account_tranfer','t1.bank_tranfer','t1.username')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));

        $array_final = array();

        foreach (array_chunk($array,100) as $t){
            
            foreach($t as $detail) {
            
                array_push($array_final, [
                    'id' => $detail['id'] , 
                    'tranfer_date' => $detail['tranfer_date'] ,
                    'tranfer_time' => $detail['tranfer_time'] ,
                    'inform_date' => $detail['inform_date'] ,
                    'attach_slip' => str_replace("slip/", "",$detail['attach_slip']) ,
                    'amount' => $detail['amount'] ,
                    'account_tranfer' => $detail['account_tranfer'] ,
                    'bank_tranfer' => $detail['bank_tranfer'] ,
                    'username' => $detail['username'] ,
                    'show_status' => "n" ,
                ]); 

            }
        }

        $status = true;
        if(count($array_final)>1000){
            foreach (array_chunk($array_final,1000) as $t)  
            {
                $status = Tranfer::insert($t);
            }
        }else{
            $status = Tranfer::insert($array_final);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_transport(){
        $obj = DB::connection('mysql2')
        ->table("transport as t1")
        ->select('t1.transport_id as id','t1.transport','t1.transport_rate','t1.transport_description')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Transport::insert($t);
            }
        }else{
            $status = Transport::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_mem(){
        $obj = DB::connection('mysql2')
        ->table("mem as t1")
        ->select('*')
        // ->where('t1.class_user',1)
        // ->limit(10)
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD($array);
        $array_final = array();

        foreach (array_chunk($array,100) as $t){
            
            foreach($t as $detail) {
            
                if($detail['class_user'] == 1){
                    $user_class = 'admin';
                }else if($detail['class_user'] == 2){
                    $user_class = 'pub';
                }else{
                    $user_class = 'user';
                }
                array_push($array_final, [
                    'id' => $detail['mem_id'] , 
                    'username' => $detail['username'] ,
                    'password' => Hash::make($detail['password']) ,
                    'name' => $detail['name'] ,
                    'surname' => $detail['surname'] ,
                    'address' => $detail['address'] ,
                    'department' => $detail['department'] ,
                    'road' => $detail['road'] ,
                    'village' => $detail['village'] ,
                    'address_full' => $detail['address_full'] ,
                    'subdistric' => $detail['subdistric'] ,
                    'distric' => $detail['distric'] ,
                    'province' => $detail['province'] ,
                    'zipcode' => $detail['zipcode'] ,
                    'avatar' => str_replace("avatar/", "",$detail['avatar']) ,
                    'ban_status' => $detail['ban'] ,
                    'email' => $detail['email'] ,
                    'tel' => $detail['mobile'] ,
                    'class_user' => $user_class ,
                    'soi' => $detail['soi'] ,
                    'moo' => $detail['moo'] ,
                    'alias' => $detail['alias'] ,
                    'sid' => $detail['id_card'] ,
                    'condo' => $detail['condo'] ,
                    'welcome_message' => $detail['welcome_message'] ,
                    'counter' => $detail['counter'] ,
                    'bg_color' => $detail['bg_color'] ,
                    'bg_img' => $detail['bg_img'] ,
                    'bg_repeat' => $detail['bg_repeat'] ,
                    'bg_attachment' => $detail['bg_attachment'] ,
                    'bg_hposition' => $detail['bg_hposition'] ,
                    'bg_vposition' => $detail['bg_vposition'] ,
                    'zipcode' => $detail['zipcode'] ,
                ]); 

            }
        }
        // DD("YES");

        

        $status = true;
        if(count($array_final)>1000){
            foreach (array_chunk($array_final,1000) as $t)  
            {
                $status = User::insert($t);
            }
        }else{
            $status = User::insert($array_final);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    
    public function data_wait_fiction(){
        $obj = DB::connection('mysql2')
        ->table("wait_fiction as t1")
        ->select('t1.wait_id as id','t1.book_name','t1.alias','t1.price','t1.pim_time','t1.isbn','t1.writer','t1.pages','t1.book_description',
        't1.picture','t1.pim_year','t1.publisher_id','t1.book_type_id')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));

        $array_final = array();

        foreach (array_chunk($array,100) as $t){
            
            foreach($t as $detail) {
            
                array_push($array_final, [
                    'id' => $detail['id'] , 
                    'book_name' => $detail['book_name'] ,
                    'alias' => $detail['alias'] ,
                    'price' => $detail['price'] ,
                    'pim_time' => $detail['pim_time'] ,
                    'isbn' => $detail['isbn'] ,
                    'writer' => $detail['writer'] ,
                    'pages' => $detail['pages'] ,
                    'book_description' => $detail['book_description'] ,
                    'picture' => str_replace("files/", "",$detail['picture']) ,
                    'pim_year' => $detail['pim_year'] ,
                    'publisher_id' => $detail['publisher_id'] ,
                    'book_type_id' => $detail['book_type_id'] ,
                ]); 

            }
        }

        $status = true;
        if(count($array_final)>1000){
            foreach (array_chunk($array_final,1000) as $t)  
            {
                $status = WaitFiction::insert($t);
            }
        }else{
            $status = WaitFiction::insert($array_final);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    
    public function data_privacy(){
        $obj = DB::connection('mysql2')
        ->table("ebook_news as t1")
        ->select('t1.news_id as id','t1.news_title','t1.news_detail','t1.add_date as created_at','t1.approve_status')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Privacy::insert($t);
            }
        }else{
            $status = Privacy::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }

    public function data_ebook_approve_ebook(){
        $obj = DB::connection('mysql2')
        ->table("ebook_approve_ebook as t1")
        ->select('t1.approve_id as id','t1.username','t1.product_id','t1.order_id','t1.tran_id','t1.approve_status','t1.approve_date')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = ApproveEbook::insert($t);
            }
        }else{
            $status = ApproveEbook::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_ebook_order_mas(){
        $obj = DB::connection('mysql2')
        ->table("ebook_order_mas as t1")
        ->select('t1.order_id as id','t1.share_id','t1.order_date','t1.order_time','t1.username','t1.device','t1.total_order','t1.payment_id'
        ,'t1.order_status','t1.username_receipt','t1.approve_status','t1.approve_date','t1.approve_time','t1.paid_date','t1.paid_time','t1.pay_method')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = OrderMasEbook::insert($t);
            }
        }else{
            $status = OrderMasEbook::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_ebook_order_tran(){
        $obj = DB::connection('mysql2')
        ->table("ebook_order_tran as t1")
        ->select('t1.tran_id as id','t1.order_id','t1.share_id','t1.product_id','t1.username','t1.device','t1.udid1','t1.udid2','t1.udid3'
        ,'t1.product_price','t1.product_qty','t1.total_price','t1.username_owner','t1.share_percent','t1.order_status','t1.order_date',
        't1.approve_date','t1.paid_date','t1.paid_time')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = OrderTranEbook::insert($t);
            }
        }else{
            $status = OrderTranEbook::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_ebook_order_payment(){
        $obj = DB::connection('mysql2')
        ->table("ebook_order_payment as t1")
        ->leftJoin("ebook_payment as t2" ,"t2.payment_id" , "t1.payment_id" )
        ->select('t1.order_payment_id as id','t1.order_id','t1.payment_id','t1.username_customer','t1.username_receipt','t1.total_order',
        't1.bank_datetime','t1.payment_method','t1.remark1'
        ,'t1.file1','t1.order_status','t1.approve_date','t1.post_date' , 't2.payment as bank' , DB::raw("'false' as public_show"))
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD(count($array));
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = TranferEbook::insert($t);
            }
        }else{
            $status = TranferEbook::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_ebook_product(){
        $obj = DB::connection('mysql2')
        ->table("ebook_product as t1")
        ->select('t1.product_id as id','t1.product_name','t1.cat_id','t1.product_image','t1.product_thumb_image','t1.promote_link',
        't1.product_description','t1.product_pdf','t1.product_pdf2'
        ,'t1.add_date','t1.last_modified','t1.alias_price','t1.product_price','t1.affiliate_price','t1.sale_qty','t1.username'
        ,'t1.publish1','t1.best_seller','t1.recommended','t1.hot_item','t1.user_book','t1.alias1'
        ,'t1.publishing1','t1.serie_set','t1.preview','t1.enable','t1.ISBN')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        // DD($array);

        $array_final = array();
            
        foreach (array_chunk($array,100) as $t){
            $i = 0 ; 
            foreach($t as $detail) {
                $id_product = NULL;
                $product_link = NULL ;
                if(strpos($detail['promote_link'], '?bid=') !== false) {

                    
                    $id_product = explode("=",$detail['promote_link'])[1];
                    $product_temp = Product::find($id_product); //product book 
                    if(!empty($product_temp)){
                        
                        if(strpos($product_temp->book_name, " ") !== false) {
                            $arr = explode(" ",$product_temp->book_name);
                            if($arr[0] == "ซีรีส์ชุด"){
                                $product2 = Product::where('book_name','LIKE', '%'.$arr[1].'%')->get();
                                if(!empty($product2->toArray())){
                                    // DD($product2);
                                    // Product::where('book_name','LIKE', '%'.$arr[1].'%')->update(['promote_link' => $product2[0]->promote_link]) ;
                                    // $product_link = $product_temp->promote_link ;
                                    $product_link = $product2[0]->promote_link ;
                                }
                                
                            }else{
                                $product2 = Product::where('book_name','LIKE', '%'.$arr[0].'%')->get();
                                if(!empty($product2->toArray())){
                                    // DD($product2);
                                    // Product::where('book_name','LIKE', '%'.$arr[0].'%')->update(['promote_link' => $product2[0]->promote_link]) ;
                                    // $product_link = $product_temp->promote_link ;
                                    $product_link = $product2[0]->promote_link ;
                                }
                            }
                        }else{
                            $product2 = Product::where('book_name','LIKE', '%'.$product_temp->book_name.'%')->get();
                            // DD($product2->toArray());
                            if(!empty($product2->toArray())){
                                
                                // if($product2[0]->promote_link == '2'){
                                //     DD($product2[0]->promote_link);
                                // }
                                

                                // Product::where('book_name','LIKE', '%'.$product_temp->book_name.'%')->update(['promote_link' => $product2[0]->promote_link]) ;
                                // $product_link = $product_temp->promote_link ;
                                $product_link = $product2[0]->promote_link ;
                            }
                        }
                        
                        
                        
                        // $i += 1; 
                    // $product_temp->update(['promote_link'=> $id_product]);
                    }


                }

                // $path_dir = 'public/'.$detail['product_image']; //path old image in stroage
                // if(Storage::exists($path_dir)){
                //     $path_dir_new = 'public/book-images';
                //     if(!Storage::exists($path_dir_new)){
                //         Storage::makeDirectory($path_dir_new);
                //     }
                //         Storage::copy('public/'.$detail['product_image'], $path_dir_new.'/'.explode("/",$detail['product_image'])[4]);      
                // }

                // $path_dir = 'public/'.$detail['product_thumb_image']; //path old image in stroage
                // if(Storage::exists($path_dir)){
                //     $path_dir_new = 'public/book-images/thumbnail';
                //     if(!Storage::exists($path_dir_new)){
                //         Storage::makeDirectory($path_dir_new);
                //     }
                //         Storage::copy('public/'.$detail['product_thumb_image'], $path_dir_new.'/'.explode("/",$detail['product_thumb_image'])[4]);      
                // }

                // $path_dir = 'public/'.$detail['product_pdf']; //path old image in stroage
                // if(Storage::exists($path_dir)){
                //     $path_dir_new = 'public/file-ebooks';
                //     if(!Storage::exists($path_dir_new)){
                //         Storage::makeDirectory($path_dir_new);
                //     }
                //         Storage::copy('public/'.$detail['product_pdf'], $path_dir_new.'/'.explode("/",$detail['product_pdf'])[4]);      
                // }
                // $path_dir = 'public/'.$detail['product_pdf2']; //path old image in stroage
                // if(Storage::exists($path_dir)){
                //     $path_dir_new = 'public/file-preview';
                //     if(!Storage::exists($path_dir_new)){
                //         Storage::makeDirectory($path_dir_new);
                //     }
                //         Storage::copy('public/'.$detail['product_pdf2'], $path_dir_new.'/'.explode("/",$detail['product_pdf2'])[4]);      
                // }
             
            
                array_push($array_final, [
                    // 'id' => $detail['id'] , 
                    'book_name' => $detail['product_name'] ,
                    'book_type_id' => $detail['cat_id'] ,
                    'writer' => $detail['serie_set'] ,
                    'alias' => $detail['alias1'] ,
                    'price' => $detail['alias_price'] ,
                    'product_price' => $detail['product_price'] ,
                    'book_description' => $detail['product_description'] ,
                    'picture' => explode("/",$detail['product_image'])[4] ,
                    'attachment' => explode("/",$detail['product_pdf2'])[4] ,
                    'ISBN' => $detail['ISBN'] ,
                    'publisher_id' => $detail['publishing1'] ,
                    'stock_sold' => 0,
                    'public_show' => "true" ,
                    'can_discount' => "false" ,
                    'product_pdf' => explode("/",$detail['product_pdf'])[4] ,
                    'affiliate_price' => $detail['affiliate_price'] ,
                    'username' => $detail['username'] ,
                    'publish1' => $detail['publish1'] ,
                    'best_seller' => $detail['best_seller'] ,
                    'recommended' => $detail['recommended'] ,
                    'hot_item' => $detail['hot_item'] ,
                    'user_book' => $detail['user_book'] ,
                    'created_at' => $detail['add_date'] ,
                    'updated_at' => $detail['last_modified'] ,   
                    'is_ebook' => "true" ,   
                    'promote_link' => $product_link ,
                    

                ]); 

            }
            // DD($i);
        }

        // DD($array_final);
        $status = true;
        if(count($array_final)>1000){
            foreach (array_chunk($array_final,1000) as $t)  
            {
                $status = Product::insert($t);
            }
        }else{
            $status = Product::insert($array_final);
        }

        // $product_temp = Product::all(); //product book 
        //     if(!empty($product_temp)){
                
        //         if(strpos($product_temp->book_name, " ") !== false) {
        //             $arr = explode(" ",$product_temp->book_name);
        //             if($arr[0] == "ซีรีส์ชุด"){
        //                 $product2 = Product::where('book_name','LIKE', '%'.$arr[1].'%')->get();
        //                 if(!empty($product2->toArray())){
        //                     // DD($product2);
        //                     Product::where('book_name','LIKE', '%'.$arr[1].'%')->update(['promote_link' => $product2[0]->promote_link]) ;
        //                     // $product_link = $product_temp->promote_link ;
        //                     $product_link = $product2[0]->promote_link ;
        //                 }
                        
        //             }else{
        //                 $product2 = Product::where('book_name','LIKE', '%'.$arr[0].'%')->get();
        //                 if(!empty($product2->toArray())){
        //                     // DD($product2);
        //                     Product::where('book_name','LIKE', '%'.$arr[0].'%')->update(['promote_link' => $product2[0]->promote_link]) ;
        //                     // $product_link = $product_temp->promote_link ;
        //                     $product_link = $product2[0]->promote_link ;
        //                 }
        //             }
        //         }else{
        //             $product2 = Product::where('book_name','LIKE', '%'.$product_temp->book_name.'%')->get();
        //             // DD($product2->toArray());
        //             if(!empty($product2->toArray())){
                        
        //                 DD($product2[0]->promote_link);
        //                 Product::where('book_name','LIKE', '%'.$product_temp->book_name.'%')->update(['promote_link' => $product2[0]->promote_link]) ;
        //                 // $product_link = $product_temp->promote_link ;
        //                 $product_link = $product2[0]->promote_link ;
        //             }
        //         }
                
                
                
        //         // $i += 1; 
        //     // $product_temp->update(['promote_link'=> $id_product]);
        // }

        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    } 

    
    public function data_move_photo_product(){
        $product = Product::all();
        // DD($product);
        foreach($product as $val){
            $ProductGalleryPhoto = ProductGalleryPhoto::create(['product_id' => $val->id , 
            'photo' => $val->picture]);
        }
       

        if($ProductGalleryPhoto){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }

    public function data_daily(){
        $obj = DB::connection('mysql2')
        ->table("daily as t1")
        ->select('t1.DATE','t1.NUM')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = Daily::insert($t);
            }
        }else{
            $status = Daily::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_web_news(){
        $obj = DB::connection('mysql2')
        ->table("web_news as t1")
        ->select('news_id as id','t1.head_news','t1.news_detail','t1.username','t1.news_date')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = News::insert($t);
            }
        }else{
            $status = News::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_board_post(){
        $obj = DB::connection('mysql2')
        ->table("board_post as t1")
        ->select('t1.topic_id as id','t1.topic','t1.username','t1.post_date','t1.view','t1.post_description','t1.show_status','t1.pin','t1.lastupdate')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = BoardPost::insert($t);
            }
        }else{
            $status = BoardPost::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    public function data_board_reply(){
        $obj = DB::connection('mysql2')
        ->table("board_reply as t1")
        ->select('t1.reply_id  as id','t1.topic_id','t1.username','t1.reply_date','t1.ip_user','t1.reply')
        ->get()->toArray();
        $array = json_decode(json_encode($obj), true);
        $status = true;
        if(count($array)>1000){
            foreach (array_chunk($array,1000) as $t)  
            {
                $status = BoardReply::insert($t);
            }
        }else{
            $status = BoardReply::insert($array);
        }
        if($status){
            echo "DONE";
        }else{
            echo "NO WAY";
        }
    }
    
    
}
