<?php

namespace App\Http\Controllers;

use App\FavorBook;
use App\User;
use App\Publisher;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FavorBookController extends Controller
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
    public function index(Request $request )
    {
        $user = null ;
        if (Auth::check()) {
            $user = Auth::user();
        }
        $publishers = Publisher::all();
 
        if(request()->ajax()) {
            // $data = FavorBook::leftJoin('product as t2' , 'favor_book.book_id' ,'t2.id' )
            //                     ->leftJoin('users as t3' , 'favor_book.user_id' ,'t3.id' )
            //                     ->select( 'favor_book.id as favor_book_id','favor_book.book_id','t2.book_name' ,'t2.blame_product')
            //                     ->where('user_id' , $user->id)
            //                     ->orderBy('created_at','DESC')
            //                     ->get();
            $data = DB::table('favor_book')
                    ->leftJoin('product as t2' , 'favor_book.book_id' ,'t2.id' )
                    ->leftJoin('users as t3' , 'favor_book.user_id' ,'t3.id' )
                    ->select( 'favor_book.id as favor_book_id','favor_book.book_id','t2.book_name' ,'t2.blame_product','t2.picture' ,'t2.price')
                    ->where('favor_book.user_id' , $user->id)
                    ->where('favor_book.is_ebook' , 'false')
                    ->orderBy('favor_book.created_at','DESC')
                    ->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn =' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->favor_book_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn">ลบ</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('front-end.favor' , [
            'publishers' => $publishers ,
            'user' => $user ,
        ]);
    }

    public function indexEbook(Request $request ){
        $user = null ;
        if (Auth::check()) {
            $user = Auth::user();
        }
 
        if(request()->ajax()) {
            // $data = FavorBook::leftJoin('product as t2' , 'favor_book.book_id' ,'t2.id' )
            //                     ->leftJoin('users as t3' , 'favor_book.user_id' ,'t3.id' )
            //                     ->select( 'favor_book.id as favor_book_id','favor_book.book_id','t2.book_name' ,'t2.blame_product')
            //                     ->where('user_id' , $user->id)
            //                     ->orderBy('created_at','DESC')
            //                     ->get();
            $data = DB::table('favor_book')
                    ->leftJoin('ebook_product as t2' , 'favor_book.book_id' ,'t2.id' )
                    ->leftJoin('users as t3' , 'favor_book.user_id' ,'t3.id' )
                    ->select( 'favor_book.id as favor_book_id','favor_book.book_id','t2.product_name' ,'t2.product_image' ,'t2.alias_price','t2.product_price')
                    ->where('favor_book.user_id' , $user->id)
                    ->where('favor_book.is_ebook' , 'true')
                    ->orderBy('favor_book.created_at','DESC')
                    ->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn =' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->favor_book_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBtn">ลบ</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('front-end-ebook.favor' , [
            'user' => $user ,
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
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }

         FavorBook::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
        
    }
}
