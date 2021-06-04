<?php

namespace App\Http\Controllers;
use App\Buffet;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;

class BuffetController extends Controller
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
            $data = DB::table('buffet')->get();

        return datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light btn_rounded box_shadow editBtn">Edit</a>';

            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
             return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    return view('buffet');
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
        //return response()->json(['success'=>'Added new records.' , 'req' => $request->all() ]);
        //DD($request->all());
        $validator = Validator::make($request->all(), [
            'book_number'=> 'required',
            'total_price'=> 'required',
            
        ]);

        if ($validator->passes()) {
            $buffet = Buffet::create([
                'book_number' => $request->book_number,
                'total_price' => $request->total_price,
            ]);
            return response()->json(['success'=>'Added new records.' , 'buffet' => $buffet->total_price]);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Buffet  $buffet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Buffet  $buffet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $buffet = Buffet::find($id);
        return response()->json($buffet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Buffet  $buffet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'book_number'=> 'required',
            'total_price'=> 'required',
        ]);
        //return("id:".$id."id:".$request->id."code:".$request->code);
        if ($validator->passes()) {
            //1 วิธี
            $buffet = Buffet::updateOrCreate(['id' => $id],[
                'book_number' => $request->book_number,
                'total_price' => $request->total_price,
            ]);
            return response()->json(['success'=>'Item saved successfully.' , 'code' => $buffet->total_price]);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Buffet  $buffet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         Buffet::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
