<?php

namespace App\Http\Controllers;


use App\ProductEbook;
use App\OrderMasEbook;
use App\OrderTranEbook;
use App\TranferEbook;
use App\Tranfer;
use App\ApproveEbook;
use App\User;
use App\BestSellerEbook;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;

class TranferEbookController extends Controller
{
    private $title_index , $fn_index = "";
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
        $data = null;
        if(request()->ajax()) {  
            
            $this->title_index = "Delete to trash";   
            $data = DB::table('ebook_order_payment')->where('public_show' , 'true')
                    ->orWhereNull('public_show')
                    ->orderBy('ebook_order_payment.id' , 'ASC')  
                    ->get(); 
                  
                if(!empty($request->fn) ){
                    if($request->fn === "trash"){
                        $data = DB::table('ebook_order_payment')
                        ->where('public_show','false')
                        ->orderBy('ebook_order_payment.id' , 'DESC')
                        ->get();
                        $this->title_index = "Delete";
                        $this->fn_index = "trash";
                    }                   
                }
            
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "";
                
                if($this->fn_index ==="trash"){
                    
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-id-order="'.$row->order_id.'" data-fn="'.$this->fn_index.'" data-original-title="ReOrder" class="btn btn-primary btn-sm reOrderBtn">Re-PayIn</a>';
                }else{
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="verify" class="btn btn-warning btn-sm verifyBtn">Verify</a>';
                    }
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-fn="'.$this->fn_index.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn">'.$this->title_index.'</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        
        $noti_ebooks = TranferEbook::where('public_show' , 'true')->orWhereNull('public_show')->count();
        $noti_books = Tranfer::where('show_status' , 'y')->orWhereNull('show_status')->count();
        return view('pay-in-slip-ebook.index' ,[
            'noti_ebooks' => $noti_ebooks , 
            'noti_books' => $noti_books , 
        ]);
               
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
       $ebook_order_payment_db = TranferEbook::where('id',$id)->firstOrFail();
        
       $order = DB::table('ebook_order_mas as t1')
       ->select('t1.*' , 't2.*' , 't3.product_name' , 't3.ISBN' , 't1.order_status as order_status_mas',
        't2.order_status as order_status_tran', 't1.approve_status as approve_status_mas' ,)
                ->leftJoin('ebook_order_tran as t2', 't1.id', '=', 't2.order_id')
                ->leftJoin('ebook_product as t3', 't3.id', '=', 't2.product_id')
                ->where('t1.id' ,$ebook_order_payment_db->order_id)
                ->get();
                $quantitys_sum = DB::table('ebook_order_tran')
                     ->select(DB::raw('sum(product_qty) as quantitys_sum'))
                     ->where('order_id', $ebook_order_payment_db->order_id)
                     ->first();
        //DD();
        // DD($order->all());  
        if($ebook_order_payment_db->public_show === 'false'){
            abort(404);
            return redirect('admin/payInSlipEbook');
        }
        if (!$order->toArray() ){
            abort(404);
            return redirect('admin/payInSlipEbook');
        }
        if (!$quantitys_sum->quantitys_sum){
            abort(404);
            return redirect('admin/payInSlipEbook');
        }
        return view('pay-in-slip-ebook.verify-slip' , [
            'tranfer' => $ebook_order_payment_db ,
            'orders' => $order,
            'i' => '0',
            'quantitys_sum' => $quantitys_sum , 
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
        
        if(!empty($request->fn) ){
            if($request->fn === "trash"){
                TranferEbook::find($id)->update([
                    'public_show' => "true",
                ]);
                // OrderMas::find($request->id_order)->update([
                //     'order_status' => "รอตรวจสอบ",
                //     'show_status' => "y",
                // ]);
                
                return response()->json(['success'=>'Item Re-Order successfully.' , 'statusFN' => $request->fn , 'id_order'=> $request->id_order]);
            }else if ($request->fn === "NextStage"){
                $status_next = "";
                $order_status_mas ="";
                $approve_status_mas ="" ;
                $order_status_pay ="" ;
                $public_show_pay ="" ;
                $order_status_tran_approve ="" ;
                switch($request->stagePresent) {
                    case 'p': //รอชำระเงิน
                        $status_next = "y";
                        //-----------------order master---
                        $order_status_mas = "y"; //ชำระเงินแล้ว
                        $approve_status_mas = "y";  //อ่านได้
                        //-----------------payment----
                        $order_status_pay = "y"; //อ่านได้
                        $public_show_pay = "false"; //ไม่แสดง
                        //-----------------tran----
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'c': //รอตรวจสอบ
                        $status_next = "y";
                        //-----------------
                        $order_status_mas = "y"; //ชำระเงินแล้ว
                        $approve_status_mas = "y";  //อ่านได้
                        //-----------------payment----
                        $order_status_pay = "y"; //อ่านได้
                        $public_show_pay = "false"; //ไม่แสดง
                        //-----------------tran----
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'y': //ชำระเงินแล้ว
                        $status_next = "y";
                        //-----------------order master---
                        $order_status_mas = "y"; //ชำระเงินแล้ว
                        $approve_status_mas = "y";  //อ่านได้
                        //-----------------payment----
                        $order_status_pay = "y"; //ชำระเงินแล้ว
                        $public_show_pay = "false"; //ไม่แสดง
                        //-----------------tran----
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    default:
                        $status_next = "-";  
                }
                OrderMasEbook::find($id)->update([
                    'order_status' => $order_status_mas,
                    'paid_date' => date('Y-m-d'),
                    'paid_time' => date('H:i:s')
                ]);
                TranferEbook::find($request->id_tran)->update([
                    'order_status' => $order_status_pay,
                    'approve_date' => date('Y-m-d H:i:s'),
                    'public_show' =>  $public_show_pay
                    
                ]);
                
                $order_trans = OrderTranEbook::where('order_id', $id)->get();
                foreach ($order_trans as $order_tran){
                    BestSellerEbook::create([
                        'product_id'=>$order_tran->product_id ,
                        'post_date'=>date('Y-m-d H:i:s'),
                        'sale_qty'=>$order_tran->product_qty ,
                    ]);
                }
                
        
                $obj = OrderTranEbook::where('order_id', $id)->select(['username','product_id','order_id','id as tran_id',DB::raw("'n' as approve_status"),DB::raw("'".date("Y-m-d H:i:s")."' as approve_date")])->get()->toArray(); //,DB::raw("".date("Y-m-d H:i:s")." as approve_date"
                $array = json_decode(json_encode($obj), true);
                ApproveEbook::insert($array);

                return response()->json(['success'=>'Item Change Status successfully.' ]);
            }else if ($request->fn === "approve_read"){
                $status_next = "";
                $approve_status_mas ="" ;
                $order_status_pay ="" ;
                $order_status_tran_approve ="" ;
                switch($request->stagePresent) {
                    case 'p': //รอชำระเงิน
                        $status_next = "y";
                        //-----------------order master---
                        $approve_status_mas = "y";  //อ่านได้
                        //-----------------tran----
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'c': //รอตรวจสอบ
                        $status_next = "y";
                        //-----------------
                        $approve_status_mas = "y";  //อ่านได้
                        //-----------------tran----
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'y': //ชำระเงินแล้ว
                        $status_next = "y";
                        //-----------------order master---
                        $approve_status_mas = "y";  //อ่านได้
                        //-----------------tran----
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    default:
                        $status_next = "-";  
                }
                OrderMasEbook::find($id)->update([
                    'approve_status' => $approve_status_mas,
                    'approve_date' => date('Y-m-d'),
                    'approve_time' => date('H:i:s')
                ]);
                $order_tran_ebook = OrderTranEbook::where('order_id','=',$id)
                ->update([
                    'order_status' => $order_status_tran_approve ,
                    'approve_date' => date('Y-m-d H:i:s') 
                ]);  
                $obj = OrderTranEbook::where('order_id', $id)->select(['username','product_id','order_id','id as tran_id',DB::raw("'y' as approve_status"),DB::raw("'".date("Y-m-d H:i:s")."' as approve_date")])->get()->toArray(); //,DB::raw("".date("Y-m-d H:i:s")." as approve_date"
                $array = json_decode(json_encode($obj), true);
                ApproveEbook::where('order_id',$id)->update([
                    'approve_status' => 'y' 
                ]);

                return response()->json(['success'=>'Item Change Status successfully.' ]);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
        }
        if(!empty($request->fn) ){
            TranferEbook::find($id)->delete();

            return response()->json(['success'=>'Record deleted Successfully.' , 'status' => $request->fn]);
        }else{
        
          $tr = TranferEbook::find($id)->update([
                'public_show' => "false"
            ]);
            return response()->json(['success'=>'Record Deleted To Trash Successfully.' , 'status' => $request->fn ]);
        }
        
    }
}
