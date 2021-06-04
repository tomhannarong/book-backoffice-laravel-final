<?php

namespace App\Http\Controllers;



use App\Publisher;
use App\Payment;
use App\User;
use App\OrderMasEbook;
use App\OrderTranEbook;
use App\TranferEbook;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderMasFrontEbookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request )
    {
        $user = null ;
        if (Auth::check()) {
            $user = Auth::user();
        }
        $publishers = Publisher::all();
        $payments = Payment::all();
        if(request()->ajax()) {
                $data = DB::table('ebook_order_mas')->where('username',$user->username)->orderBy('id','DESC')->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('order_status', function($row){
                $btn = "";            
                switch($row->order_status) {
                    case 'p':
                        $btn .= '<h5><span class="badge badge-warning">รอชำระเงิน</span>';                        
                        break;
                    case 'c':
                        $btn .= '<h5><span class="badge badge-info">รอตรวจสอบ</span>';                        
                        break;
                    case 'y':
                        $btn .= '<h5><span class="badge badge-success">ชำระเงินแล้ว</span></h5>';
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn ;
            })
            ->addColumn('approve_status', function($row){
                $btn = "";            
                switch($row->approve_status) {
                    case 'y':
                        $btn .= '<h5><span class="badge badge-success">อนุมัติอ่านแล้ว</span>';                        
                        break;
                    case 'n':
                        $btn .= '<h5><span class="badge badge-dark">รอการอนุมัติ</span>';                        
                        break;
                    default:
                    $btn .= '<h5><span class="badge badge-dark">รอการอนุมัติ</span>';  
                }
                return $btn ;
            })
            ->addColumn('action', function($row){
                $disable_pay_in_btn = '';
                if($row->order_status === "c" || $row->order_status === "y"){ //รอตรวจสอบ //ชำระเงินแล้ว
                    $disable_pay_in_btn='disabled';
                }
                $disable_del_btn = '';
                if($row->order_status === "y"){ //ชำระเงินแล้ว 
                    $disable_del_btn='disabled';
                }
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm '.$disable_pay_in_btn.' pay-in-btn">แจ้งชำระเงิน</a>';

                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm detailBtn"><i class="fas fa-search-plus"></i></a>';

                $btn .=' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm '.$disable_del_btn.' deleteBtn">ยกเลิก</a>';
                return $btn;
            })
            ->rawColumns(['action' ,'order_status','approve_status'])
            ->make(true);
        }
        return view('front-end-ebook.order' , [
            'publishers' => $publishers ,
            'payments' => $payments ,
            'user' => $user ,
        ]);
    }

    public function store(Request $request)
    {
        //  return response()->json(['success'=>'Added new records.' , 'request' => $request->all()]);
        $validator = Validator::make($request->all(), [
            'tranfer_date' => 'required',
            'tranfer_time' => 'required',
            'amount' => 'required',
            'bank_tranfer' => ['required'],
            'imgInp' => [ 'required', 'image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
        ]); 
        if ($validator->passes()) {
            $tranfer = new TranferEbook();
            $tranfer->order_id = $request->account_tranfer;
            $tranfer->username_customer = $request->username ; 
            $tranfer->total_order = $request->amount;
            $tranfer->bank_datetime = $request->tranfer_date.' '.$request->tranfer_time ;
            $tranfer->remark1 = $request->remark1 ;
            $tranfer->order_status = "c";
            $tranfer->post_date = date('Y-m-d H:i:s') ;
            $tranfer->public_show  = "true" ;
            $tranfer->bank   = $request->bank_tranfer;
               
             //image
            if($request->hasFile('imgInp')) {
                $filenamewithextension = $request->file('imgInp')->getClientOriginalName();
                $extension = $request->file('imgInp')->getClientOriginalExtension();
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                //check dir path 
                $path_dir = 'public/slip-images/thumbnail';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }
                //Upload File
                $path = public_path('storage/slip-images/'.$filenametostore);
                $img =   Image::make($request->file('imgInp')->getRealPath())->save($path);
        
                //Resize image here
                // $thumbnailpath = public_path('storage/slip-images/thumbnail/'.$filenametostore);
                $thumbnailpath = base_path().'/public/storage/slip-images/thumbnail/'.$filenametostore;
                    // $photofull = base_path().'/public/storage/slip-images/'.$filenametostore;
                $width = 500; // your max width
                $height = 500; // your max height
                $img = Image::make($request->file('imgInp')->getRealPath());
                $img->height() > $img->width() ? $width=null : $height=null;
                $img->resize($width, $height, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);
                // $img->save($photofull);

                $tranfer->file1 = $filenametostore;  
            }
            
            $tranfer->save();
            OrderMasEbook::find($request->account_tranfer)->update([ 
                'order_status' => "c",
            ]);
            
            return response()->json(['success'=>'Added new records.' ]);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function show($id)
    {
        $user = null ;
        if (Auth::check()) {
            $user = Auth::user();
        }
        $tranfer_db = DB::table('ebook_order_payment')->where('id',$id)->first();
        $publishers = Publisher::all();
        $payments = Payment::all();
        
        
        $order = DB::table('ebook_order_mas as t1')
        ->select('t1.*' , 't2.*' , 't3.product_name' ,'t1.order_status as order_status_mas' ,'t2.order_status as order_status_tran' )
                 ->leftJoin('ebook_order_tran as t2', 't1.id', '=', 't2.order_id')
                 ->leftJoin('ebook_product as t3', 't3.id', '=', 't2.product_id')
                 ->where('t1.id' ,$id)
                 ->get();

        
                 $quantitys_sum = DB::table('ebook_order_tran')
                      ->select(DB::raw('sum(product_qty) as quantitys_sum'))
                      ->where('order_id', $id)
                      ->first();

        //  DD($order->all());
         if (!$order->toArray()){
             abort(404);
         }
        //  if(!empty($order->toArray()[0]->user_id)){
        //     //DD("456");
        //     $user = User::find($order->toArray()[0]->user_id);
            
        //  }
 
         if (!$quantitys_sum->quantitys_sum){
             abort(404);
             return redirect('order');
         }
         //DD($user->id);
 
         return view('front-end-ebook.orderDetail' , [
             'orders' => $order,
             'i' => '0',
             'quantitys_sum' => $quantitys_sum ,
            //  'user' => $user ,
             'publishers' => $publishers ,
             'payments' => $payments ,
             'user' => $user ,
             
         ]);
    }

    public function destroy($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }

         OrderMasEbook::find($id)->delete();
       $order_tran = OrderTranEbook::where('order_id',$id )->delete();

       $tranfer =  TranferEbook::where('order_id',$id)->first();
            if(!empty($tranfer)){
                $tranfer->delete();
               // return response()->json(['success'=>'0000000000000'  ]);
            }

       

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
