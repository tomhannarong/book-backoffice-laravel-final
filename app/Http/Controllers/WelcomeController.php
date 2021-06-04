<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BookType;
use App\Publisher;
use App\Product;
use App\BestSeller;
use App\WaitFiction;
use App\Discount;
use App\Slide;
use App\Privacy;
use App\BestSellerEbook;
use App\Daily;
use App\News;
use App\BoardPost;
use App\BoardReply;
use App\BestSellerAuto;
use App\ProductRate;
use App\OrderHistory;
use App\ProductGalleryPhoto;

use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MiniCartController;
use Illuminate\Database\Eloquent\Builder;
class WelcomeController extends Controller
{
    public function index()
    {   
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
        }else{
            $user_id = '' ;
            $user = null;
        }

         $mini_cart = 0; 
         if(request()->ajax()) {
             $html = MiniCartController::mini_cart($user)['html'];
            return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
        }
         //DD(MiniCartController::mini_cart($user));
        $AgoDate = \Carbon\Carbon::now()->subWeek()->format('Y-m-d');  // returns 2016-02-03
        $NowDate = \Carbon\Carbon::now()->format('Y-m-d');  // returns 2016-02-10
        $NowMonthDate = \Carbon\Carbon::now()->format('m');
        $NowYearDate = \Carbon\Carbon::now()->format('Y');


        // DD(\Carbon\Carbon::yesterday()->toDateString() );
        // $pro =  Product::find(2000);
        // DD($pro->product);
                                 
        $publishers = Publisher::all();
        $slides = Slide::where("is_active","y")->get();
        
        // $products_news = DB::table('product as t1')
        //     ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        //     // ->leftJoin('favor_book as t3', 't1.id', '=', 't3.book_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t1.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'false'"));
        //     })
        //     ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id' )
        //     ->where('t1.blame_product' ,'<>' , 'y')
        //     ->where('t1.buffet' ,'<>' , 'true')
        //     ->where('t1.public_show' ,'=' , 'true')
        //     // ->where('t3.user_id','=',)
        //     ->orderBy('t1.id','DESC')
        //     // ->limit(12)
        //     ->limit(8)
        //     ->get();

            $products_news = Product::with(['getPublisher','getPhoto','getFavorBook' => function($query) use ($user_id){
                $query->where('user_id', '=' ,$user_id);
                $query->where('is_ebook', '=', 'false');
            }])->where('blame_product' ,'<>' , 'y')
            ->where('buffet' ,'<>' , 'true')
            ->where('public_show' ,'=' , 'true')
            ->orderBy('id','DESC')
            ->limit(10)
            ->get();

            
           

        // $products_ebook_news = DB::table('ebook_product as t1')
        //     ->leftJoin('publisher as t2', 't1.publishing1', '=', 't2.id')
        //     // ->leftJoin('favor_book as t3', 't1.id', '=', 't3.book_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t1.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'true'"));
        //     })
        //     ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id' )
        //     ->where('t1.public_show' ,'=' , 'true')
        //     ->orderBy('t1.id','DESC')
        //     ->limit(6)
        //     ->get();
            // DD($products_ebook_news->all());

            
            // DD($products_news);
           //$products_new =  Product::where()->orderBy('created_at','DESC')->limit(10);
            //DD($products_news->all());
            // $best_sellers = DB::table('best_seller')
            // ->leftJoin('product', 'product.id', '=', 'best_seller.book_id')
            // ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            //     $join->on('product.id', '=', 't3.book_id');
            //     $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            //     $join->on('t3.is_ebook', '=', DB::raw("'false'"));
            // })
            // ->select('best_seller.*' , 'product.blame_product','product.buffet','product.can_discount','product.id as id_product' ,'product.stock','t3.book_id as favor_book_id')
            // ->where('product.public_show' , 'true')
            // ->orderBy('top','ASC')->limit(10)->get();

            $best_sellers = BestSeller::with(['getProduct' => function($query){
                $query->where('public_show' ,'=' , 'true');
            },'getFavorBook' => function($query) use ($user_id){
                $query->where('user_id', '=' ,$user_id);
                $query->where('is_ebook', '=', 'false');
            }])->orderBy('top','ASC')
            ->limit(10)
            ->get();

            // DD($best_sellers[0]->getProduct->id);
            

            $wait_fictions = WaitFiction::orderBy('created_at','DESC')->limit(10)->get();
            //DD($user->username);
            // DD($this->ebook_bestseller("day"));
        // DD($this->ebook_bestseller("week"));
        // DD($this->ebook_bestseller("month"));
        // DD($this->ebook_bestseller("year"));
           return view('front-end.index' , [
               'products_news' => $products_news , 
               'publishers' => $publishers ,
               'wait_fictions' => $wait_fictions ,
               'best_sellers' => $best_sellers ,
               'user' => $user ,
               'slides' => $slides ,
            //    'best_ebook_day' => $this->ebook_bestseller("day",10) ,
            //    'best_ebook_week' => $this->ebook_bestseller("week",10) ,
            //    'best_ebook_month' => $this->ebook_bestseller("month",10) ,
            //    'best_ebook_year' => $this->ebook_bestseller("year",10) ,
            //    'mini_cart' => MiniCartController::mini_cart($user) ,
           ]);
    }
    public function indexEbook($search='')
    {   
        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
                $username = '' ;
            }

         $mini_cart = 0; 
         if(request()->ajax()) {
             $html = MiniCartController::mini_cart($user)['html'];
            return response()->json(['success'=>'fetch data success.' , 'html'=> $html]);
        }
         //DD(MiniCartController::mini_cart($user));
        $AgoDate = \Carbon\Carbon::now()->subWeek()->format('Y-m-d');  // returns 2016-02-03
        $NowDate = \Carbon\Carbon::now()->format('Y-m-d');  // returns 2016-02-10
        $NowMonthDate = \Carbon\Carbon::now()->format('m');
        $NowYearDate = \Carbon\Carbon::now()->format('Y');

        $best_sellers = $this->ebook_bestseller("month",10);
        $text_dropdown = "E-Books ขายดีประจำเดือน";

        if($search === "ขายดีประจำวัน"){
            $best_sellers = $this->ebook_bestseller("day",10);
            $text_dropdown = "ขายดีประจำวัน";
            // $search = '';
        }else if($search === "ขายดีประจำสัปดาห์"){
            $best_sellers = $this->ebook_bestseller("week",10);
            $text_dropdown = "ขายดีประจำสัปดาห์";
            // $search = '';
        }else if($search === "ขายดีประจำเดือน"){
            $best_sellers = $this->ebook_bestseller("month",10);
            $text_dropdown = "ขายดีประจำเดือน";
            $search = '';
        }else if($search === "ขายดีประจำปี"){
            $best_sellers = $this->ebook_bestseller("year",10);
            $text_dropdown = "ขายดีประจำปี";
        }
        // DD($best_sellers);
           
        $publishers = Publisher::all();
        $slides = Slide::where("is_active","y")->get();

        // $products_ebook_news = DB::table('product as t1')
        //     ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        //     // ->leftJoin('favor_book as t3', 't1.id', '=', 't3.book_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t1.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'true'"));
        //     })
        //     ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
        //         $join->on('t1.id', '=', 't4.product_id');
        //         $join->on('t4.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
        //         $join->on('t1.id', '=', 't5.book_id');
        //         $join->on('t5.is_ebook', '=', DB::raw("'true'"));
        //         $join->on('t5.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id' )
        //     ->where('t1.public_show' ,'=' , 'true')
        //     ->orderBy('t1.id','DESC')
        //     ->limit(8)
        //     ->get();


            $products_ebook_news = Product::with(['getPublisher','getFavorBook' => function($query) use ($user_id){
                $query->where('user_id', $user_id);
                $query->where('is_ebook', 'true');
            },'getApproveReadEbook' => function($query) use ($username){
                $query->where('username', $username);
            },'getCartEbook' => function($query) use ($username){
                $query->where('username', $username);
                $query->where('is_ebook', 'true');
            }])->where('public_show' , 'true')
            ->orderBy('id','DESC')
            ->limit(8)
            ->get();

            
        //    $pro = Product::with('getApproveReadEbook')->find(1090);
        //    DD($products_ebook_news);

        // $products_ebook_news = DB::table('ebook_product as t1')
        //     ->leftJoin('publisher as t2', 't1.publishing1', '=', 't2.id')
        //     // ->leftJoin('favor_book as t3', 't1.id', '=', 't3.book_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t1.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'true'"));
        //     })
        //     ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
        //         $join->on('t1.id', '=', 't4.product_id');
        //         $join->on('t4.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
        //         $join->on('t1.id', '=', 't5.book_id');
        //         $join->on('t5.is_ebook', '=', DB::raw("'true'"));
        //         $join->on('t5.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id' )
        //     ->where('t1.public_show' ,'=' , 'true')
        //     ->orderBy('t1.id','DESC')
        //     ->limit(8)
        //     ->get();

            // DD($products_ebook_news->all());
          
           return view('front-end-ebook.index' , [
               'products_ebook_news' => $products_ebook_news , 
               'publishers' => $publishers ,
               'best_sellers' => $best_sellers ,
               'text_dropdown' =>$text_dropdown ,
               'user' => $user ,
               'slides' => $slides ,
               'search' =>  $search 
           ]);
    }
    public function showProductsAll()
    {
        $user = null;
        $user_id = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
            }else{
                //$user =''; 
                $user_id = '' ;
            }
        $publishers = Publisher::all();
        $products_all = DB::table('product as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            $join->on('t1.id', '=', 't3.book_id');
            $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            $join->on('t3.is_ebook', '=', DB::raw("'false'"));
        })
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id' )
        ->where('t1.blame_product' ,'<>' , 'y')
        ->where('t1.buffet' ,'<>' , 'true')
        ->where('t1.public_show' ,'=' , 'true')
        ->orderBy('t1.id','DESC')
        ->paginate(18);
        $count_alls = $products_all->count();

       return view('front-end.products' , [
           'products_alls' => $products_all , 
           'count_all' => $count_alls ,
           'product_type' => "product_normal" ,
           'head_text' => "นิยายมาใหม่" ,
           'publishers' => $publishers ,
           'user' => $user ,
           
       ]);
    }
    public function showProductsEbookAll($search='')
    {
        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
            }
        $book_types =  BookType::all();
        $publishers = Publisher::all();

        if($search === "ขายดีประจำวัน"){
            $products_all = $this->ebook_bestseller("day",20);
            $text_dropdown = "ขายดีประจำวัน";
            $search = '';
        }else if($search === "ขายดีประจำสัปดาห์"){
            $products_all = $this->ebook_bestseller("week",20);
            $text_dropdown = "ขายดีประจำสัปดาห์";
            $search = '';
        }else if($search === "ขายดีประจำเดือน"){
            $products_all = $this->ebook_bestseller("month",20);
            $text_dropdown = "ขายดีประจำเดือน";
            $search = '';
        }else if($search === "ขายดีประจำปี"){
            $products_all = $this->ebook_bestseller("year",20);
            $text_dropdown = "ขายดีประจำปี";
            $search = '';
        }else{
            
            $products_all = Product::with(['getPublisher','getFavorBook' => function($query) use ($user_id){
                $query->where('user_id', $user_id);
                $query->where('is_ebook', 'true');
            },'getApproveReadEbook' => function($query) use ($username){
                $query->where('username', $username);
            },'getCartEbook' => function($query) use ($username){
                $query->where('username', $username);
                $query->where('is_ebook', 'true');
            }])->where('public_show' , 'true');
            if($search){
                    $products_all->where('book_name' ,'LIKE' , '%'.$search.'%');
                }
            $products_all = $products_all->orderBy('id','DESC')
            ->paginate(18);
            // $products_all = DB::table('ebook_product as t1')
            // ->leftJoin('publisher as t2', 't1.publishing1', '=', 't2.id')
            // ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            //     $join->on('t1.id', '=', 't3.book_id');
            //     $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            //     $join->on('t3.is_ebook', '=', DB::raw("'true'"));
            // })
            // ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
            //     $join->on('t1.id', '=', 't4.product_id');
            //     $join->on('t4.username', '=', DB::raw("'".$username."'"));
            // })
            // ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
            //     $join->on('t1.id', '=', 't5.book_id');
            //     $join->on('t5.is_ebook', '=', DB::raw("'true'"));
            //     $join->on('t5.username', '=', DB::raw("'".$username."'"));
            // })
            
            // ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id','t1.product_image as picture','t4.id as ebook_approve_id','t5.id as tmp_cart_id' )
            // ->where('t1.public_show' ,'=' , 'true');
            // if($search){
            //     $products_all->where('t1.product_name' ,'LIKE' , '%'.$search.'%');
            // }
            // $products_all = $products_all->orderBy('t1.id','DESC')
            // ->paginate(18);

            $text_dropdown = "ขายดีทั้งหมด";
            // $search = '';
        }
        
        
            // $count_alls = $products_all->count();
            //  DD($this->ebook_bestseller("year","20")[0]->product_name);
            

       return view('front-end-ebook.productsEbook' , [
           'products_alls' => $products_all , 
        //    'count_all' => $count_alls ,
           'product_type' => "product_normal" ,
           'head_text' => "นิยาย E-Books มาใหม่" ,
           'publishers' => $publishers ,
           'user' => $user ,
           'book_types' => $book_types ,
           'i' => 0 ,
           'search' => $search ,
           'text_dropdown' => $text_dropdown ,
           
           
       ]);
    }
    public function showProductsEbookCatAll($cat='')
    {
        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
            }
        $book_types =  BookType::all();
        $publishers = Publisher::all();
        $products_all = DB::table('ebook_product as t1')
            ->leftJoin('publisher as t2', 't1.publishing1', '=', 't2.id')
            ->leftJoin('book_type as t4', 't1.cat_id', '=', 't4.id')
            // ->leftJoin('favor_book as t3', 't1.id', '=', 't3.book_id')
            ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
                $join->on('t1.id', '=', 't3.book_id');
                $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
                $join->on('t3.is_ebook', '=', DB::raw("'true'"));
            })
            ->leftJoin('ebook_approve_ebook as t5', function ($join)  use ($username) {
                $join->on('t1.id', '=', 't5.product_id');
                $join->on('t5.username', '=', DB::raw("'".$username."'"));
            })
            ->leftJoin('tmp_cart as t6', function ($join)  use ($username) {
                $join->on('t1.id', '=', 't6.book_id');
                $join->on('t6.is_ebook', '=', DB::raw("'true'"));
                $join->on('t6.username', '=', DB::raw("'".$username."'"));
            })
            ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id','t1.product_image as picture','t4.book_type','t5.id as ebook_approve_id','t6.id as tmp_cart_id' )
            ->where('t1.public_show' ,'=' , 'true')
            ->where('t4.book_type' ,'LIKE' ,'%'.$cat.'%' )
            ->orderBy('t1.id','DESC')
            ->paginate(18);
            $count_alls = $products_all->count();
            $head_text = "นิยาย Ebooks";
            if($cat){
                $head_text = "นิยาย Ebooks < ".$cat." >";
            }
            // DD($products_all->all());

       return view('front-end-ebook.productsEbook' , [
           'products_alls' => $products_all , 
           'count_all' => $count_alls ,
           'product_type' => "product_normal" ,
           'head_text' => $head_text ,
           'publishers' => $publishers ,
           'user' => $user ,
           'book_types' => $book_types ,
           'i' => 0 ,
           
       ]);
    }
    
    public function showProductsEbookSerieAll($name='')
    {
        $head_text = 'ซีรีส์ชุด E-Books';
        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
            }
        $book_types =  BookType::all();
        $publishers = Publisher::all();
        $products_all = DB::table('ebook_product as t1')
            ->leftJoin('publisher as t2', 't1.publishing1', '=', 't2.id')
            // ->leftJoin('favor_book as t3', 't1.id', '=', 't3.book_id')
            ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
                $join->on('t1.id', '=', 't3.book_id');
                $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
                $join->on('t3.is_ebook', '=', DB::raw("'true'"));
            })
            ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
                $join->on('t1.id', '=', 't4.product_id');
                $join->on('t4.username', '=', DB::raw("'".$username."'"));
            })
            ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
                $join->on('t1.id', '=', 't5.book_id');
                $join->on('t5.is_ebook', '=', DB::raw("'true'"));
                $join->on('t5.username', '=', DB::raw("'".$username."'"));
            })
            ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id','t1.product_image as picture','t4.id as ebook_approve_id','t5.id as tmp_cart_id' )
            ->where('t1.public_show' ,'=' , 'true');
            if($name){
                $a = explode("ลำดับที่",$name);
                if(count($a)>1) {
                    $products_all->where('t1.serie_set','like','%'.$a[0].'%');
                    $head_text = "ซีรีส์ชุด E-Books "." < ".$a[0]." >";
                }
                else {
                    $products_all->where('t1.serie_set','like','%'.$name.'%');
                    $head_text = "ซีรีส์ชุด E-Books "." < ".$name." >";
                }
            }
$products_all = $products_all->whereNotNull('serie_set')
            ->where('serie_set' ,'<>' ,'-')
            ->orderBy('t1.id','DESC')
            ->paginate(18);
            $count_alls = $products_all->count();
            // DD($products_all->all());

       return view('front-end-ebook.productsEbook' , [
           'products_alls' => $products_all , 
           'count_all' => $count_alls ,
           'product_type' => "product_serie" ,
           'head_text' => $head_text , //ซีรีส์ชุด E-Books
           'publishers' => $publishers ,
           'user' => $user ,
           'book_types' => $book_types ,
           'i' => 0 ,
       ]);
    }
    
    public function showProductsBestSeller()
    {
        $user = null;
        $user_id = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
        }else{
            //$user =''; 
            $user_id = '' ;
        }
        $publishers = Publisher::all();
        $products_all = DB::table('best_seller as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->leftJoin('product as t3', 't3.id', '=', 't1.book_id')
        ->leftJoin('favor_book as t4', function ($join)  use ($user_id) {
            $join->on('t3.id', '=', 't4.book_id');
            $join->on('t4.user_id', '=', DB::raw("'".$user_id."'"));
            $join->on('t4.is_ebook', '=', DB::raw("'false'"));
        })
        ->select('t1.*' , 't2.*' , 't3.id as id_product' ,'t2.id as id_pub' ,'t3.blog_url','t3.youtube_url','t3.blame_product','t3.buffet','t3.can_discount','t3.stock' ,'t3.stock_remain','t4.book_id as favor_book_id' )
        ->orderBy('t1.top','ASC')
        ->paginate(18);
        $count_alls = $products_all->count();

       return view('front-end.products' , [
           'products_alls' => $products_all , 
           'count_all' => $count_alls ,
           'product_type' => "product_best_seller" ,
           'head_text' => "นิยายขายดี" ,
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function showProductsWaitFiction()
    {
        $publishers = Publisher::all();
        $products_all = DB::table('wait_fiction as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub')
        ->orderBy('t1.created_at','DESC')
        ->paginate(18);
        $count_alls = $products_all->count();

        $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            }
       //$products_new =  Product::where()->orderBy('created_at','DESC')->limit(10);
        //DD($products_all->all());
       return view('front-end.products' , [
           'products_alls' => $products_all , 
           'count_all' => $count_alls ,
           'product_type' => "product_wait_fiction" ,
           'head_text' => "นิยายรอตีพิมพ์" ,
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function showProductsWaitFictionDetail($id)
    {
        $publishers = Publisher::all();
        $products_all = DB::table('wait_fiction as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->where('t1.id' , $id)
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub' )        
        ->orderBy('t1.created_at','DESC')
        ->first();

        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        }
        return view('front-end.productsDetail' , [
            'products_alls' => $products_all , 
            'publishers' => $publishers ,
            'user' => $user ,
            'product_type' => "product_wait_fiction" ,
        ]);
    }
    public function showProductsBlameAll()
    {
        $user = null;
        $user_id = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
        }else{
            //$user =''; 
            $user_id = '' ;
        }

        $publishers = Publisher::all();
        $products_blame = DB::table('product as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            $join->on('t1.id', '=', 't3.book_id');
            $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            $join->on('t3.is_ebook', '=', DB::raw("'false'"));
        })
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub' ,'t3.book_id as favor_book_id' )
        ->where('t1.blame_product' ,'=' , 'y')
        ->where('t1.buffet' ,'<>' , 'true')
        ->where('t1.public_show' ,'=' , 'true')
        ->orderBy('t1.id','DESC')
        ->paginate(18);
        $count_alls = $products_blame->count();

       return view('front-end.products' , [
           'products_alls' => $products_blame , 
           'count_all' => $count_alls ,
           'product_type' => "product_blame" ,
           'head_text' => "สินค้ามือหนึ่งสภาพเก่า" ,
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function showProductsBlameDetail($id)
    {
        $publishers = Publisher::all();
        $products_blame = DB::table('product as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub' )
        ->where('t1.id' , $id)
        ->where('t1.blame_product' ,'=' , 'y')
        ->where('t1.buffet' ,'<>' , 'true')
        ->where('t1.public_show' ,'=' , 'true')
        ->orderBy('t1.id','DESC')
        ->first();


        $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            }
       //$products_new =  Product::where()->orderBy('created_at','DESC')->limit(10);
        //DD($products_news->all());
        return view('front-end.productsDetail' , [
            'products_alls' => $products_blame , 
            'publishers' => $publishers ,
            'user' => $user ,
            'product_type' => "product_blame" ,
        ]);
    }
    public function showProductsSerieAll($name ='')
    {
        
        $user = null;
        $user_id = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
        }else{
            //$user =''; 
            $user_id = '' ;
        }

        $publishers = Publisher::all();
        $products_serie = DB::table('product as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            $join->on('t1.id', '=', 't3.book_id');
            $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            $join->on('t3.is_ebook', '=', DB::raw("'false'"));
        })
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub','t3.book_id as favor_book_id' )
        // ->where('t1.serie_product' ,'=' , 'y')
        // ->where('t1.buffet' ,'<>' , 'true')
        ->where('t1.public_show' ,'=' , 'true');
        
        if($name){
            $products_serie->where('t1.writer','like','%'.$name.'%');
        }else{
            $products_serie->where('t1.serie_product' ,'=' , 'y');
            $products_serie->where('t1.buffet' ,'<>' , 'true');
        }

        $products_serie = $products_serie->orderBy('t1.id','DESC')
        ->paginate(18);
        $count_alls = $products_serie->count();
        // DD($products_serie->get());

       return view('front-end.products' , [
           'products_alls' => $products_serie , 
           'count_all' => $count_alls ,
           'product_type' => "product_serie" ,
           'head_text' => "ซีรีส์ชุด"." < ".$name." >" ,
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function showProductsBuffetAll()
    {
        $user = null;
        $user_id = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
        }else{
            //$user =''; 
            $user_id = '' ;
        }

        $publishers = Publisher::all();
        $products_buffet = DB::table('product as t1')
        ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
        ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            $join->on('t1.id', '=', 't3.book_id');
            $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            $join->on('t3.is_ebook', '=', DB::raw("'false'"));
        })
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub' ,'t3.book_id as favor_book_id' )
        ->where('t1.buffet' ,'=' , 'true')
        ->where('t1.public_show' ,'=' , 'true')
        ->orderBy('t1.id','DESC')
        ->paginate(18);
        $count_alls = $products_buffet->count();

       return view('front-end.products' , [
           'products_alls' => $products_buffet , 
           'count_all' => $count_alls ,
           'product_type' => "product_buffet" ,
           'head_text' => "บุฟเฟ่ต์" ,
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function showProductsByPublisher($id)
    {
        $user = null;
        $user_id = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
        }else{
            //$user =''; 
            $user_id = '' ;
        }

        $publishers = Publisher::all();
        $publisher_find = Publisher::find($id);
        $products_by_pub = DB::table('publisher as t2')
        ->leftJoin('product as t1', 't1.publisher_id', '=', 't2.id')
        ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            $join->on('t1.id', '=', 't3.book_id');
            $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            $join->on('t3.is_ebook', '=', DB::raw("'false'"));
        })
        ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub' ,'t3.book_id as favor_book_id' )
        ->where('t1.publisher_id' ,'=' , $id)
        ->where('t1.public_show' ,'=' , 'true')
        ->orderBy('t1.id','DESC')
        ->paginate(18);
        if (!$products_by_pub->toArray()['data']){
            //abort(404);
        }
        $count_alls = $products_by_pub->count();

       return view('front-end.products' , [
           'products_alls' => $products_by_pub , 
           'count_all' => $count_alls ,
           'product_type' => "product_normal" ,
           'head_text' => $publisher_find->publisher ,
           'head_publisher_id' => $publisher_find->id ,
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }

    public function showProductsDetail($id)
    {
        $user = null;
        $user_id = '';
        $username = '';
        if (Auth::check()) {
            $user = Auth::user();
            $user_id = $user->id ;
            $username = $user->username ;
        }else{
            //$user =''; 
            $user_id = '' ;
        }
        $publishers = Publisher::all();

        // $products_all = Product::with(['getPublisher','getBookType'])->where('t1.id' , $id)->first();

        $products_all = DB::table('product as t1')
                ->leftJoin('publisher as t2', 't1.publisher_id', '=', 't2.id')
                ->leftJoin('book_type as t3', 't1.book_type_id', '=', 't3.id')
                ->leftJoin('best_seller as t4', 't4.book_id', '=', 't1.id')
                // ->leftJoin('order_history as t5', 't5.product_id', '=', 't1.id')
                ->leftJoin('order_history as t5', function($join) use ($username){
                    $join->on('t5.product_id', '=', 't1.id');
                    $join->on('t5.username','=',DB::raw("'".$username."'"));
                })
                ->leftJoin('product_rate as t6', function($join) use ($username){
                    $join->on('t6.product_id', '=', 't1.id');
                    $join->on('t6.username','=',DB::raw("'".$username."'"));
                })
                ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub', 't3.book_type' ,'t4.top','t5.id as order_history_id',
                't6.id as product_rate_id' )
                ->where('t1.id' , $id)
                ->first();

                //DD($products_all);
                $product_gallery_photo = ProductGalleryPhoto::where('product_id',$id)->orderBy('default','DESC')->orderBy('created_at','ASC')->get();
        if (!$products_all){
            abort(404);
        }
        if(request()->ajax()) {

            return response()->json(['des'=> $products_all->book_description]);
        }

        $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            }
            $products_type= 'product_normal';
            if(!empty($products_all->serie_product)){
                //DD($products_all->serie_product);
                if($products_all->serie_product == "y"){
                    $products_type = "product_serie";
                }
            }
            if(!empty($products_all->buffet)){
                //DD($products_all->buffet);
                if($products_all->buffet == "true"){
                    $products_type = "product_buffet";
                }
                
            }
            // OrderHistory
            // ProductRate
        
       return view('front-end.productsDetail' , [
           'products_alls' => $products_all , 
           'product_gallery_photo' => $product_gallery_photo , 
           'publishers' => $publishers ,
           'user' => $user ,
           'product_type' => $products_type ,
           
       ]);
    }

    public function showProductsEbookDetail($id)
    {
        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
                $username = '' ;
            }
        
        $publishers = Publisher::all();

        $products_all = Product::with(['getPublisher','getBookType','getFavorBook' => function($query) use ($user_id){
                    $query->where('user_id', $user_id);
                    $query->where('is_ebook', 'true');
                },'getApproveReadEbook' => function($query) use ($username){
                    $query->where('username', $username);
                },'getCartEbook' => function($query) use ($username){
                    $query->where('username', $username);
                    $query->where('is_ebook', 'true');
                }])->where('public_show' , 'true')->where('id' , $id)
                ->first();

        // $products_all = DB::table('ebook_product as t1')
                // ->leftJoin('publisher as t2', 't1.publishing1', '=', 't2.id')
                // ->leftJoin('book_type as t3', 't1.cat_id', '=', 't3.id')
                // ->leftJoin('favor_book as t4', function ($join)  use ($user_id) {
                //     $join->on('t1.id', '=', 't4.book_id');
                //     $join->on('t4.user_id', '=', DB::raw("'".$user_id."'"));
                //     $join->on('t4.is_ebook', '=', DB::raw("'true'"));
                // })
                // ->leftJoin('ebook_approve_ebook as t5', function ($join)  use ($username) {
                //     $join->on('t1.id', '=', 't5.product_id');
                //     $join->on('t5.username', '=', DB::raw("'".$username."'"));
                // })
                // ->leftJoin('tmp_cart as t6', function ($join)  use ($username) {
                //     $join->on('t1.id', '=', 't6.book_id');
                //     $join->on('t6.is_ebook', '=', DB::raw("'true'"));
                //     $join->on('t6.username', '=', DB::raw("'".$username."'"));
                // })
                // ->select('t1.*' , 't2.*' , 't1.id as id_product' ,'t2.id as id_pub', 't3.book_type','t1.product_image as picture' ,'t4.book_id as favor_book_id','t5.id as ebook_approve_id','t6.id as tmp_cart_id' )
                // ->where('t1.id' , $id)
                // ->first();

                // DD($products_all);

        if (!$products_all){
            abort(404);
        }
        if(request()->ajax()) {
            return response()->json(['des'=> $products_all->product_description]);
        }

        
            $products_type= 'product_normal';
       return view('front-end-ebook.productsEbookDetail' , [
           'products_alls' => $products_all , 
           'publishers' => $publishers ,
           'user' => $user ,
           'product_type' => $products_type ,
           
       ]);
    }

    public function showPrivacyAll()
    {
        $publishers = Publisher::all();
        $privacy = Privacy::where('approve_status' , 'y')->get();

        $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            }
       //$products_new =  Product::where()->orderBy('created_at','DESC')->limit(10);
        //DD($products_all->all());
       return view('front-end.privacy' , [
           'privacys' => $privacy , 
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function showPrivacyDetail($id)
    {
        $publishers = Publisher::all();
        $privacy = Privacy::where('id' , $id)->firstorfail();

        $user = null;
            if (Auth::check()) {
                $user = Auth::user();
            }
       //$products_new =  Product::where()->orderBy('created_at','DESC')->limit(10);
        //DD($products_all->all());
       return view('front-end.privacyDetail' , [
           'privacy' => $privacy , 
           'publishers' => $publishers ,
           'user' => $user ,
       ]);
    }
    public function ebook_bestseller($type , $limit ){
        $AgoDate = \Carbon\Carbon::now()->subWeek()->format('Y-m-d');  // returns 2016-02-03
        $NowDate = \Carbon\Carbon::now()->format('Y-m-d');  // returns 2016-02-10
        $NowMonthDate = \Carbon\Carbon::now()->format('m');
        $NowYearDate = \Carbon\Carbon::now()->format('Y');
        
        // DD($AgoDate);
        // DD($NowDate);

        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
            }

            
            
            $best = BestSellerAuto::with(['getProduct' => function($query) {
                $query->where('public_show' , 'true');
            },'getFavorBook' => function($query) use ($user_id){
                $query->where('user_id', $user_id);
                $query->where('is_ebook', 'true');
            },'getApproveReadEbook' => function($query) use ($username){
                $query->where('username', $username);
            },'getCartEbook' => function($query) use ($username){
                $query->where('username', $username);
                $query->where('is_ebook', 'true');
            }]);
            if($type === "day"){
                $best->whereDate('post_date' , $NowDate); //'2018-03-23'
            }elseif($type === "week"){
                $best->whereDate('post_date', '>=', $AgoDate)
                ->whereDate('post_date', '<=', $NowDate);
            }elseif($type === "month"){
                $best->whereYear('post_date', '=', $NowYearDate) //'2015'
                ->whereMonth('post_date', $NowMonthDate); //'11'
            }elseif($type === "year"){
                $best->whereYear('post_date', '=', $NowYearDate); //'2015'
            }
            $best = $best->select('*',DB::raw('sum(sale_qty) as qty'))
            ->groupBy('product_id')->orderBy('qty', 'DESC')->limit($limit)->get(); 
            
            return $best ;
        
            // $best_day = BestSellerEbook::select('ebook_bestseller.product_id as id_product','t2.product_name','t2.product_image','t2.product_pdf2',
            // 't2.cat_id', 't2.alias_price' ,'t2.product_price','t2.serie_set','t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id' ,DB::raw('sum(ebook_bestseller.sale_qty) as qty'))
            // ->leftJoin('ebook_product as t2', 't2.id', '=', 'ebook_bestseller.product_id')
            // ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
            //     $join->on('t2.id', '=', 't3.book_id');
            //     $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
            //     $join->on('t3.is_ebook', '=', DB::raw("'true'"));
            // })
            // ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
            //     $join->on('t2.id', '=', 't4.product_id');
            //     $join->on('t4.username', '=', DB::raw("'".$username."'"));
            // })
            // ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
            //     $join->on('t2.id', '=', 't5.book_id');
            //     $join->on('t5.is_ebook', '=', DB::raw("'true'"));
            //     $join->on('t5.username', '=', DB::raw("'".$username."'"));
            // })
            // ->where('t2.public_show' ,'=' , 'true')
            
            // ->groupBy('ebook_bestseller.product_id')->orderBy('qty', 'DESC')->limit($limit)->paginate(18); //today
            // return $best_day ;
        // }elseif($type === "week"){
        //     $best_week = BestSellerEbook::select('ebook_bestseller.product_id as id_product','t2.product_name','t2.product_image','t2.product_pdf2',
        //     't2.cat_id', 't2.alias_price' ,'t2.product_price','t2.serie_set','t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id' ,DB::raw('sum(ebook_bestseller.sale_qty) as qty'))
        //     ->leftJoin('ebook_product as t2', 't2.id', '=', 'ebook_bestseller.product_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t2.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'true'"));
        //     })
        //     ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
        //         $join->on('t2.id', '=', 't4.product_id');
        //         $join->on('t4.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
        //         $join->on('t2.id', '=', 't5.book_id');
        //         $join->on('t5.is_ebook', '=', DB::raw("'true'"));
        //         $join->on('t5.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->where('t2.public_show' ,'=' , 'true')
        //     ->whereDate('ebook_bestseller.post_date', '>=', $AgoDate)
        //     ->whereDate('ebook_bestseller.post_date', '<=', $NowDate)
        //     // ->whereBetween('ebook_bestseller.post_date', ['2020-11-18', '2020-11-18']) //['2018-03-18', '2018-03-23']
        //     ->groupBy('ebook_bestseller.product_id')->orderBy('qty', 'DESC')->limit($limit)->paginate(18); //of week
        //     return $best_week ;
        // }elseif($type === "month"){
        //     $best_month = BestSellerEbook::select('ebook_bestseller.product_id as id_product','t2.product_name','t2.product_image','t2.product_pdf2',
        //     't2.cat_id', 't2.alias_price' ,'t2.product_price','t2.serie_set','t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id' ,DB::raw('sum(ebook_bestseller.sale_qty) as qty'))
        //     ->leftJoin('ebook_product as t2', 't2.id', '=', 'ebook_bestseller.product_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t2.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'true'"));
        //     })
        //     ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
        //         $join->on('t2.id', '=', 't4.product_id');
        //         $join->on('t4.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
        //         $join->on('t2.id', '=', 't5.book_id');
        //         $join->on('t5.is_ebook', '=', DB::raw("'true'"));
        //         $join->on('t5.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->where('t2.public_show' ,'=' , 'true')
        //     ->whereYear('ebook_bestseller.post_date', '=', $NowYearDate) //'2015'
        //     ->whereMonth('ebook_bestseller.post_date', $NowMonthDate) //'11'
        //     ->groupBy('ebook_bestseller.product_id')->orderBy('qty', 'DESC')->limit($limit)->paginate(18); //of Month
        //     return $best_month ;
        // }elseif($type === "year"){
        //     $best_year = BestSellerEbook::select('ebook_bestseller.product_id as id_product','t2.product_name','t2.product_image','t2.product_pdf2',
        //     't2.cat_id', 't2.alias_price' ,'t2.product_price','t2.serie_set' ,'t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id',DB::raw('sum(ebook_bestseller.sale_qty) as qty'))
        //     ->leftJoin('ebook_product as t2', 't2.id', '=', 'ebook_bestseller.product_id')
        //     ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
        //         $join->on('t2.id', '=', 't3.book_id');
        //         $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
        //         $join->on('t3.is_ebook', '=', DB::raw("'true'"));
        //     })
        //     ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
        //         $join->on('t2.id', '=', 't4.product_id');
        //         $join->on('t4.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
        //         $join->on('t2.id', '=', 't5.book_id');
        //         $join->on('t5.is_ebook', '=', DB::raw("'true'"));
        //         $join->on('t5.username', '=', DB::raw("'".$username."'"));
        //     })
        //     ->where('t2.public_show' ,'=' , 'true')
        //     ->whereYear('ebook_bestseller.post_date', '=', $NowYearDate) //'2015'
        //     ->groupBy('ebook_bestseller.product_id')->orderBy('qty', 'DESC')->limit($limit)->paginate(18); //of Year
        //     return $best_year ;
        // }
        // DD($best_month[0]->qty);
    }

    
    public function ebook_daily($type , $limit ){
        
        $today = \Carbon\Carbon::now()->format('Y-m-d');  // returns 2016-02-10
        $yesterday = \Carbon\Carbon::yesterday()->toDateString();
        $AgoDate = \Carbon\Carbon::now()->subWeek()->format('Y-m-d');  // returns 2016-02-03
        $NowMonthDate = \Carbon\Carbon::now()->format('m');
        $NowMonthDate = \Carbon\Carbon::now()->format('m');
        $NowYearDate = \Carbon\Carbon::now()->format('Y');
        
        // DD($AgoDate);
        // DD($NowDate);

        $user = null;
        $user_id = '';
        $username = '';
            if (Auth::check()) {
                $user = Auth::user();
                $user_id = $user->id ;
                $username = $user->username ;
            }else{
                //$user =''; 
                $user_id = '' ;
            }

        
        if($type === "day"){
            $daily_today = Daily::select('DATE',DB::raw('sum(NUM) as num_sum'))
            ->whereDate('DATE' , $NowDate); //'2018-03-23'
            return $daily_today ;
        }elseif($type === "week"){
           
            return $best_week ;
        }elseif($type === "month"){
            $best_month = BestSellerEbook::select('ebook_bestseller.product_id as id_product','t2.product_name','t2.product_image','t2.product_pdf2',
            't2.cat_id', 't2.alias_price' ,'t2.product_price','t2.serie_set','t3.book_id as favor_book_id','t4.id as ebook_approve_id','t5.id as tmp_cart_id' ,DB::raw('sum(ebook_bestseller.sale_qty) as qty'))
            ->leftJoin('ebook_product as t2', 't2.id', '=', 'ebook_bestseller.product_id')
            ->leftJoin('favor_book as t3', function ($join)  use ($user_id) {
                $join->on('t2.id', '=', 't3.book_id');
                $join->on('t3.user_id', '=', DB::raw("'".$user_id."'"));
                $join->on('t3.is_ebook', '=', DB::raw("'true'"));
            })
            ->leftJoin('ebook_approve_ebook as t4', function ($join)  use ($username) {
                $join->on('t2.id', '=', 't4.product_id');
                $join->on('t4.username', '=', DB::raw("'".$username."'"));
            })
            ->leftJoin('tmp_cart as t5', function ($join)  use ($username) {
                $join->on('t2.id', '=', 't5.book_id');
                $join->on('t5.is_ebook', '=', DB::raw("'true'"));
                $join->on('t5.username', '=', DB::raw("'".$username."'"));
            })
            ->where('t2.public_show' ,'=' , 'true')
            ->whereYear('ebook_bestseller.post_date', '=', $NowYearDate) //'2015'
            ->whereMonth('ebook_bestseller.post_date', $NowMonthDate) //'11'
            ->groupBy('ebook_bestseller.product_id')->orderBy('qty', 'DESC')->limit($limit)->paginate(18); //of Month
            return $best_month ;
        }elseif($type === "year"){
            // $best_year = Daily::select('DATE',DB::raw('sum(NUM) as num_sum'))
            // ->where('DATE')
            // return $best_year ;
        }
        // DD($best_month[0]->qty);
    }
    
}
