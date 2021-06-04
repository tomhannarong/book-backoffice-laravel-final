<?php

namespace App\Http\Controllers;

use App\OrderMas;
use App\OrderTran;
use App\Tranfer;
use App\TranferEbook;
use App\Product;
use App\BestSellerEbook;
use App\ApproveEbook;
use App\OrderHistory;
use App\OrderSendback;

use Illuminate\Support\Arr;

use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
class TranferController extends Controller
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
        if(request()->ajax()) {  
            $data = null;
            $this->title_index = "Delete to trash";   
            $data = DB::table('tranfer')->where('show_status' , 'y')
                    ->orWhereNull('show_status')
                    ->orderBy('tranfer.created_at' , 'ASC')  
                    ->get(); 
                  
                if(!empty($request->fn) ){
                    if($request->fn === "trash"){
                        $data = Tranfer::where('show_status','n')
                        ->orderBy('tranfer.updated_at' , 'DESC')
                        ->get();
                        $this->title_index = "Delete";
                        $this->fn_index = "trash";
                    }  
                    if($request->fn === "success"){
                        $data = Tranfer::where('show_status','n')->where('tranfer_status','ชำระเงินแล้ว')
                        ->orderBy('tranfer.updated_at' , 'DESC')
                        ->get();
                        // $this->title_index = "Delete";
                        $this->fn_index = "trash";
                    }    
                    if($request->fn === "check"){
                        $data = Tranfer::where('show_status','y')->where('tranfer_status','รอตรวจสอบ')
                        ->orderBy('tranfer.updated_at' , 'DESC')
                        ->get();
                    }  
                                  
                }
            
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('status', function($row){
                $btn = '<div class="text-center">';
                if($row->tranfer_status == "ชำระเงินแล้ว"){
                    $btn .= '<h5><span class="badge badge-success" >'.$row->tranfer_status.'</span></h5>';
                }elseif($row->tranfer_status == "ส่งกลับแก้ไข"){
                    $btn .= '<h5><span class="badge badge-warning" >'.$row->tranfer_status.'</span></h5>';
                }elseif($row->tranfer_status == "รอตรวจสอบ"){
                    $btn .= '<h5><span class="badge badge-info" >'.$row->tranfer_status.'</span></h5>';
                }else{
                    $btn .= '-';
                }
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('action', function($row){
                $btn = '<div class="text-center">';
                if($this->fn_index ==="trash"){
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="verify" class="btn btn-warning btn-sm verifyBtn">Verify</a>';
                
                    // $btn .= ' <a href="javascript:void(0)" data-toggle="popover" data-placement="top" data-content="กลับไปสถานะรอตรวจสอบ" data-trigger="hover"  data-id="'.$row->id.'" data-id-order="'.$row->account_tranfer.'" data-fn="'.$this->fn_index.'" class="btn btn-primary btn-sm reOrderBtn">Re-PayIn</a>';
                }else{
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="verify" class="btn btn-warning btn-sm verifyBtn">Verify</a>';
                }
                $btn .= '</div>';
                // $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-fn="'.$this->fn_index.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn">'.$this->title_index.'</a>';
                return $btn;
            })
            ->rawColumns(['action' ,'status'])
            ->make(true);
        }
        $noti_ebooks = TranferEbook::where('public_show' , 'true')->orWhereNull('public_show')->count();
        $noti_books = Tranfer::where('show_status' , 'y')->orWhereNull('show_status')->count();
        return view('pay-in-slip.index' ,[
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
       $tranfer_db = Tranfer::select('*', 'tranfer.id as tranfer_id')->leftJoin('image_slips','image_slips.order_id','tranfer.account_tranfer')->where('tranfer.id',$id)->get();
       
    //    DD($tranfer_db);
    //     $tranfer_db = Tranfer::with(['getImageSlip' => function($query){
    //         // $query->where('image_slips.order_id','tranfer.account_tranfer');
    //     }])->where('id' ,$id)
    //     ->firstOrFail();

        $order = OrderMas::with(['getProduct','getOrderTran' => function($query){
            $query->where('order_tran.is_ebook' ,'=' , 'false');
            $query->where('product.buffet', '!=' , 'true');
        }])->where('id' ,$tranfer_db[0]->account_tranfer)->firstOrFail();
        
        
        
        $order_ebook = OrderMas::with(['getProduct','getOrderTran' => function($query){
            $query->where('order_tran.is_ebook' ,'=' , 'true');
        }])->where('id' ,$tranfer_db[0]->account_tranfer)->firstOrFail();
        

        $order_buffet = OrderMas::with(['getProduct','getOrderTran' => function($query){
            $query->where('order_tran.is_ebook' ,'=' , 'false');
            $query->where('product.buffet' ,'=', 'true');
        }])->where('id' ,$tranfer_db[0]->account_tranfer)->firstOrFail();      
        

    //    $order = DB::table('order_mas as t1')
    //    ->select('t1.*' , 't2.*' , 't3.book_name' , 't3.ISBN', 't1.username as username')
                // ->leftJoin('order_tran as t2', 't1.id', '=', 't2.order_id')
                // ->leftJoin('product as t3', 't3.id', '=', 't2.book_id')
                // ->where('t1.id' ,$tranfer_db->account_tranfer)
                // ->where('t3.buffet' ,'<>', 'true')
                // ->where('t3.is_ebook' ,'=' , 'false')
                // ->get();
    //     $order_ebook = DB::table('order_mas as t1')
    //    ->select('t1.*' , 't2.*' , 't3.book_name' , 't3.ISBN' , 't1.username as username')
    //             ->leftJoin('order_tran as t2', 't1.id', '=', 't2.order_id')
    //             ->leftJoin('product as t3', 't3.id', '=', 't2.book_id')
    //             ->where('t1.id' ,$tranfer_db->account_tranfer)
    //             ->where('t3.buffet' ,'<>', 'true')
    //             ->where('t3.is_ebook' ,'=' , 'true')
    //             ->get();
    //    $order_buffet = DB::table('order_mas as t1')
    //    ->select('t1.*' , 't2.*' , 't3.book_name' , 't3.ISBN', 't1.username as username')
    //             ->leftJoin('order_tran as t2', 't1.id', '=', 't2.order_id')
    //             ->leftJoin('product as t3', 't3.id', '=', 't2.book_id')
    //             ->where('t1.id' ,$tranfer_db->account_tranfer)
    //             ->where('t3.buffet' ,'=', 'true')
    //             ->where('t3.is_ebook' ,'=' , 'false')
    //             ->get();

        
                $quantitys_sum = OrderTran::where('order_tran.order_id', $tranfer_db[0]->account_tranfer)
                     ->select(DB::raw('sum(order_tran.quantitys) as quantitys_sum'))
                     ->firstOrFail();
        //DD();
        // if($tranfer_db[0]->show_status === 'n'){
        //     return redirect('admin/payInSlip');
        // }
        if (empty($order->toArray()) && empty($order_buffet->toArray()) && empty($order_ebook->toArray())){
            abort(404);
        }
        if (empty($quantitys_sum->quantitys_sum)){
            abort(404);
        }
        //DD($quantitys_sum);

        return view('pay-in-slip.verify-slip' , [
            'tranfer' => $tranfer_db ,
            'orders' => $order,
            'order_ebooks' => $order_ebook,
            'i' => '0',
            'quantitys_sum' => $quantitys_sum , 
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
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $tranfer = Tranfer::find($id);
        return response()->json($tranfer);
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
                Tranfer::find($id)->update([
                    'show_status' => "y",
                    'tranfer_status' => "รอตรวจสอบ",
                ]);
                OrderMas::find($request->id_order)->update([
                    'order_status' => "รอตรวจสอบ",
                    'show_status' => "y",
                ]);
                
                return response()->json(['success'=>'Item Re-Order successfully.' , 'statusFN' => $request->fn , 'id_order'=> $request->id_order]);
            }else if ($request->fn === "NextStage"){

                $av_book = 'false'; // dont have book 
                $av_ebook = 'false';// dont have ebook 
                
                $tmp_carts = OrderTran::select('*')->selectRaw('SUM(order_tran.quantitys) AS sum_quantity')
                ->where('order_tran.order_id' , $id)
                ->groupBy('order_tran.book_id')     
                ->get(); 
                $is_ebook = in_array("true", Arr::pluck($tmp_carts, 'is_ebook')) ;
                $is_book = in_array("false", Arr::pluck($tmp_carts, 'is_ebook')) ;


                foreach($tmp_carts as $tmp_cart){
                    
                    $product = Product::where('id',$tmp_cart->book_id)->where('is_ebook',"false")->first();
                    if(!empty($product)){
                        $total_stock = $product->stock - $tmp_cart->sum_quantity; // สินค้าคงคลัง -
                        $stock_sold = $product->stock_sold + $tmp_cart->sum_quantity; //สินค้าขายแล้ว + 
                        $stock_hold = $product->stock_hold - $tmp_cart->sum_quantity; //สินค้าติดจอง -
                        // $stock_remain = $product->stock_remain - $tmp_cart->sum_quantity; //สินค้าพร้อมขาย -
                        $product->update([
                            'stock'=> $total_stock ,
                            'stock_sold' => $stock_sold ,
                            'stock_hold' => $stock_hold ,
                            // 'stock_remain' => $stock_remain ,
                        ]);   
                        $av_book = 'true'; //have a book 
                        
                    }
                    $product_ebook = Product::where('id',$tmp_cart->book_id)->where('is_ebook',"true")->first();
                    if(!empty($product_ebook)){
                        $total_sell = $tmp_cart->sum_quantity + $product_ebook->stock_sold ;
                        $product_ebook->update([
                            'stock_sold' => $total_sell ,
                        ]);  
                        $av_ebook = 'true'; //have a ebook 
                    }
                    
                }
                //return response()->json(['success'=>'Item Change Status successfully.' , 'val' => $tmp_carts->all()]);

                $status_next = "";
                $status_tran_show ="";
                $status_mas_show ="" ;
                switch($request->stagePresent) {
                    case 'รอชำระเงิน':
                        $status_next = "ชำระเงินแล้ว";
                        $status_mas_show = "y";
                        $status_tran_show = "n";
                        //return '<h5><span class="badge badge-warning">'+data.order_status+'</span></h5>';
                        break;
                    case 'รอตรวจสอบ':
                        $status_next = "ชำระเงินแล้ว";
                        $status_mas_show = "y";
                        $status_tran_show = "n";
                        //return '<h5><span class="badge badge-warning">'+data.order_status+'</span></h5>';
                        break;
                    case 'ชำระเงินแล้ว':
                        $status_next = "ส่งสินค้าแล้ว";
                        $status_mas_show = "n";
                        $status_tran_show = "n";
                        //return '<h5><span class="badge badge-success">'+data.order_status+'</span></h5>';
                        break;
                    case 'ส่งสินค้าแล้ว':
                        $status_next = "ส่งสินค้าแล้ว";
                        $status_mas_show = "n";
                        $status_tran_show = "n";
                        //return '<h5><span class="badge badge-dark">'+data.order_status+'</span></h5>';
                        break;
                    default:
                        $status_next = "-";  
                }
                if($is_ebook == true && $is_book == false){
                    $status_next = "ชำระเงินแล้ว";
                    $status_mas_show = "y";
                }
                
                OrderMas::find($id)->update([
                    'order_status' => $status_next,
                    'show_status' => $status_mas_show ,
                    'date_paid' => date('Y-m-d'),
                    'paid_time' => date('H:i:s')
                
                ]);
                Tranfer::find($request->id_tran)->update([
                    'show_status' => $status_tran_show , 
                    'tranfer_status' => "ชำระเงินแล้ว"
                ]);

                $order_tran_books = OrderTran::with(['getProduct'])->where('order_id', $id)->where('is_ebook','false')->get();
                if(!empty($order_tran_books->toArray())){
                    foreach ($order_tran_books as $order_tran){
                        BestSellerEbook::create([
                            'product_id'=>$order_tran->book_id ,
                            'post_date'=>date('Y-m-d H:i:s'),
                            'sale_qty'=>$order_tran->quantitys ,
                            'is_ebook'=> 'false'
                        ]);
                        OrderHistory::create([
                            'product_id'=>$order_tran->book_id ,
                            'order_id'=>$order_tran->order_id ,
                            'username'=>$order_tran->username ,
                            'price'=>$order_tran->price ,
                            'product_price'=>$order_tran->product_price ,
                            'percent_discount'=>$order_tran->percent_discount ,
                            'discount'=>$order_tran->discount ,
                            'net'=>$order_tran->net ,
                            'share_percent'=>$order_tran->share_percent ,
                            'quantitys'=>$order_tran->quantitys ,
                            'buffet'=>$order_tran->getProduct->buffet ,
                            'is_ebook'=> 'false'
                        ]);
                    }
                }
                $order_trans_ebooks = OrderTran::where('order_id', $id)->where('is_ebook','true')->get();
                if(!empty($order_trans_ebooks->toArray())){
                    foreach ($order_trans_ebooks as $order_tran){
                        BestSellerEbook::create([
                            'product_id'=>$order_tran->book_id ,
                            'post_date'=>date('Y-m-d H:i:s'),
                            'sale_qty'=>$order_tran->quantitys ,
                            'is_ebook'=> 'true'
                        ]);
                        OrderHistory::create([
                            'product_id'=>$order_tran->book_id ,
                            'order_id'=>$order_tran->order_id ,
                            'username'=>$order_tran->username ,
                            'price'=>$order_tran->price ,
                            'product_price'=>$order_tran->product_price ,
                            'percent_discount'=>$order_tran->percent_discount ,
                            'discount'=>$order_tran->discount ,
                            'net'=>$order_tran->net ,
                            'share_percent'=>$order_tran->share_percent ,
                            'quantitys'=>$order_tran->quantitys ,
                            'buffet'=> 'false' ,
                            'is_ebook'=> 'false'
                        ]);
                        ApproveEbook::create([
                            'username'=>$order_tran->username ,
                            'product_id'=>$order_tran->book_id ,
                            'order_id'=>$order_tran->order_id ,
                            'tran_id'=>$order_tran->id ,                        
                            'approve_status'=>'n' ,
                            'approve_date'=>date('Y-m-d H:i:s'),
                        ]);
                    }
                }
                // insert($array);
                
                return response()->json(['success'=>'Item Change Status successfully.' , 'status_next' => $status_next , 'av_book' => $av_book , 'av_ebook' => $av_ebook]);
            }else if ($request->fn === "approve_read"){
                $status_next = "";
                $approve_status_mas ="" ;
                $order_status_pay ="" ;
                $order_status_tran_approve ="" ;
                switch($request->stagePresent) {
                    case 'รอชำระเงิน':
                        $status_next = "y";
                        $approve_status_mas = "y";  //อ่านได้
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'รอตรวจสอบ':
                        $status_next = "y";
                        $approve_status_mas = "y";  //อ่านได้
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'ชำระเงินแล้ว':
                        $status_next = "y";
                        $approve_status_mas = "y";  //อ่านได้
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    case 'ส่งสินค้าแล้ว':
                        $status_next = "y";
                        $approve_status_mas = "y";  //อ่านได้
                        $order_status_tran_approve ="y"; //อ่านได้
                        break;
                    default:
                        $status_next = "-";  
                }
                OrderMas::find($id)->update([
                    'approve_status' => $approve_status_mas,
                    'approve_date' => date('Y-m-d'),
                    'approve_time' => date('H:i:s')
                ]);
                OrderTran::where('order_id','=',$id)->where('is_ebook','true')
                ->update([
                    'approve_status' => $order_status_tran_approve ,
                    'approve_date' => date('Y-m-d H:i:s') 
                ]);  
                ApproveEbook::where('order_id',$id)->update([
                    'approve_status' => 'y' 
                ]);

                return response()->json(['success'=>'Item Change Status successfully.' ]);
            }else if ($request->fn === "rollback"){
               
                // Tranfer
                OrderMas::find($id)->update([
                    'order_status' => 'รอชำระเงิน',
                    'show_status' => 'y' ,
                ]);
                Tranfer::find($request->id_tran)->update([
                    'tranfer_status' => 'รอชำระเงิน' ,
                    'show_status' => 'y' ,
                    // 'reason' => $request->reason
                ]);
                OrderSendback::create([
                    'order_id' => $id,
                    'description' => $request->reason
                ]);


                return response()->json(['success'=>'Item Change Status successfully.' ,'tranfer_id' => $request->id_tran ]);
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
            Tranfer::find($id)->delete();

            return response()->json(['success'=>'Record deleted Successfully.' , 'status' => $request->fn]);
        }else{
        
          $tr = Tranfer::find($id)->update([
                'show_status' => "n"
            ]);
            return response()->json(['success'=>'Record Deleted To Trash Successfully.' , 'status' => $request->fn ]);
        }
        
    }
}
