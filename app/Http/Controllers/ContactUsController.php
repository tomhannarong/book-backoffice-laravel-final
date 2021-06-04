<?php

namespace App\Http\Controllers;

use App\Publisher;
use App\ContactUs;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            if(Auth::user()->class_user === 'admin'){
                if(request()->ajax()) {
                        $data = DB::table('contact_us')->orderBy('created_at' ,'DESC')->get();
        
                    return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){                     
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="edit btn_rounded btn btn-light box_shadow viewBtn">View</a>';
        
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class=" btn_rounded btn btn-light box_shadow deleteBtn">Delete</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
                return view('contact.index');
            }
        }
        return redirect()->route('contact.create');
        
    }
    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
    public function sendEmail(Request $request) {
        $validate = $request->validate([
            'detail' => 'required',
        ],['detail.required' => 'กรุณาใส่ Message ด้วยค่ะ' ,
        ]);
        if (Auth::check()) {
            if(Auth::user()->class_user === 'admin'){

                $email = $request->email ;
                //DD($request->id);
           
                $mailData = [
                    'title' => $request->topic,
                    'message' => $request->message,
                    'body' => $request->detail ,
                ];
          
                Mail::to($email)->send(new ContactMail($mailData));
        
                //dd("Email is Sent.");
                return back()->with('success','ส่งข้อความถึงผู้ร้องขอเรียบร้อยแล้วค่ะ');
            }
        }
        return redirect()->route('contact.create');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $publishers = Publisher::all();
        return view('front-end.contact' ,[
            'publishers' => $publishers ,
        ]);
    }
    //ebook create contact
    public function createEbook()
    {
        return view('front-end-ebook.contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'topic' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'detail' => 'required',
            'captcha' => 'required|captcha'
        ],['topic.required' => 'กรุณาใส่ ชื่อเรื่อง ด้วยค่ะ' ,
            'name.required' => 'กรุณาใส่ ชื่อ-สกุล ด้วยค่ะ' ,
            'email.required' => 'กรุณาใส่ อีเมล์ ด้วยค่ะ' ,
            'phone.required' => 'กรุณาใส่ เบอร์โทรศัพท์ ด้วยค่ะ' ,
            'detail.required' => 'กรุณาใส่ ข้อความ ด้วยค่ะ' ,
            'captcha.required' => 'กรุณาใส่ [code] ด้วยค่ะ' ,
            'captcha.captcha' => 'กรุณาใส่ [code] ให้ถูกต้องด้วยค่ะ' ,
        ]);
        if($validate){
            $contact = ContactUs::create([
                'topic' => $request->topic , 
                'name' => $request->name , 
                'email' => $request->email , 
                'tel' => $request->phone , 
                'message' => $request->detail , 
                'read' => 'false' , 
            ]);
            return back()->with('success','ส่งข้อความถึงเราเรียบร้อยแล้วค่ะ');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check()) {
            if(Auth::user()->class_user === 'admin'){

                $contact_us_old = ContactUs::find($id);
                $contact_us = ContactUs::find($id);
                if (!$contact_us){
                    abort(404);
                    //return redirect('admin');
                }         
                $contact_us->update([
                    'read' => 'true' ,
                ]);
                return view('contact.detail' , [
                    'contact_us' => $contact_us_old ,
                ]);
            }
        }
        return redirect()->route('contact.create');
        
         
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
         ContactUs::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
