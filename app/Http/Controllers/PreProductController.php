<?php

namespace App\Http\Controllers;

use App\Product;
use App\BookType;
use App\Publisher;
use App\WaitFiction;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PreProductController extends Controller
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
                $data = DB::table('wait_fiction')->orderBy('created_at' ,'DESC')
                ->select('*')
                ->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('confirm', function($row){     
             
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" class="btn btn-light btn_rounded box_shadow confirmBtn">Confirm</a>';     
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light btn_rounded box_shadow editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
                 return $btn;
            })
            ->rawColumns(["action","confirm"])
            ->make(true);
        }
        //$books = Book::all();
        return view("products.pre-product");
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
        return view("products.add-pre-product" , [
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
        
         $wait_fiction = new WaitFiction();
         $wait_fiction->book_name = $request->book_name;
         $wait_fiction->book_type_id = $request->book_type;
         $wait_fiction->writer = $request->writer;
         $wait_fiction->alias = $request->alias;
         $wait_fiction->price = $request->price;
         $wait_fiction->pages = $request->pages;
         $wait_fiction->book_description = $request->description;
         $wait_fiction->isbn = $request->isbn;
         $wait_fiction->pim_time = $request->pim_time;
         $wait_fiction->pim_year = $request->pim_year;
         $wait_fiction->publisher_id = $request->publisher;
         
         //รูปปก
        if($request->hasFile('name_picture')) {
            //get filename with extension
            $filenamewithextension = $request->file('name_picture')->getClientOriginalName();
    
            //get filename without extension
            //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
            //get file extension
            $extension = $request->file('name_picture')->getClientOriginalExtension();
    
            //filename to store
            //$filenametostore = $filename.'_'.time().'.'.$extension;
            $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
    
            //check dir path 
            $path_dir = 'public/book-images/thumbnail';
            if(!Storage::exists($path_dir)){
                Storage::makeDirectory($path_dir);
            }

            //Upload File
            $path = public_path('storage/book-images/'.$filenametostore);
            $img =   Image::make($request->file('name_picture')->getRealPath())->save($path);
    
            //Resize image here
            // $thumbnailpath = public_path('storage/book-images/thumbnail/'.$filenametostore);
            $thumbnailpath = base_path().'/public/storage/book-images/thumbnail/'.$filenametostore;
            // $photofull = base_path().'/public/storage/book-images/'.$filenametostore;
            $width = 600; // your max width
            $height = 600; // your max height
            $img = Image::make($request->file('name_picture')->getRealPath());
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
            // $img->save($photofull);
            $wait_fiction->picture = $filenametostore;
            
        }
        
        $wait_fiction->save();
        return redirect()->route('preProducts.index');
        
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
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $wait_fiction = WaitFiction::find($id);
        $booktype = BookType::all();
        $publisher = Publisher::all();
        if (!$wait_fiction){
            abort(404);
        }
        // if (!$wait_fiction->toArray()){
        //     abort(404);
        // }
        //DD($product->all());
        return view("products.edit-pre-product" , [
           'booktypes' => $booktype ,
           'publishers' => $publisher,
           'product' => $wait_fiction
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
            $status = null ;
            if($request->fn){
                if($request->fn === "confirm"){
                    $status = 'confirm';
                    $wait_fiction = WaitFiction::find($id);
                    $product = new Product(); 
                    $product->book_name = $wait_fiction->book_name ;
                    $product->book_type_id = $wait_fiction->book_type_id ;
                    $product->writer = $wait_fiction->writer;
                    $product->alias = $wait_fiction->alias ;
                    $product->price = $wait_fiction->price ;
                    $product->pages = $wait_fiction->pages ;
                    $product->book_description = $wait_fiction->book_description;;
                    $product->ISBN = $wait_fiction->isbn ;       
                    $product->pim_time = $wait_fiction->pim_time ;
                    $product->pim_year = $wait_fiction->pim_year ;
                    $product->publisher_id = $wait_fiction->publisher_id ;
                    $product->picture = $wait_fiction->picture ;
                    $product->blame_product ='n';
                    $product->serie_product ='n';
                    $product->buffet ='false';
                    $product->show_blame ='n';
                    $product->stock_total = 0;
                    $product->stock_hold = 0;
                    $product->stock_remain = 0;
                    $product->stock_sold = 0;
                    $product->public_show = "true";
                    $product->can_discount = "true";
                    $product->is_ebook = "false";
                    
                    $product->save();

                    $wait_fiction->delete();

                    return response()->json(['success'=>'Item saved successfully.' , 'fn' => $status ,'product_id' => $product->id]);
                    
                }
                
            }else{

                $wait_fiction = WaitFiction::find($id);
                $wait_fiction->book_name = $request->book_name;
                $wait_fiction->book_type_id = $request->book_type;
                $wait_fiction->writer = $request->writer;
                $wait_fiction->alias = $request->alias;
                $wait_fiction->price = $request->price;
                $wait_fiction->pages = $request->pages;
                $wait_fiction->book_description = $request->description;
                $wait_fiction->isbn = $request->isbn;
                $wait_fiction->pim_time = $request->pim_time;
                $wait_fiction->pim_year = $request->pim_year;
                $wait_fiction->publisher_id = $request->publisher;

                    //รูปปก
                if($request->hasFile('name_picture')) {
                    //get filename with extension
                    $filenamewithextension = $request->file('name_picture')->getClientOriginalName();
            
                    //get filename without extension
                    //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
                    //get file extension
                    $extension = $request->file('name_picture')->getClientOriginalExtension();
            
                    //filename to store
                    //$filenametostore = $filename.'_'.time().'.'.$extension;
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
            
                    //check dir path 
                    $path_dir = 'public/book-images/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }

                    //Upload File
                    $path = public_path('storage/book-images/'.$filenametostore);
                    $img =   Image::make($request->file('name_picture')->getRealPath())->save($path);
            
                    //Resize image here
                    // $thumbnailpath = public_path('storage/book-images/thumbnail/'.$filenametostore);
                    $thumbnailpath = base_path().'/public/storage/book-images/thumbnail/'.$filenametostore;
                    // $photofull = base_path().'/public/storage/book-images/'.$filenametostore;
                    $width = 600; // your max width
                    $height = 600; // your max height
                    $img = Image::make($request->file('name_picture')->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);
                    // $img->save($photofull);

                    // DELETE FILE
                    $product_db = WaitFiction::find($id);
                    $path_dir_old_thumbnail = $path_dir . '/' .$product_db->picture ;
                    $path_dir_old_full = 'public/book-images/' .$product_db->picture;
                    if(Storage::exists($path_dir_old_thumbnail)){
                        Storage::delete($path_dir_old_thumbnail); 
                    }
                    if(Storage::exists($path_dir_old_full)){
                        Storage::delete($path_dir_old_full);
                    }

                    $wait_fiction->picture = $filenametostore;
                    
                }
                $wait_fiction->save();

                return response()->json(['success'=>'Item saved successfully.' , 'fn' => $status ]);

            } 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         $wait_fiction = WaitFiction::find($id);
         //รูปปก
         if($wait_fiction->picture){
             // DELETE FILE
            $path_dir = 'public/book-images/thumbnail';
            $path_dir_old_thumbnail = $path_dir . '/' .$wait_fiction->picture ;
            $path_dir_old_full = 'public/book-images/' .$wait_fiction->picture;
            if(Storage::exists($path_dir_old_thumbnail)){
                Storage::delete($path_dir_old_thumbnail); 
            }
            if(Storage::exists($path_dir_old_full)){
                Storage::delete($path_dir_old_full);
            }
         }
         
         $wait_fiction->delete();
         //return response()->json(['success'=>'Record deleted Successfully.' , 'status' => $product->picture]);
       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
