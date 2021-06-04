<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;

class MemberConsignmentController extends Controller
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
            $data = DB::table('users')->where('approve_consignment' , 'check')->orderBy('created_at' ,'ASC')->get();
                
   
            return datatables()->of($data)
            ->addIndexColumn()
            
            ->addColumn('status', function($row){
                $btn = '<span class="badge badge-warning payment-status-wait"><i class="fas fa-circle"></i> รออนุมัติ</span>';
                // $btn = '<h5><span class="badge badge-dark">รออนุมัติ</span></h5>';
                 return $btn;
            })
            ->addColumn('action', function($row){
                
                $btn = '<a href="'.url("admin/memberConsignment/".$row->id).'" data-id="'.$row->id.'" class="edit btn btn-light box_shadow btn_rounded editBtn"><i class="far fa-eye fa-2x"></i></a>';
                 return $btn;
            })
            ->rawColumns(["action" ,"status"])
            ->make(true);
        }
        return view("members.consignment");
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
        $user = User::with(['getPayment'])->where('id',$id)->where('approve_consignment','check')->firstOrFail();
        // DD($user);
        return view("members.consignmentDetail" , ['user' => $user]);
        // DD($id);
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
        $user = User::find($id);
        $user->update([
            "approve_consignment" => $request->value
        ]);
        return response()->json(['success'=>'fetch data success.' ]);
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
