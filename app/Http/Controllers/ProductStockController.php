<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class ProductStockController extends Controller
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
            $data = null ;
            switch ($request->status) {
                case "status_nor":
                    $data = Product::with(['getPhoto'])
                    ->where('product.blame_product' ,'<>' , 'y')
                    ->where('product.buffet' ,'<>' , 'true')
                    ->where('product.is_ebook' ,'=' , 'false')
                    ->orderBy('product.id','DESC')
                    ->get();
                  break;
                case "status_buffet":
                    $data = Product::with(['getPhoto'])
                    ->where('product.buffet' ,'=' , 'true')
                    ->where('product.is_ebook' ,'=' , 'false')
                    ->orderBy('product.id','DESC')
                    ->get();
                    break;
                default:
                $data = Product::with(['getPhoto'])->where('product.is_ebook' ,'=' , 'false')->orderBy('product.id' ,'DESC')->get();
                // ->select('*')
                // ->get();

            }
           return datatables()->of($data)
           ->addIndexColumn()
           ->addColumn('photo', function($row){
                $html ="";
                foreach ($row->getPhoto as $value ) {
                    if($value->default == "true"){
                        $html = '<img src="'.asset('storage/book-images/thumbnail/'.($value->photo ?? '') ).'" width="70" class="box_shadow" />';
                        return $html  ;
                    }
                    else{
                        $html = '<img src="'.asset('storage/book-images/thumbnail/'.($row->getPhoto[0]->photo ?? '') ).'" width="70" class="box_shadow" />';
                    }
                }
                return $html  ;
            })
            
            ->addColumn('stock_hold', function($row){
                    $btn ='<h5 ><span class="badge badge-dark btn_rounded box_shadow">'.$row->stock_hold.'</span></h5>';
                    return $btn ;
            })
            ->addColumn('stock_remain', function($row){
                    $btn ='<h5><span class="badge badge-dark btn_rounded box_shadow">'.$row->stock_remain.'</span></h5>';
                    return $btn ;
            })
           ->addColumn('action', function($row){
                $btn ='
             <div class="form-group ">
                                <div class="input-group ">
                                    <input class="form-control btn_rounded box_shadow" type="text" id="stock'.$row->id.'" name="stock" onkeypress="return isNumber(event)" value="'.$row->stock.'">
                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light btn_rounded btn-success-custom-color BtnSaveEdit" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">Save</a>
              
                                </div>
                            </div>';
           return $btn ;
            //    $btn = '<input class="" type="number" step="1" id="stock" name="stock" >';
            //    $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm BtnSaveEdit">Save</a>';
            //     return $btn;
           })
           ->rawColumns(['photo','action','stock_hold','stock_remain'])
           ->make(true);
       }
        return view('products.stock_product');
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
        return("123");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return("456");
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
        $product =Product::find($id);
        $stock_remain = $request->stock - $product->stock_hold ; //สินค้าพร้อมขาย
        // DD($stock);
        $product->update([
            'stock' => $request->stock ,
            'stock_remain' => $stock_remain
        ]);
        return response()->json(['success'=>'Item saved successfully.' , 'stock' => $request->stock]);
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
