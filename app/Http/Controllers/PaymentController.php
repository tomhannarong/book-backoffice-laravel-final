<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PaymentController extends Controller
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
    public function index()
    {
        if(request()->ajax()) {
            $data = DB::table('payment')->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light box_shadow btn_rounded editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light box_shadow btn_rounded deleteBtn">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('payment');
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
        if(request()->ajax()) {
            if($request->fn){
                if($request->fn == "upload_image_detail"){
                    $file = request()->file('file') ;
                    $filenamewithextension = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                    //check dir path 
                    $path_dir = 'public/payment-des-images';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
                    //Resize image here
                    $thumbnailpath = base_path().'/public/storage/payment-des-images/'.$filenametostore;
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
                    return response()->json(['location'=>  asset('storage/payment-des-images/'.$filenametostore) ]);

                }                
            }
        }

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
        ]);

        if ($validator->passes()) {
            $payment = Payment::create([
                'payment' => $request->name,
                'payment_description' => $request->description
            ]);
            return response()->json(['success'=>'Added new records.' , 'name' => $payment->payment ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
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
        $payment = Payment::find($id);
        return response()->json($payment);
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
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
        ]);
        //return("id:".$id."id:".$request->id."code:".$request->code);
        if ($validator->passes()) {
            //1 วิธี
            $payment = Payment::updateOrCreate(['id' => $id],[
                'payment' => $request->name,
                'payment_description' => $request->description
            ]);
            return response()->json(['success'=>'Item saved successfully.' , 'name' => $payment->payment]);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
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
         Payment::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
