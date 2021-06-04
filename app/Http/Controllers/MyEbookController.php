<?php

namespace App\Http\Controllers;


use App\Publisher;
use App\ApproveEbook;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyEbookController extends Controller
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
        $myebooks = DB::table('ebook_approve_ebook as t1')
                ->leftJoin('product as t2' , 't1.product_id' , 't2.id')
                ->where('t1.username',$user->username)
                ->where('t1.approve_status','y')
                ->where('t2.is_ebook','true')
                ->groupBy('t1.product_id')
                ->orderBy('t1.id','DESC')
                ->get();

        return view('front-end-ebook.my-ebook' , [
            'myebooks' => $myebooks ,
            'publishers' => $publishers ,
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
        //
    }
}
