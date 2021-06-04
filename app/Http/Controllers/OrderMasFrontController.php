<?php

namespace App\Http\Controllers;

use App\OrderMas;
use App\Tranfer;
use App\Publisher;
use App\OrderTran;
use App\Payment;
use App\ImageSlip;
use App\User;
use App\Product;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class OrderMasFrontController extends Controller
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
    public function index(Request $request )
    {
        $user = null ;
        if (Auth::check()) {
            $user = Auth::user();
        }
        $publishers = Publisher::all();
        $payments = Payment::all();
        if(request()->ajax()) {
                // $data = OrderMas::where('user_id',$user->id)->orderBy('created_at','DESC')->get();
                $data = OrderMas::with(['getTranfer'])
                ->where('user_id',$user->id)
                ->orderBy('created_at','DESC')
                ->get(); 

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('order_status', function($row){
                $btn = '<div class="">';            
                switch($row->order_status) {
                    case 'รอชำระเงิน':
                        $btn .= '<h5><span class="badge badge-warning">'.$row->order_status.'</span>';                        
                        break;
                    case 'รอตรวจสอบ':
                        $btn .= '<h5><span class="badge badge-info" data-toggle="popover" data-placement="top" data-content="กำลังดำเนินการตรวจสอบข้อมูลที่แจ้งมาค่ะ" data-trigger="hover">'.$row->order_status.'</span>';                        
                        break;
                    case 'ชำระเงินแล้ว':
                        $btn .= '<h5><span class="badge badge-success" data-toggle="popover" data-placement="top" data-content="ยืนยันการชำระเงินแล้วค่ะ" data-trigger="hover">'.$row->order_status.'</span></h5>';
                        break;
                    case 'ส่งสินค้าแล้ว':
                        $btn .= '<h5><span class="badge badge-dark">'.$row->order_status.'</span></h5>';
                        break;
                    case 'ส่งกลับแก้ไข':
                        $btn .= '<h5><span class="badge badge-warning" data-toggle="popover" data-content="'.$row->getTranfer->reason.'" data-trigger="hover" title="คำแนะนำ">'.$row->order_status.'</span></h5>';
                    //     $btn .= '<h5><span class="badge badge-warning" >'.$row->order_status.'</span></h5>';
                        
                    //     $btn .= '<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
                    //     Tooltip on top
                    //   </button>';
                        break;
                    case 'ยกเลิก':
                        $btn .= '<h5><span class="badge badge-dark" data-toggle="popover" data-content="'.$row->reason.'" data-trigger="hover" title="เหตุผล">'.$row->order_status.'</span></h5>';
                        break;
                    default:
                        $btn .= '-';
                        
                }
                $btn .= '</div>';
                return $btn ;
            })
            ->addColumn('action', function($row){
                $disable_pay_in_btn = '';
                if($row->order_status === "รอตรวจสอบ" || $row->order_status === "ชำระเงินแล้ว" || $row->order_status === "ส่งสินค้าแล้ว" || $row->order_status === "ยกเลิก"){
                    $disable_pay_in_btn='disabled';
                }
                $disable_del_btn = '';
                if($row->order_status === "รอตรวจสอบ" || $row->order_status === "ชำระเงินแล้ว" || $row->order_status === "ส่งสินค้าแล้ว" || $row->order_status === "ยกเลิก"){
                    $disable_del_btn='disabled';
                }
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-price="'.($row->net_price + $row->transport_rate).'" data-tranfer-id="'.($row->getTranfer->id ?? '').'" data-original-title="Edit" class="edit btn btn-warning btn-sm '.$disable_pay_in_btn.' pay-in-btn">แจ้งชำระเงิน</a>';

                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm detailBtn"><i class="fas fa-search-plus"></i></a>';

                $btn .=' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm '.$disable_del_btn.' deleteBtn">ยกเลิก</a>';
                return $btn;
            })
            ->rawColumns(['action' ,'order_status'])
            ->make(true);
        }
        return view('front-end.order' , [
            'publishers' => $publishers ,
            'payments' => $payments ,
            'user' => $user ,
        ]);
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
        // if($request->hasFile('images')) {
        //     // $filepond = app(Sopamo\LaravelFilepond\Filepond::class);
        //     // $path = $filepond->getPathFromServerId($serverId);
        //     return response()->json(['success'=>'Added new records.' ,'val'=>'1', 'request' => $request->file('images')]);
        // }
        
        //  return response()->json(['success'=>'Added new records.' , 'request' => "123"]);
        $validator = Validator::make($request->all(), [
            'tranfer_date' => 'required',
            'tranfer_time' => 'required',
            'amount' => 'required',
            'bank_tranfer' => ['required'],
            'images' => 'required',
            'images.*' => ['image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
        ]); 
        if ($validator->passes()) {
            $tranfer = new Tranfer();
            $tranfer->account_tranfer = $request->account_tranfer;
            $tranfer->tranfer_date = $request->tranfer_date;
            $tranfer->tranfer_time = $request->tranfer_time;
            $tranfer->inform_date  =    date('Y-m-d H:i:s') ;
            $tranfer->amount = $request->amount;
            $tranfer->bank_tranfer   = $request->bank_tranfer;
            $tranfer->remark1 =   $request->remark1;
            $tranfer->tranfer_status = "รอตรวจสอบ";
               
            $tranfer->username = $request->username ; 
            $tranfer->show_status = 'y';
             //image
            if($request->hasFile('images')) {
                foreach($request->file('images') as $file)
                {
                    $filenamewithextension = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                    //check dir path 
                    $path_dir = 'public/slip-images/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
                    //Upload File
                    $path = public_path('storage/slip-images/'.$filenametostore);
                    $img =   Image::make($file->getRealPath())->save($path);
                    //Resize image here
                    // $thumbnailpath = public_path('storage/slip-images/thumbnail/'.$filenametostore);
                    $thumbnailpath = base_path().'/public/storage/slip-images/thumbnail/'.$filenametostore;
                    $photofull = base_path().'/public/storage/slip-images/'.$filenametostore;
                    $width = 500; // your max width
                    $height = 500; // your max height
                    $img = Image::make($file->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);
                    // $img->save($photofull);

                    ImageSlip::create([
                        'order_id' => $request->account_tranfer,
                        'filename' => $filenametostore
                    ]);
                }
                

                // $tranfer->attach_slip = $filenametostore;
            
            }
            
            $tranfer->save();
            OrderMas::find($request->account_tranfer)->update([ 
                'order_status' => "รอตรวจสอบ",
            ]);
            ;
            return response()->json(['success'=>'Added new records.' ]);
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
        //$user = null;
        $tranfer_db = Tranfer::where('id',$id)->first();
        $publishers = Publisher::all();
        $payments = Payment::all();

        $order = OrderMas::with(['getProduct','getOrderTran' => function($query){
            $query->where('order_tran.is_ebook' ,'=' , 'false');
            $query->where('product.buffet', '!=' , 'true');
        }])->where('id' ,$id)
        ->first();
        

        $order_ebook = OrderMas::with(['getProduct','getOrderTran' => function($query){
            $query->where('order_tran.is_ebook' ,'=' , 'true');
        }])->where('id' ,$id)
        ->first();

        $order_buffet = OrderMas::with(['getProduct','getOrderTran' => function($query){
            $query->where('order_tran.is_ebook' ,'=' , 'false');
            $query->where('product.buffet' ,'=', 'true');
        }])->where('id' ,$id)        
        ->first();
   
                 $quantitys_sum = OrderTran::select(DB::raw('sum(quantitys) as quantitys_sum'))
                      ->where('order_id', $id)
                      ->first();

         
         if (empty($order->toArray()) && empty($order_buffet->toArray()) && empty($order_ebook->toArray())){
             abort(404);
         }

         if(!empty($order_ebook->toArray())){
            $user = User::find($order_ebook->user_id);
         }
        if(!empty($order->toArray())){
            $user = User::find($order->user_id);
         }
         if(!empty($order_buffet->toArray())){
            $user = User::find($order_buffet->user_id);
         }

         if (empty($quantitys_sum->quantitys_sum)){
             abort(404);
         }
        //  DD($order);
 
         return view('front-end.orderDetail' , [
             'orders' => $order,
             'order_ebooks' => $order_ebook,
             'i' => '0',
             'sum_qua' => '0',
             'sum_net' => '0',
             'quantitys_sum' => $quantitys_sum ,
             'user' => $user ,
             'publishers' => $publishers ,
             'payments' => $payments ,
             'order_buffets' => $order_buffet ,
             
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
        if(request()->ajax()) {
            $validator = Validator::make($request->all(), [
                'tranfer_date' => 'required',
                'tranfer_time' => 'required',
                'amount' => 'required',
                'bank_tranfer' => ['required'],
                'images' => 'required',
                'images.*' => ['image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
            ]); 
            if ($validator->passes()) {
                $tranfer = Tranfer::find($id);
                $tranfer->account_tranfer = $request->account_tranfer;
                $tranfer->tranfer_date = $request->tranfer_date;
                $tranfer->tranfer_time = $request->tranfer_time;
                $tranfer->inform_date  =    date('Y-m-d H:i:s') ;
                $tranfer->amount = $request->amount;
                $tranfer->bank_tranfer   = $request->bank_tranfer;
                $tranfer->remark1 =   $request->remark1;
                $tranfer->tranfer_status = "รอตรวจสอบ";
                   
                $tranfer->username = $request->username ; 
                $tranfer->show_status = 'y';
                 //image
                if($request->hasFile('images')) {
                    foreach($request->file('images') as $file)
                    {
                        $filenamewithextension = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                        //check dir path 
                        $path_dir = 'public/slip-images/thumbnail';
                        if(!Storage::exists($path_dir)){
                            Storage::makeDirectory($path_dir);
                        }
                        //Upload File
                        $path = public_path('storage/slip-images/'.$filenametostore);
                        $img =   Image::make($file->getRealPath())->save($path);

                        //Resize image here
                        // $thumbnailpath = public_path('storage/slip-images/thumbnail/'.$filenametostore);
                        $thumbnailpath = base_path().'/public/storage/slip-images/thumbnail/'.$filenametostore;
                        // $photofull = base_path().'/public/storage/slip-images/'.$filenametostore;
                        $width = 500; // your max width
                        $height = 500; // your max height
                        $img = Image::make($file->getRealPath());
                        $img->height() > $img->width() ? $width=null : $height=null;
                        $img->resize($width, $height, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        $img->save($thumbnailpath);
                        // $img->save($photofull);
    
                        ImageSlip::create([
                            'order_id' => $request->account_tranfer,
                            'filename' => $filenametostore
                        ]);
                    }

                }
                
                $tranfer->save();
                OrderMas::find($request->account_tranfer)->update([ 
                    'order_status' => "รอตรวจสอบ",
                ]);
                ;
                return response()->json(['success'=>'Added new records.' ]);
            }
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        // DD($id);
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

    //      OrderMas::find($id)->delete();
    //    $order_tran = OrderTran::where('order_id',$id )->delete();

    //    $tranfer =  Tranfer::where('account_tranfer',$id)->first();
    //         if(!empty($tranfer)){
    //             $image_slip = ImageSlip::where('order_id',$id)->get();
                
    //             if(!empty($image_slip)){
    //                 foreach($image_slip as $slip){
    //                     $path_dir = 'public/slip-images/thumbnail';
    //                     $path_dir_old_thumbnail = $path_dir . '/' .$slip->filename ;
    //                     $path_dir_old_full = 'public/slip-images/' .$slip->filename;
    //                     if(Storage::exists($path_dir_old_thumbnail)){
    //                         Storage::delete($path_dir_old_thumbnail); 
    //                     }
    //                     if(Storage::exists($path_dir_old_full)){
    //                         Storage::delete($path_dir_old_full);
    //                     }
    //                     $slip->delete(); 
    //                 }
                    
    //             }
    //             $tranfer->delete();
    //         }
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
                //     'show_status' => "n",
                //     'order_status' => "ยกเลิก",
                // ]);
            }
        }
        OrderMas::updateOrCreate(['id' => $id],[
            'show_status' => "n",
            'order_status' => "ยกเลิก",
        ]);
        

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
