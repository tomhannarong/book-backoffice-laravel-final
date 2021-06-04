<?php

namespace App\Http\Controllers;

use App\Product;
use App\BookType;
use App\Publisher;
use App\ProductGalleryPhoto;

use Illuminate\Http\Request;
use Validator,Redirect,Response;;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $btn_Discount , $btn_cloneBuffet ='' ;
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
        if(request()->ajax()) {
            $data = null ;
            switch ($request->status) {
                case "status_nor":
                    // $data = DB::table('product as t1')
                    // ->select('t1.*')
                    // ->where('t1.blame_product' ,'<>' , 'y')
                    // ->where('t1.buffet' ,'<>' , 'true')
                    // ->where('t1.is_ebook' ,'=' , 'false')
                    // ->orderBy('t1.id','DESC')
                    // ->get();
                    $data = Product::with(['getPhoto'])->where('blame_product' ,'<>' , 'y')
                    ->where('buffet' ,'<>' , 'true')
                    ->where('is_ebook' ,'=' , 'false')
                    ->orderBy('id' ,'DESC')
                    ->get();
                    // DD($data);
                    //     echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";
                    // die;

                    break;
                case "status_blame":
                    // $data = DB::table('product as t1')
                    // ->select('t1.*')
                    // ->where('t1.blame_product' ,'=' , 'y')
                    // ->where('t1.buffet' ,'<>' , 'true')
                    // ->where('t1.is_ebook' ,'=' , 'false')
                    // ->orderBy('t1.id','DESC')
                    // ->get();
                    $data = Product::with(['getPhoto'])->where('blame_product' ,'=' , 'y')
                    ->where('buffet' ,'<>' , 'true')
                    ->where('is_ebook' ,'=' , 'false')
                    ->orderBy('id' ,'DESC')
                    ->get();
                    $this->btn_Discount = 'disabled';
                    $this->btn_cloneBuffet ='disabled';
                  break;
                case "status_serie":
                    // $data = DB::table('product as t1')
                    // ->select('t1.*')
                    // ->where('t1.serie_product' ,'=' , 'y')
                    // ->where('t1.buffet' ,'<>' , 'true')
                    // ->where('t1.is_ebook' ,'=' , 'false')
                    // ->orderBy('t1.id','DESC')
                    // ->get();
                    $data = Product::with(['getPhoto'])
                    ->where('serie_product' ,'=' , 'y')
                    ->where('buffet' ,'<>' , 'true')
                    ->where('is_ebook' ,'=' , 'false')
                    ->orderBy('id' ,'DESC')
                    ->get();
                    $this->btn_cloneBuffet ='disabled';
                  break;
                case "status_buffet":
                    // $data = DB::table('product as t1')
                    // ->select('t1.*')
                    // ->where('t1.buffet' ,'=' , 'true')
                    // ->where('t1.is_ebook' ,'=' , 'false')
                    // ->orderBy('t1.id','DESC')
                    // ->get();
                    $data = Product::with(['getPhoto'])
                    ->where('buffet' ,'=' , 'true')
                    ->where('is_ebook' ,'=' , 'false')
                    ->orderBy('id' ,'DESC')
                    ->get();
                    $this->btn_Discount = 'disabled';
                    $this->btn_cloneBuffet ='disabled';
                    break;
                default:
                // $data = DB::table('product')->where('is_ebook' ,'=' , 'false')->orderBy('id' ,'DESC')
                // $data = Product::with(['getPhoto'])->where('is_ebook' ,'=' , 'false')->orderBy('id' ,'DESC')->get();
                

            }
            // DD($request->status);
            
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('photo', function($row){
                // DD($row);
                // echo "<pre>";
                // print_r($row);
                // echo "</pre>";
                // die;
                $html = "";
                foreach ($row->getPhoto as $value ) {
                    if($value->default == "true"){
                        $html = '<img src="'.asset('storage/book-images/thumbnail/'.($value->photo ?? '') ).'" width="75" class="box_shadow " />';
                        return $html  ;
                    }
                    else{
                        $html = '<img src="'.asset('storage/book-images/thumbnail/'.($row->getPhoto[0]->photo ?? '') ).'" width="70" class="box_shadow" />';
                    }
                }
                return $html  ;
                // var path = "{{  }}/"+data.getPhoto.photo ;
                        //    var html = '';
            })
            ->addColumn('public', function($row){
                $ch = "";
                $title = "OFF";
                $value = "off";
                $color = "btn-light";
                if($row->public_show == "true"){
                    $ch = "checked";
                    $title = "ON";
                    $value = "on";
                    $color = "btn-success";
                }  
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" '.$ch.' data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="public" class="btn '.$color.' box_shadow isCheckPublic ">'.$title.'</a>';
 
            })
            ->addColumn('discount', function($row){     
                $ch = "";
                $title = "OFF";
                $value = "off";
                $color = "btn-light";   
                if($row->can_discount == "true"){
                    $ch = "checked";
                    $title = "ON";
                    $value = "on";
                    $color = "btn-success";
                }  
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" '.$ch.' data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="discount" class="btn '.$color.' '.$this->btn_Discount.' box_shadow isCheckDiscount">'.$title.'</a>';
     
            })
            ->addColumn('cloneBuffet', function($row){     
             
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" class="btn btn-info '.$this->btn_cloneBuffet.' box_shadow cloneBuffet"><i class="fas fa-check-double fa-3"></i></a>';
       
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light box_shadow btn_rounded editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light box_shadow btn_rounded deleteBtn">Delete</a>';
                 return $btn;
            })
            ->rawColumns(["photo","action", "public", "discount", "cloneBuffet"])
            ->make(true);

        }
        //$books = Book::all();
        return view("products.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $booktype = BookType::all();
        $publisher = Publisher::all();
        return view("products.add-product" , [
           'booktypes' => $booktype ,
           'publishers' => $publisher
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(request()->ajax()) {
            if($request->fn){
                if($request->fn == "upload_image_detail"){
                    $file = request()->file('file') ;
                    $filenamewithextension = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                    //check dir path 
                    $path_dir = 'public/book-des-images';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
                    //Resize image here
                    $thumbnailpath = base_path().'/public/storage/book-des-images/'.$filenametostore;
                    $width = 500; // your max width
                    $height = 500; // your max height
                    $img = Image::make($file->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);
                    // $path = asset('storage/book-des-images/'.$filenametostore) ;
                    // <img src="../../public/storage/book-des-images/01142021153513600002411e415.jpg" width="333" height="500" alt="" data-mce-selected="1">
                    // <img src="../../public/storage/book-des-images/01142021153914600003324d24b.jpg" alt="" width="500" height="281">
                    // $path = public_path('storage/book-des-images/'.$filenametostore);
                    // http://localhost/lightoflove-dev/admin/public/storage/book-des-images/0114202115525160000663a1f6e.jpg
                    return response()->json(['location'=>  asset('storage/book-des-images/'.$filenametostore) ]);

                }                
            }
        }
        
        $filenamearr = [];
        // DD($request->all());
        
         $product = new Product();
         $request->has('blame_product') ? $product->blame_product ='y' : $product->blame_product ='n';
         $request->has('serie_product') ? $product->serie_product ='y' : $product->serie_product ='n';
         $request->has('buffet') ? $product->buffet ='true' : $product->buffet ='false';
        //  $request->has('lipstick') ? $product->show_blame ='y' : $product->show_blame ='n';
         $product->book_name = $request->book_name;
         $product->book_type_id = $request->book_type;
         $product->writer = $request->writer;
         $product->alias = $request->alias;
         $product->price = $request->price;
         $product->product_price = $request->product_price;
         $product->pages = $request->pages;
         $product->book_description = $request->description;
         $product->stock = $request->stock ? $request->stock : 0;
         $product->on_market = $request->on_market;
         $product->ISBN = $request->isbn;
         $product->pim_time = $request->pim_time;
         $product->pim_year = $request->pim_year;
         $product->publisher_id = $request->publisher;
         $product->tag_description = $request->tag_description;
         $product->tag_keyword = $request->tag_keyword;
         $product->blog_url = $request->blog_url;
         $product->youtube_url = $request->youtube_url;
         $product->blame_position = $request->blame_position;
         $product->stock_total = 0;
         $product->stock_hold = 0;
         $product->stock_remain = $request->stock ? $request->stock : 0;
         $product->stock_sold = 0;
         $product->public_show = "true";
         $product->is_ebook = "false";
         
         if($request->has('serie_product')){
            $product->can_discount = "false";
         }else{
            $product->can_discount = "true";
         }
         $product->book_weight = $request->book_weight;
         
         //รูปปก
        
        if($request->hasFile('name_picture')) {
            foreach($request->file('name_picture') as $file)
            {
                $filenamewithextension = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                //check dir path 
                $path_dir = 'public/book-images/thumbnail';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }
                //Upload File
                $path = public_path('storage/book-images/'.$filenametostore);
                $img =   Image::make($file->getRealPath())->save($path);

                //Resize image here
                // $thumbnailpath = public_path('storage/slip-images/thumbnail/'.$filenametostore);
                $thumbnailpath = base_path().'/public/storage/book-images/thumbnail/'.$filenametostore;
                $width = 500; // your max width
                $height = 500; // your max height
                $img = Image::make($file->getRealPath());
                $img->height() > $img->width() ? $width=null : $height=null;
                $img->resize($width, $height, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);

                array_push($filenamearr,$filenametostore);
                // ProductGalleryPhoto::create([
                //     'product_id' => $product->id,
                //     'photo' => $filenametostore
                // ]);
                
            }
            $product->picture = $filenametostore;


            
        }
         //รูปตำหนิ     
        if($request->hasFile('blame_picture')) {

            //get filename with extension
            $filenamewithextension = $request->file('blame_picture')->getClientOriginalName();
    
            //get filename without extension
            //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
            //get file extension
            $extension = $request->file('blame_picture')->getClientOriginalExtension();
    
            //filename to store
            //$filenametostore = $filename.'_'.time().'.'.$extension;
            $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
    
            //check dir path 
            $path_dir = 'public/blame-picture';
            if(!Storage::exists($path_dir)){
                Storage::makeDirectory($path_dir);
            }

            //Upload File
            $path = public_path('storage/blame-picture/'.$filenametostore);
            $img =   Image::make($request->file('blame_picture')->getRealPath())->save($path);
            
            $product->blame_images = $filenametostore;
        }
        //ไฟล์       
        if($request->hasFile('readpdf')) {
            //get filename with extension
            $filenamewithextension = $request->file('readpdf')->getClientOriginalName();
    
            //get filename without extension
            //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
            //get file extension
            $extension = $request->file('readpdf')->getClientOriginalExtension();
    
            //filename to store
            //$filenametostore = $filename.'_'.time().'.'.$extension;
            $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
    
            //check dir path 
            $path_dir = 'public/file-preview';
            if(!Storage::exists($path_dir)){
                Storage::makeDirectory($path_dir);
            }

            //Upload File
            $request->file('readpdf')->storeAs('public/file-preview', $filenametostore);

            $product->attachment = $filenametostore;

        }
        $product->save();

        if($request->hasFile('name_picture')) {
            foreach($filenamearr as $value)
            {
                // $filenamearr.array_push($filenametostore);
                ProductGalleryPhoto::create([
                    'product_id' => $product->id,
                    'photo' => $value
                ]);
            }
        }
        
        return redirect()->route('products.index');
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
    public function edit(Request $request,$id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        //  $product = Product::find($id)
        $product = Product::with(["getPhoto"])->where('id',$id)->firstOrFail();
         if(!empty($request->fn)){
            if($request->fn == "show_photo"){
            $product = Product::with(["getPhoto"])->where('id',$id)->firstOrFail();
         
            $html = '';
            foreach($product->getPhoto as $val){
    $html .=    '<div class="img-div">
                    <img src="'.asset('storage/book-images/' . $val->photo).'" width="200px"  class="img-responsive image img-thumbnail"> 
                    <div class="middle">
                    <a href="javascript:void(0)" class="default_photo btn ';
                    if($val->default =="true"){
    $html .=            ' btn-success-custom ';
                    }else{
    $html .=            ' btn-default-custom ';
                    }
                    $html .='"  data-id="'.$val->id.'" data-id-product="'.$val->product_id.'"><i class="fas fa-check"></i></a>
                        <a href="javascript:void(0)" class="btn btn-paid-sendback del_photo" data-id="'.$val->id.'"><i class="fa fa-trash"></i></a>
                    </div>                                                                                  
                </div>';
            }
            return response()->json(['success'=>'Item saved successfully.' , 'html' => $html]);
                
            }
        }
        // DD($product);
        $booktype = BookType::all();
        $publisher = Publisher::all();
        // if (!$product){
        //     abort(404);
        // }
        //DD($product->all());
        return view("products.edit-product" , [
           'booktypes' => $booktype ,
           'publishers' => $publisher,
           'product' => $product
        ]);
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
        if(request()->ajax()) {
            if($request->has('fn')){
                if($request->fn === "public"){
                    Product::find($id)->update([
                        'public_show' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.' , 'public_status' => $request->status , 'fn' => $request->fn]);
                }
                else if($request->fn === "default_photo"){
                    Product::find($id)->update([
                        'can_discount' => $request->status
                    ]);
                    $product_gallery_photo = ProductGalleryPhoto::where("product_id" ,$request->id_product);
                    $product_gallery_photo->update([
                        "default" => "false"
                    ]);
                    $product_gallery_photo = ProductGalleryPhoto::find($id);
                    $product_gallery_photo->update([
                        "default" => "true"
                    ]);
                    return response()->json(['success'=>'Item saved successfully.', 'val' => $id ]);
                }else if($request->fn === "discount"){
                    Product::find($id)->update([
                        'can_discount' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.' , 'discount_status' => $request->status , 'fn' => $request->fn]);
                }else if($request->fn === "cloneBuffet"){
                    $product_old = Product::find($id);

                    $product = new Product();
                    $product->blame_product ='n';
                    $product->serie_product ='n';
                    $product->buffet ='true';
                    $product->show_blame ='n';
                    $product->book_name = $product_old->book_name.' (บุฟเฟ่ต์)';
                    $product->book_type_id = $product_old->book_type_id;
                    $product->writer = $product_old->writer;
                    $product->alias = $product_old->alias;
                    $product->price = $product_old->price;
                    $product->product_price = $product_old->product_price;
                    $product->pages = $product_old->pages;
                    $product->book_description = $product_old->book_description;
                    $product->on_market = $product_old->on_market;
                    $product->ISBN = $product_old->ISBN;
                    $product->pim_time = $product_old->pim_time;
                    $product->pim_year = $product_old->pim_year;
                    $product->publisher_id = $product_old->publisher_id;
                    $product->tag_description = $product_old->tag_description;
                    $product->tag_keyword = $product_old->tag_keyword;
                    $product->blog_url = $product_old->blog_url;
                    $product->youtube_url = $product_old->youtube_url;
                    $product->blame_position = $product_old->blame_position;
                    $product->stock = 0;
                    $product->stock_total = 0;
                    $product->stock_hold = 0;
                    $product->stock_remain = 0;
                    $product->stock_sold = 0;
                    $product->public_show = "true";
                    $product->can_discount = "false";
                    $product->book_weight = $product_old->book_weight;
                    $product->is_ebook = "false";
                    
                    $exp = explode('.' , $product_old->picture);

                    $filenametostore = date('mdYHis') . uniqid().'.'.$exp[1];
                    //check dir path 
                    $path_dir = 'public/book-images/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }

                    Storage::copy($path_dir.'/'.$product_old->picture, $path_dir.'/'.$filenametostore);
                    Storage::copy('public/book-images/'.$product_old->picture,'public/book-images/'.$filenametostore);

                    $product->picture = $filenametostore;
                    $product->save();
                    return response()->json(['success'=>'Item saved successfully.' , 'cloneBuffet_status' => $id , 'fn' => $request->fn]);
                } 
            }   

            $product = Product::find($id);

            // $product->name = 'New Flight Name';

            

            $request->has('blame_product') ? $product->blame_product ='y' : $product->blame_product ='n';
            $request->has('serie_product') ? $product->serie_product ='y' : $product->serie_product ='n';
            $request->has('buffet') ? $product->buffet ='true' : $product->buffet ='false';
            // $request->has('lipstick') ? $product->show_blame ='y' : $product->show_blame ='n';
            $product->book_name = $request->book_name;
            $product->book_type_id = $request->book_type;
            $product->writer = $request->writer;
            $product->alias = $request->alias;
            $product->price = $request->price;
            $product->pages = $request->pages;
            $product->book_description = $request->description;
            $product->stock = $request->stock;
            $product->on_market = $request->on_market;
            $product->ISBN = $request->isbn;
            $product->pim_time = $request->pim_time;
            $product->pim_year = $request->pim_year;
            $product->publisher_id = $request->publisher;
            $product->tag_description = $request->tag_description;
            $product->tag_keyword = $request->tag_keyword;
            $product->blog_url = $request->blog_url;
            $product->youtube_url = $request->youtube_url;
            $product->blame_position = $request->blame_position;
            $product->stock_total = 0;
            $product->stock_hold = 0;
            $product->stock_remain = 0;
            $product->stock_sold = 0;
            $product->public_show = "true";
            if($request->has('blame_product') || $request->has('buffet') ){
                $product->can_discount = "false";
             }else{
                $product->can_discount = "true";
             }
            $product->book_weight = $request->book_weight;

            if($request->hasFile('name_picture')) {
                $filenamearr = [];
                foreach($request->file('name_picture') as $file)
                {
                    $filenamewithextension = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                    //check dir path 
                    $path_dir = 'public/book-images/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
                    //Upload File
                    $path = public_path('storage/book-images/'.$filenametostore);
                    $img =   Image::make($file->getRealPath())->save($path);
    
                    //Resize image here
                    // $thumbnailpath = public_path('storage/slip-images/thumbnail/'.$filenametostore);
                    $thumbnailpath = base_path().'/public/storage/book-images/thumbnail/'.$filenametostore;
                    $width = 500; // your max width
                    $height = 500; // your max height
                    $img = Image::make($file->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);
    
                    array_push($filenamearr,$filenametostore);
                    // ProductGalleryPhoto::create([
                    //     'product_id' => $product->id,
                    //     'photo' => $filenametostore
                    // ]);
                    
                }
                $product->picture = $filenametostore;
    
    
                
            }
            //รูปตำหนิ     
            if($request->hasFile('blame_picture')) {

                //get filename with extension
                $filenamewithextension = $request->file('blame_picture')->getClientOriginalName();
        
                //get filename without extension
                //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        
                //get file extension
                $extension = $request->file('blame_picture')->getClientOriginalExtension();
        
                //filename to store
                //$filenametostore = $filename.'_'.time().'.'.$extension;
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
        
                //check dir path 
                $path_dir = 'public/blame-picture';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }

                //Upload File
                $path = public_path('storage/blame-picture/'.$filenametostore);
                $img =   Image::make($request->file('blame_picture')->getRealPath())->save($path);
                
                // DELETE FILE
                $product_db = Product::find($id);
                $path_dir_old = $path_dir . '/' .$product_db->blame_images ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }
                
                $product->blame_images = $filenametostore;
            }
            //ไฟล์       
            if($request->hasFile('readpdf')) {
                //get filename with extension
                $filenamewithextension = $request->file('readpdf')->getClientOriginalName();
        
                //get filename without extension
                //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        
                //get file extension
                $extension = $request->file('readpdf')->getClientOriginalExtension();
        
                //filename to store
                //$filenametostore = $filename.'_'.time().'.'.$extension;
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
        
                //check dir path 
                $path_dir = 'public/file-preview';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }

                //Upload File
                $request->file('readpdf')->storeAs('public/file-preview', $filenametostore);

                // DELETE FILE
                $product_db = Product::find($id);
                $path_dir_old = $path_dir . '/' .$product_db->attachment ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }

                $product->attachment = $filenametostore;

            }
            $product->save();
            
            if($request->hasFile('name_picture')) {
                foreach($filenamearr as $value)
                {
                    // $filenamearr.array_push($filenametostore);
                    ProductGalleryPhoto::create([
                        'product_id' => $product->id,
                        'photo' => $value
                    ]);
                }
            }
            // preg_replace('#<script(.*?)>(.*?)</script>#is', '', html_entity_decode($request->description))
            // val: "<pre style="text-align: center;"><strong><em>123123</em></strong></pre><p>&nbsp;</p><p>&lt;script&gt;location.reload();&lt;/script&gt;</p>"
            // val: "&lt;p style=&quot;text-align: center;&quot;&gt;&lt;strong&gt;&lt;em&gt;123123&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&nbsp;&lt;/p&gt;&lt;p&gt;&lt;script&gt;location.reload();&lt;/script&gt;&lt;/p&gt;"
            // val: "&lt;p style=&quot;text-align: center;&quot;&gt;&lt;strong&gt;&lt;em&gt;123123&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt; &lt;/p&gt;&lt;p&gt;&lt;script&gt;location.reload();&lt;/script&gt;&lt;/p&gt;"

            return response()->json(['success'=>'Item saved successfully.' , 'fn' => $request->fn  ]);
            
        }
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         if(!empty($request->fn)){
             if($request->fn == "del_photo"){
               $product_gallery_photo = ProductGalleryPhoto::find($id);
            //    return response()->json(['success'=>'Record deleted Successfully.' ,'photo' => $product_gallery_photo]);
                // DELETE FILE
                $path_dir = 'public/book-images/thumbnail';
                $path_dir_old_thumbnail = $path_dir . '/' .$product_gallery_photo->photo ;
                $path_dir_old_full = 'public/book-images/' .$product_gallery_photo->photo;
                if(Storage::exists($path_dir_old_thumbnail)){
                    Storage::delete($path_dir_old_thumbnail); 
                }
                if(Storage::exists($path_dir_old_full)){
                    Storage::delete($path_dir_old_full);
                }
                $product_gallery_photo->delete();
                return response()->json(['success'=>'Record deleted Successfully.']);
             }
         }
         

         $product = Product::find($id);
         $product_gallery_photo = ProductGalleryPhoto::where('product_id' , $id)->get();
         //รูปปก
         if($product_gallery_photo){
             foreach ($product_gallery_photo as $photo){
                    // DELETE FILE
                $path_dir = 'public/book-images/thumbnail';
                $path_dir_old_thumbnail = $path_dir . '/' .$photo->photo ;
                $path_dir_old_full = 'public/book-images/' .$photo->photo;
                if(Storage::exists($path_dir_old_thumbnail)){
                    Storage::delete($path_dir_old_thumbnail); 
                }
                if(Storage::exists($path_dir_old_full)){
                    Storage::delete($path_dir_old_full);
                }
             }
             ProductGalleryPhoto::where('product_id' , $id)->delete();
            //  $product_gallery_photo->delete();
             
         }
         //รูปตำหนิ 
         if($product->blame_images){
            
            // DELETE FILE
           $path_dir = 'public/blame-picture';
           $path_dir_old = $path_dir . '/' .$product->blame_images ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }
         }
        //ไฟล์ 
         if($product->attachment){
            // DELETE FILE
           $path_dir = 'public/file-preview';
           $path_dir_old = $path_dir . '/' .$product->attachment ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }
         }

         $product->delete();
         //return response()->json(['success'=>'Record deleted Successfully.' , 'status' => $product->picture]);
       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
