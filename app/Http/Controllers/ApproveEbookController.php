<?php

namespace App\Http\Controllers;

use App\ApproveEbook;
use App\OrderMasEbook;
use App\OrderTranEbook;
use App\OrderMas;
use App\OrderTran;
use App\Tranfer;
use App\TranferEbook;
use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;

class ApproveEbookController extends Controller
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
            $approve_status = '';
            if(!empty($request->status)){
                if($request->status === "wait-approve"){
                    $approve_status = 'n';
                }else if($request->status === "approved"){
                    $approve_status = 'y';
                }else if($request->status === "reject"){
                    $approve_status = 'n';
                }
            }
      
            if($request->status && $request->status != "all"){
                // $data = DB::table('ebook_approve_ebook as t1')
                //     ->leftJoin('order_mas as t2','t1.order_id','t2.id')
                //     ->leftJoin('order_tran as t3','t3.order_id','t2.id')
                //     ->select('t1.*' , 't2.order_status' ,'t3.is_ebook')
                //     ->where('t1.approve_status' , $approve_status)
                //     ->where('t3.is_ebook' , 'true')
                //     ->orderBy('t1.id','DESC')
                //     ->groupBy('t1.order_id')
                //     ->get();
                    $data = OrderMas::whereNotNull('approve_status')
                    ->where('order_status','ชำระเงินแล้ว')
                    ->where('approve_status' , $approve_status);

                    if($request->status === "wait-approve"){
                        $data = $data->whereNull('approve_date')->whereNull('approve_time');
                    }

                    $data = $data->orderBy('order_mas.id','DESC')->get();  
            }else{
                // $data = DB::table('ebook_approve_ebook as t1')
                // ->leftJoin('order_mas as t2','t1.order_id','t2.id')
                // ->leftJoin('order_tran as t3','t3.order_id','t2.id')
                // ->select('t1.*' , 't2.order_status','t3.is_ebook')
                // ->where('t3.is_ebook' , 'true')
                // ->orderBy('t1.id','DESC')
                // ->groupBy('t1.order_id')
                // ->get(); 
                $data = OrderMas::whereNotNull('approve_status')->where('order_status','ชำระเงินแล้ว')->orderBy('order_mas.id','DESC')->get(); 
               
            }
                
            return datatables()->of($data)
            ->addIndexColumn()
            
            ->addColumn('order_status_action', function($row){
                $btn = "";
                switch($row->order_status) {
                    case 'รอชำระเงิน':
                        $btn .= '<span class="badge badge-warning payment-status-wait"><i class="fas fa-circle"></i> '.$row->order_status.'</span>';
                        if($row->reason){
                            $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-content="ส่งกลับ : '.$row->reason.'" data-trigger="hover" data-placement="bottom"> <img src="'.url('img/icon_pages/reback.png').'" alt="" sizes="30" srcset="" ></span>';
                        }    
                        break;
                    case 'รอตรวจสอบ':
                        $btn .= '<h5><span class="badge badge-info payment-status-check"><i class="fas fa-circle"></i> '.$row->order_status.'</span>';
                        $btn .= '</h5>';
                        
                        break;    
                    case 'ส่งกลับแก้ไข':
                        $btn .= '<h5><span class="badge badge-warning ">'.$row->order_status.'</span>';
                        $btn .= '</h5>';
                        
                        break; 
                    case 'ชำระเงินแล้ว':
                        $btn .= '<h5><span class="badge badge-success payment-status-success"><i class="fas fa-circle"></i> '.$row->order_status.'</span></h5>';
                        break;
                    case 'ขอคืนเงิน':
                        $btn .= '<h5><span class="badge badge-dark payment-status-refund"><i class="fas fa-circle"></i> '.$row->order_status.'</span></h5>';
                        break;
                        
                    case 'ส่งสินค้าแล้ว':
                        $btn .= '<h5><span class="badge badge-dark">'.$row->order_status.'</span></h5>';
                        break;
                        
                    case 'ยกเลิก':
                        $btn .= '<h5><span class="badge badge-dark payment-status-cancel"><i class="fas fa-circle"></i> '.$row->order_status.'</span>';
                        if($row->reason){
                            $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-content="หมายเหตุ : '.$row->reason.'" data-trigger="hover" data-placement="bottom"> <img src="'.url('img/icon_pages/icon_cancel.png').'" alt="" sizes="30" srcset="" ></span></h5>';
                        }
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn ;
            })
            ->addColumn('order_approve', function($row){
                $btn = "";       
                switch($row->approve_status) {
                    case 'y': //อนุมัติแล้ว
                        $btn .= '<h5><span class="badge badge-success payment-status-success"><i class="fas fa-circle"></i> อนุมัติแล้ว</span></h5>';
                        // $btn .= '<h5><span class="badge badge-success">อนุมัติแล้ว</span></h5>';
                        break;
                    case 'n': //ไม่อนุมัติ
                        $btn .= '<h5><span class="badge badge-dark payment-status-cancel"><i class="fas fa-circle"></i> ไม่อนุมัติ</span>';
                        // if($row->reason){
                        //     $btn .= '<span class="badge badge-warning payment-status-reback" data-toggle="popover" data-content="ส่งกลับ : '.$row->reason.'" data-trigger="hover" data-placement="bottom"> <img src="'.url('img/icon_pages/reback.png').'" alt="" sizes="30" srcset="" ></span>';
                        // }
                        if(!$row->approve_date && !$row->approve_time){
                            $btn .= '<span class="badge badge-warning approve-status-new spanApprove" data-toggle="popover" data-content="การอนุมัติ E-Book รายการใหม่" data-trigger="hover" data-placement="bottom">N</span></h5>'; 
                        }
                        // $btn .= '<h5><span class="badge badge-danger">ไม่อนุมัติ</span></h5>';
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn ;
            })
            ->addColumn('action', function($row){
                $btn = "";
                // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->order_id.'" data-original-title="Detail" class="edit btn btn-info btn-sm detailBtn">Detail</a>';
                // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->order_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn">Delete</a>';
                
                switch($row->approve_status) {
                    case 'y': //อนุมัติแล้ว
                        $btn .= '<input type="checkbox" class="switchApproveBtn" checked  data-toggle="toggle" data-id="'.$row->id.'" data-style="ios" data-on="" data-off="">';     
                        break;
                    case 'n': //ไม่อนุมัติ                        
                        $btn .= '<input type="checkbox" class="switchApproveBtn" data-toggle="toggle" data-id="'.$row->id.'" data-style="ios" data-on="" data-off="">';                         
                        break;
                    default:
                        $btn .= '-';
                }
                return $btn;
            })
            ->rawColumns(['action'  , 'order_status_action', 'order_approve'])
            ->make(true);
        }
        return view('order-ebook.approve');
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
        $order = DB::table('ebook_approve_ebook as t1')
            ->leftJoin('order_mas as t2','t1.order_id','t2.id')
            ->leftJoin('product as t3','t1.product_id','t3.id')
            ->select('t1.*' ,'t3.book_name' ,'t3.is_ebook','t3.picture')
            ->where('t1.order_id',$id)
            ->where('t3.is_ebook' , 'true')
            ->orderBy('t1.id','DESC')
            ->get(); 
        if (!$order->toArray()){
            abort(404);
        }
        return view('order-ebook.detail-approve' , [
            'orders' => $order,
            'i' => '0',
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
            if($request->has('fn')){
                if($request->fn === "fnApproveEbook"){

                    if($request->value === "On"){
                        $switch_status = 'y';
                    }else if($request->value === "Off"){
                        $switch_status = 'n';
                    }
                    
                    ApproveEbook::where('order_id',$id)->update([
                        'approve_status' => $switch_status ,
                        'approve_date'=>date('Y-m-d H:i:s')
                    ]);
                    OrderMas::find($id)->update([
                        'approve_status'=>$switch_status,
                        'approve_date'=>date('Y-m-d'),
                        'approve_time'=>date('H:i:s'),
                    ]);
                    OrderTran::where('order_id',$id)->update([
                        'approve_status' => $switch_status ,
                        'approve_date' => date('Y-m-d H:i:s') 
                    ]);  
                    return response()->json(['success'=>'Item saved successfully.' ]);
                }

            }
        }
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
        $approve_ebook =  ApproveEbook::where('order_id',$id)->delete();

        return response()->json(['success'=>'Record deleted Successfully.']);
       
    }
}
