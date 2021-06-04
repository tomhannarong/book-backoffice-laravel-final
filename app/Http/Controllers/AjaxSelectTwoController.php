<?php

namespace App\Http\Controllers;


use App\Product;
use App\BestSeller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;

class AjaxSelectTwoController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index(Request $request)
    {
        return redirect('/');
    }
    public function ajaxSelectTwoBestSeller(Request $request)
    {
        $search = $request->search;

        if(empty($search)){
           $products = Product::where('public_show','true')->orderby('id','DESC')->where('is_ebook' ,'=' , 'false')
                    ->select('id','book_name')->limit(5)->get();
        }else{
           $products = Product::orderby('book_name','asc')->select('id','book_name')->where('is_ebook' ,'=' , 'false')
                    ->where('public_show','true')
                    ->where('book_name', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        $response = array();
        foreach($products as $product){
           $response[] = array(
                "id"=>$product->id,
                "text"=>$product->book_name
           );
        }
  
        echo json_encode($response);
        exit;
    }
    public function ajaxSelectTwoSearch(Request $request)
    {
        $search = $request->search;

        if(empty($search)){
           $products = Product::where('public_show','true')->orderby('created_at','DESC')
                    ->select('id','book_name','blame_product')->limit(10)->get();
        }else{
           $products = Product::select('id','book_name','blame_product')
                    ->where('public_show','true')
                    ->where('book_name', 'like', '%' .$search . '%')->limit(20)->get();
        }
  
        $response = array();
        foreach($products as $product){
           $response[] = array(
                "id"=>$product->id,
                "text"=>$product->book_name ,
                "blame_product" =>$product->blame_product ,
           );
        }
  
        echo json_encode($response);
        exit;
    }
    
}
