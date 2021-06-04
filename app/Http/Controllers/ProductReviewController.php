<?php

namespace App\Http\Controllers;

use App\ProductReview;
use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $product_id = $request->book_id ;
            // $product_review = ProductReview::all();
            // $product_review = DB::table('publisher')->get();
            $product_review = ProductReview::leftJoin('users', function($join) use ($product_id){
                $join->on('product_review.username','users.username');
                $join->on('product_review.product_id','=',DB::raw("'".$product_id."'"));
            })->leftJoin('product_rate', function($join) use ($product_id){
                $join->on('product_review.username','product_rate.username');
                $join->on('product_rate.product_id','=',DB::raw("'".$product_id."'"));
            })
            // leftJoin('users' ,'product_review.username','users.username')
            // ->leftJoin('product_rate' ,'product_review.username','product_rate.username')
            ->select('users.name','users.email','users.avatar','product_review.message','product_rate.rate')
            ->selectRaw('DATE_FORMAT(product_review.created_at, "%d-%M-%Y %H:%i:%s") as createdDate')
            ->where('product_review.product_id',$request->book_id)
            ->orderBy('product_review.created_at','DESC')
            ->get();

            return datatables()->of($product_review)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $html = '<table class="table table-dark rounded-lg">
                            <tbody>';
                                // if($row->id){
                                //     for (const e of response.val) {
                                //         const {name , email , avatar , message ,rate , createdDate} = e ;
                                        $html .= '<tr>
                                                    <th scope="row" colspan="2">';
                                                     $i= 1 ;
                                                    while($i <= 5 ){          
                                                        if($i <= $row->rate){
                                        $html .= ' <i class="fas fa-star colorGold"></i> ';
                                                        }
                                                        if($i > $row->rate){                                                
                                       $html .= ' <i class="fas fa-star"> ';
                                                        }
                                                        $i++ ;
                                                    }
                                        $html .=     '                                                 
                                                    </th>                                                
                                                </tr>' ;
                                        $html .= '<tr>
                                                    <th scope="row" colspan="2">                            
                                                        <font>ข้อความ : </font>
                                                        <font>'.$row->message.'</font>                                                    
                                                    </th>                                                
                                                </tr>
                                                <tr>
                                                    <td scope="row" class="text-right">';
                                                    if($row->avatar){
                                        $html .=         '   <img src="'.url("storage/profile-uploads").'/'.$row->avatar.'" width="30px" class="rounded" style="background-color:white" > ';                            
                                                    }else{
                                        $html .=         '   <img src="'.url("img/no_pic.png").'/'.'" width="30px" class="rounded" style="background-color:white" > ';
                                                    }
                                        $html .=                '  <font>'.$row->name.'</font> | 
                                                        <small>'.$row->createdDate.'</small> 
                                                    </td>
                                                </tr>
                                            ';
                                    // }
                                // }else {
                                    // $html .= '<i class="fas fa-star"></i> <h3>ไม่มีการรีวิว</h3> <i class="fas fa-star"></i>';
                                // }
                                $html .= '   </tbody>
                        </table>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('front-end.productsDetail');

        // $product_id = $request->book_id ;
        // $product_review = ProductReview::leftJoin('users', function($join) use ($product_id){
        //     $join->on('product_review.username','users.username');
        //     $join->on('product_review.product_id','=',DB::raw("'".$product_id."'"));
        // })->leftJoin('product_rate', function($join) use ($product_id){
        //     $join->on('product_review.username','product_rate.username');
        //     $join->on('product_rate.product_id','=',DB::raw("'".$product_id."'"));
        // })
        // // leftJoin('users' ,'product_review.username','users.username')
        // // ->leftJoin('product_rate' ,'product_review.username','product_rate.username')
        // ->select('users.name','users.email','users.avatar','product_review.message','product_rate.rate')
        // ->selectRaw('DATE_FORMAT(product_review.created_at, "%d-%M-%Y %H:%i:%s") as createdDate')
        // ->where('product_review.product_id',$request->book_id)
        // ->orderBy('product_review.created_at','DESC')
        // ->get();

        // return response()->json(['success'=>'Added new records.' ,'val' => $product_review]);
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
    public function destroy($id)
    {
        //
    }
}
