<?php

namespace App\Http\Controllers;

use App\OrderMasEbook;
use App\OrderTranEbook;
use App\TranferEbook;
use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;

class OrderMasEbookController extends Controller
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
            $data = null;
            $status_text = '';
            $status_order = '';
            if(!empty($request->status)){
                if($request->status === "wait-for-pay"){
                    $status_text = 'รอชำระเงิน';
                    $status_order = 'p';
                }else if($request->status === "paid"){
                    $status_text = 'ชำระเงินแล้ว';
                    $status_order = 'y';
                }
            }
            if($request->status){
                $data = DB::table('ebook_order_mas')
                    ->where('order_status' , $status_order)
                    ->orderBy('id','DESC')
                    ->get(); 
            }else{
                $data = DB::table('ebook_order_mas')
                ->orderBy('id','DESC')
                ->get(); 
            }
                
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('order_approve', function($row){
                $btn = "";       
                switch($row->approve_status) {
                    case 'y': //ชำระเงินแล้ว
                        $btn .= '<h5><span class="badge badge-success">อนุมัติการอ่าน</span></h5>';
                        break;
                    case 'n': //ยังไม่ชำระเงิน
                        $btn .= '<h5><span class="badge badge-dark">รออนุมัติ</span></h5>';
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn ;
            })
            ->addColumn('order_status', function($row){
                $btn = "";                         
                switch($row->order_status) {
                    case 'p': //รอชำระเงิน
                        $btn .= '<h5><span class="badge badge-warning">รอชำระเงิน</span></h5>';
                        break;
                    case 'c': //รอตรวจสอบ
                        $btn .= '<h5><span class="badge badge-info">รอตรวจสอบ</span></h5>';
                        break;    
                    case 'y': //ชำระเงินแล้ว
                        $btn .= '<h5><span class="badge badge-success">ชำระเงินแล้ว</span></h5>';
                        break;
                    case 'n': //ยังไม่ชำระเงิน
                        $btn .= '<h5><span class="badge badge-dark">ยังไม่ชำระเงิน</span></h5>';
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn ;
            })
            ->addColumn('action', function($row){
                $btn = "";
                
                // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-fn="NextStage" data-val="'.$row->order_status.'" data-original-title="NEXT STAGE" class="edit btn btn-warning btn-sm changeStatusBtn">NEXT STAGE</a>';
            
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Detail" class="edit btn btn-info btn-sm detailBtn">Detail</a>';
                
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'  , 'order_status', 'order_approve'])
            ->make(true);
        }
        return view('order-ebook.index');
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
    public function show($id)
    {
        // $tranfer_db = DB::table('ebook_order_tran')->where('id',$id)->first();
        
        
       $order = DB::table('ebook_order_mas as t1')
       ->select('t1.*' , 't2.*' , 't3.product_name')
                ->leftJoin('ebook_order_tran as t2', 't1.id', '=', 't2.order_id')
                ->leftJoin('ebook_product as t3', 't3.id', '=', 't2.product_id')
                ->where('t1.id' ,$id)
                ->get();
                $quantitys_sum = DB::table('ebook_order_tran')
                     ->select(DB::raw('sum(product_qty) as quantitys_sum'))
                     ->where('order_id', $id)
                     ->first();

                   
        
        if (!$order->toArray()){
            abort(404);
        }
        if (!$quantitys_sum->quantitys_sum){
            abort(404);
        }

        return view('order-ebook.detail' , [
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
        }
            $tranfer =  TranferEbook::where('order_id',$id)->first();
            if(!empty($tranfer)){
                $tranfer->delete();
            }
           $order_mas = OrderMasEbook::find($id)->delete();

           OrderTranEbook::where('order_id',$id)->delete(); 

            return response()->json(['success'=>'Record deleted Successfully.']);
       
    }
}
