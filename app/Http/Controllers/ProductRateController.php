<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductRate;
use App\ProductReview;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductRateController extends Controller
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

        return response()->json(['success'=>'Added new records.' ,'val' =>  $request->all()]);
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
        if (Auth::check()) {
            $user = Auth::user();
            $username = $user->username ;
        }
        
        if($request->rate != 0){
            $product_rate = ProductRate::create([
                'product_id' => $id , 
                'username' => $username , 
                'rate' => $request->rate , 
                   
            ]);
            $product = Product::find($id);
            $rate_old_total = $product->rate * $product->rate_num  ; 
            $rate_new_total = (($rate_old_total + $request->rate) / ($product->rate_num + 1)) ;
            $rate_num_new = $product->rate_num + 1 ;

            $rate_one_num = $product->rate_one_num ;
            $rate_two_num = $product->rate_two_num ;
            $rate_three_num = $product->rate_three_num ;
            $rate_four_num = $product->rate_four_num ;
            $rate_five_num = $product->rate_five_num ;
            // $comment_num
            switch ($request->rate) {
                case 1:
                    $rate_one_num += 1 ;
                    break;
                case 2:     
                    $rate_two_num += 1 ;    
                    break;
                case 3:
                    $rate_three_num += 1 ;
                    break;
                case 4:
                    $rate_four_num += 1 ;
                    break;
                case 5:
                    $rate_five_num += 1 ;
                    break;
              }
            // 
            $product->update([
                "rate" => $rate_new_total ,
                "rate_num" => $rate_num_new ,
                "rate_one_num" => $rate_one_num ,
                "rate_two_num" => $rate_two_num ,
                "rate_three_num" => $rate_three_num ,
                "rate_four_num" => $rate_four_num ,
                "rate_five_num" => $rate_five_num ,
            ]);
        }
        if(!empty($request->review_message)){
            $product = Product::find($id);
            $comment_num = $product->comment_num + 1  ;
            $product->update([
                "comment_num" =>  $comment_num,
            ]);
            ProductReview::create([
                'product_id' => $id , 
                'username' => $username , 
                'message' => $request->review_message ,
            ]);
            
        } 
        if($request->rate == 0 && empty($request->review_message)){

            $validator = Validator::make($request->all(), [
                'review_message'=> 'required',
            ] , 
            ["review_message.required" => "Please enter review message"]);
    
            if ($validator->passes()) {
            }else{
                return response()->json(['warning'=>$validator->errors()->all()]);
            }
            
            
        }
       
      
        return response()->json(['success'=>'Added new records.' ,'val' =>  $request->all()]);
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
