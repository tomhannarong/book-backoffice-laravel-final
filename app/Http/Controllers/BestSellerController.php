<?php

namespace App\Http\Controllers;

use App\Product;
use App\BestSeller;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;



class BestSellerController extends Controller
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
        if(request()->ajax()) 
        {
            if (!empty($request->filter_id)) {
                $data = DB::table('product')->where('id' ,'=' , $request->filter_id)->get();
                return datatables()->of($data)
                ->addIndexColumn()
                ->make(true);
            }else{
                $data = DB::table('best_seller')->leftJoin('product','product.id','best_seller.book_id')->select('product.*','best_seller.id as best_seller_id','best_seller.top')->orderBy('top' ,'asc')->get();

                return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    // $btn .= '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBtn">Edit</a>';
    
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->best_seller_id.'" data-original-title="Delete" class="btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            
        }
        return view('products.best-seller');
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
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'top' => 'required|unique:best_seller,top' ,
        ] ,[
            'top.unique' => 'กรุณาใส่ตำแหน่งที่ไม่ซ้ำ' ,
        ]);

        if ($validator->passes()) {
            $product = Product::find($request->name);
            $best_seller = BestSeller::create([
                'top' => $request->top,
                'book_name' => $product->book_name,
                'alias' => $product->alias,
                'price' => $product->price,
                'pim_time' => $product->pim_time,
                'isbn' => $product->ISBN,
                'writer' => $product->writer,
                'pages' => $product->pages,
                'book_description' => $product->book_description,
                'picture' => $product->picture,
                'pim_year' => $product->pim_year,
                'publisher_id' => $product->publisher_id,
                'book_type_id' => $product->book_type_id,
                'attachment' => $product->attachment,
                'book_id' => $product->id,
                
            ]);
            return response()->json(['success'=>'Added new records.' , 'id'=> $request->name , 'name' => $product->id]);
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
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $best_seller = BestSeller::find($id);
        return response()->json($best_seller);
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
        $best_seller_db = BestSeller::all();
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'top' => ['required', Rule::unique('best_seller')->ignore($best_seller_db->top)],
        ] ,[
            'top.unique' => 'กรุณาใส่ตำแหน่งที่ไม่ซ้ำ' ,
        ]);
        //return("id:".$id."id:".$request->id."code:".$request->code);
        if ($validator->passes()) {
            //1 วิธี
            // $best_seller = BestSeller::updateOrCreate(['id' => $id],[
            //     'book_type' => $request->name,
            // ]);
            return response()->json(['success'=>'Item saved successfully.' , 'top' => $request->top]);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
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
         BestSeller::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
