<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Payment;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showRegistrationForm()
    {
        $payments = Payment::all();
        return view('auth.register', ["payments"=>$payments]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array  $data )
    {
        // DD($data);
        if($data['class_user'] == 'user'){
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'username' => ['required' , 'string', 'max:255' ,'unique:users,username'] ,
            ],['username.unique' => "username นี้ถูกใช้งานไปแล้ว" ,
            'email.unique' => "e-mail นี้ถูกใช้งานไปแล้ว"]);

        }else if($data['class_user'] == 'pub' || $data['class_user'] == 'writer'){

            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'username' => ['required' , 'string', 'max:255' ,'unique:users,username'] ,
                'bank_name' => ['required', 'string', 'max:255'],
                'bank_no' => ['required', 'string', 'max:255'],
                'bank_acc' => ['required', 'string', 'max:255'],
                'bank_branch' => ['required', 'string', 'max:255'],
                'imgInp' => ['required','mimes:jpeg,png,jpg,gif,svg'],
            ],['username.unique' => "username นี้ถูกใช้งานไปแล้ว" ,
            'email.unique' => "e-mail นี้ถูกใช้งานไปแล้ว" ,
            'imgInp.mimes' => "format : jpeg,png,jpg,gif,svg" ,
            'imgInp.required' => "กรุณาใส่รูปหน้า Book bank ด้วยค่ะ" ,
            'bank_name.required' => "กรุณาเลือกธนาคารค่ะ" ,
            'bank_no.required' => "กรุณาใส่เลขที่บัญชีค่ะ" ,
            'bank_acc.required' => "กรุณาใส่ชื่อบัญชีค่ะ" ,
            'bank_branch.required' => "กรุณาใส่สาขาธนาคารค่ะ" , ]);
        }
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $filenametostore = NULL;
        if(!empty($data['imgInp'])) {
            $filenamewithextension = $data['imgInp']->getClientOriginalName();
            $extension = $data['imgInp']->getClientOriginalExtension();
            $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
            //check dir path 
            $path_dir = 'public/book-bank-images';
            if(!Storage::exists($path_dir)){
                Storage::makeDirectory($path_dir);
            }

            $path = public_path('storage/book-bank-images/'.$filenametostore);
            $img =   Image::make($data['imgInp']->getRealPath())->save($path);

        }
        if($data['class_user'] == 'user'){
            $approve_consignment = 'no_access';
        }else if($data['class_user'] == 'pub' || $data['class_user'] == 'writer'){
            $approve_consignment = 'check';
        }
        
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'class_user' => $data['class_user'],
            'ban_status' => "no",
            'sid' => $data['sid'],
            'name_send' => $data['name'],
            'phone_send' => $data['tel'],
            'address_full' => $data['address_full'],
            'subdistric' => $data['subdistric'],
            'distric' => $data['distric'],
            'province' => $data['province'],
            'zipcode' => $data['zipcode'],
            'tel' => $data['tel'],
            'alias' => $data['alias'],
            'sex' => $data['sex'],
            'birthday' => $data['birthday'],
            'bank_name' => $data['bank_name'],
            'bank_no' => $data['bank_no'],
            'bank_acc' => $data['bank_acc'],
            'bank_type' => $data['bank_type'],
            'bank_branch' => $data['bank_branch'],
            'bank_file' => $filenametostore,    
            'approve_consignment' => $approve_consignment,    
            
        ]);
        return $user;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if($user->class_user == "pub" || $user->class_user == "writer"){ //role pub , writer
            auth()->logout();
            return redirect()->route('login')->with(['info'=>'รอการตรวจสอบ ขณะนี้ซื้อสินค้าได้ตามปกติค่ะ']);
        }else{ //role user
            return redirect($this->redirectPath());
        }
        
    }

    // protected function redirectTo()
    // {
    //     // if (auth()->logout()->role_id == 1) {
    //     //     return '/admin';
    //     // }
    //     // return '/home';

    //     auth()->logout();
    //     return redirect()->route('login')
    //             ->with(['error'=>'ID คุณถูกระงับการใช้งาน']);
    // }
}
