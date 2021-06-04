<?php

namespace App\Http\Controllers;

use App\ProductEbook;
use App\Product;
use App\BookType;
use App\Publisher;
use App\ProductGalleryPhoto;
use App\WebConfig;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductEbookController extends Controller
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
        if(request()->ajax()) {
            $data = null ;
            
            $data = Product::with(['getPhoto'])
                ->leftJoin('publisher as t2', 'product.publisher_id' ,'t2.id')                
                ->select('product.*','t2.publisher as publisher_name')->orderBy('product.id' ,'DESC')                
                ->where('product.is_ebook' ,'=' , 'true')
                ->get();
 
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('photo', function($row){
                $html = "";
                foreach ($row->getPhoto as $value ) {
                    if($value->default == "true"){
                        $html = '<img src="'.asset('storage/book-images/'.($value->photo ?? '') ).'" width="70" />';
                        return $html  ;
                    }
                    else{
                        $html = '<img src="'.asset('storage/book-images/'.($row->getPhoto[0]->photo ?? '') ).'" width="70" />';
                    }
                }
                return $html  ;
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
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light btn_rounded box_shadow editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
                 return $btn;
            })
            ->rawColumns(["photo","action", "public"])
            ->make(true);
        }
        return view("products-ebook.index");
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
        $webConfig = WebConfig::firstOrFail();
        return view("products-ebook.add-product" , [
           'booktypes' => $booktype ,
           'publishers' => $publisher ,
           'web_config' => $webConfig
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
        
        $user = Auth::user();
        $filenamearr = [];

        $product = new Product();
        $product->book_name = $request->book_name;
        $product->book_type_id = $request->book_type;
        $product->book_description = $request->description;    
        $product->price = $request->price;
        $product->product_price = $request->price_real;
        $product->stock_sold = 0 ;
        $product->alias = $request->alias;
        $product->publisher_id = $request->publisher;
        $product->writer = $request->writer;
        $product->ISBN = $request->isbn;
        $product->promote_link = $request->promote_link;
        $product->public_show = "true";
        $product->is_ebook = "true";
        $product->affiliate_price = $request->affiliate_price;

        $product->username = $user->username;
        $product->user_book = "n";
        $product->publish1 = "y";
         
        
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
            }
            $product->picture = $filenametostore;    
        }

        //ไฟล์ตัวอย่าง       
        if($request->hasFile('readpdf')) {
            $filenamewithextension = $request->file('readpdf')->getClientOriginalName();
            $extension = $request->file('readpdf')->getClientOriginalExtension();
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
        //ไฟล์จริงๆ
        if($request->hasFile('pdf')) {
            $filenamewithextension = $request->file('pdf')->getClientOriginalName();
            $extension = $request->file('pdf')->getClientOriginalExtension();
            $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
            //check dir path 
            $path_dir = 'public/file-ebooks';
            if(!Storage::exists($path_dir)){
                Storage::makeDirectory($path_dir);
            }
            //Upload File
            $request->file('pdf')->storeAs('public/file-ebooks', $filenametostore);
            $product->product_pdf = $filenametostore;
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

        return redirect()->route('productsEbook.index');
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
    public function edit(Request $request, $id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        // $product = Product::find($id);

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

        $booktype = BookType::all();
        $publisher = Publisher::all();
        if (!$product){
            abort(404);
        }
        //DD($product->all());
        return view("products-ebook.edit-product" , [
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
        // DD($request->all());
        if(request()->ajax()) {
            if($request->has('fn')){
                if($request->fn === "public"){
                    Product::find($id)->update([
                        'public_show' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.' , 'public_status' => $request->status , 'fn' => $request->fn]);
                }else if($request->fn === "default_photo"){
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
                }
            }


            $product = Product::find($id);
            $product->book_name = $request->book_name;
            $product->book_type_id = $request->book_type;
            $product->book_description = $request->description;    
            $product->price = $request->price;
            $product->product_price = $request->price_real;
            $product->alias = $request->alias;
            $product->publisher_id = $request->publisher;
            $product->writer = $request->writer;
            $product->ISBN = $request->isbn;
            $product->promote_link = $request->promote_link;
            $product->affiliate_price = $request->affiliate_price;
            

                //รูปปก
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

            //ไฟล์ตัวอย่าง     
            if($request->hasFile('readpdf')) {

                $filenamewithextension = $request->file('readpdf')->getClientOriginalName();
                $extension = $request->file('readpdf')->getClientOriginalExtension();
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
            //ไฟล์จริงๆ       
            if($request->hasFile('pdf')) {

                $filenamewithextension = $request->file('pdf')->getClientOriginalName();
                $extension = $request->file('pdf')->getClientOriginalExtension();
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                //check dir path 
                $path_dir = 'public/file-ebooks';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }
                //Upload File
                $request->file('pdf')->storeAs('public/file-ebooks', $filenametostore);

                // DELETE FILE
                $product_db = Product::find($id);
                $path_dir_old = $path_dir . '/' .$product_db->product_pdf ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }
                $product->product_pdf = $filenametostore;
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

            return response()->json(['success'=>'Item saved successfully.' ]);
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
         //รูปปก
         $product_gallery_photo = ProductGalleryPhoto::where('product_id' , $id)->get();
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
             
         }
        //  if($product->picture){
        //      // DELETE FILE
        //     $path_dir = 'public/book-images/thumbnail';
        //     $path_dir_old_thumbnail = $path_dir . '/' .$product->picture ;
        //     $path_dir_old_full = 'public/book-images/' .$product->picture;
        //     if(Storage::exists($path_dir_old_thumbnail)){
        //         Storage::delete($path_dir_old_thumbnail); 
        //     }
        //     if(Storage::exists($path_dir_old_full)){
        //         Storage::delete($path_dir_old_full);
        //     }
        //  }
        //ไฟล์ 
         if($product->product_pdf){
            // DELETE FILE
           $path_dir = 'public/file-ebooks';
           $path_dir_old = $path_dir . '/' .$product->product_pdf ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }
         }
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
