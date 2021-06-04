<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $remember_me = $request->has('remember') ? true : false;
        
        
            if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'])))
            {
                if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'] ,'ban_status' => 'no') ,$remember_me))
                {
                    if (auth()->user()->class_user == "admin") {
                        return redirect()->route('dashboard');
                    }else if(auth()->user()->class_user == "pub"){
                        return redirect($input['url']);
                    }else if(auth()->user()->class_user == "user"){
                        return redirect($input['url']);
                    }else if(auth()->user()->class_user == "writer"){
                        return redirect($input['url']);
                    }else{
                        return redirect()->route('login')
                        ->with(['error'=>'Incorrect Username or Password','username_old'=>$input['username']]);
                    }
                }else{
                    // Auth::logout();
                    auth()->logout();
                    return redirect()->route('login')
                            ->with(['error'=>'ID คุณถูกระงับการใช้งาน']);
                }
                
                
            }else{
                return redirect()->route('login')
                    ->with(['error'=>'Incorrect Username or Password','username_old'=>$input['username']]);
            }


        
        
          
    }
}
