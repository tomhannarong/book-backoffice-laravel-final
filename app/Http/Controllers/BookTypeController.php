<?php

namespace App\Http\Controllers;

use App\BookType;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;


class BookTypeController extends Controller
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
            $data = DB::table('book_type')->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light box_shadow btn_rounded editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn btn-light box_shadow btn_rounded deleteBtn">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('book-type');
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
        ]);

        if ($validator->passes()) {
            $book_type = BookType::create([
                'book_type' => $request->name,
            ]);
            return response()->json(['success'=>'Added new records.' , 'name' => $book_type->book_type]);
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
        $book_type = BookType::find($id);
        return response()->json($book_type);
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
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
        ]);
        //return("id:".$id."id:".$request->id."code:".$request->code);
        if ($validator->passes()) {
            //1 ????????????
            $book_type = BookType::updateOrCreate(['id' => $id],[
                'book_type' => $request->name,
            ]);
            return response()->json(['success'=>'Item saved successfully.' , 'name' => $book_type->book_type]);
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
         BookType::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
