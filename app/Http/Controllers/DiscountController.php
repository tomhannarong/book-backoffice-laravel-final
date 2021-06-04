<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
class DiscountController extends Controller
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
        if(request()->ajax()) {
            $data = DB::table('discount')->get();

        return datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light box_shadow btn_rounded editBtn">Edit</a>';

            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light box_shadow btn_rounded deleteBtn">Delete</a>';
             return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    return view('discount');
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
            'quantity_min'=> 'required',
            'quantity_max'=> 'required',
            'discount'=> 'required',
        ]);

        if ($validator->passes()) {
            $discount = Discount::create([
                'quantity_min' => $request->quantity_min,
                'quantity_max' => $request->quantity_max,
                'discount' => $request->discount,
            ]);
            return response()->json(['success'=>'Added new records.' , 'discount' => $discount->discount]);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $discount = Discount::find($id);
        return response()->json($discount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity_min'=> 'required',
            'quantity_max'=> 'required',
            'discount'=> 'required',
        ]);
        //return("id:".$id."id:".$request->id."code:".$request->code);
        if ($validator->passes()) {
            //1 วิธี
            $discount = Discount::updateOrCreate(['id' => $id],[
                'quantity_min' => $request->quantity_min,
                'quantity_max' => $request->quantity_max,
                'discount' => $request->discount,
            ]);
            return response()->json(['success'=>'Item saved successfully.' , 'discount' => $discount->discount]);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         Discount::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
