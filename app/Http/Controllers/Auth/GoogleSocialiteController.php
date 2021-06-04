<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Auth;
use Exception;
use App\User;

class GoogleSocialiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGOOGLE()
    {
        return Socialite::driver('google')->redirect();
        
        
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        // DD("123");
        // $user = Socialite::driver('line')->user();
        // DD($user);
        // $lineid = $user->getId();
        
        // $get = $this->input->get(); // รับ json payload
		// $code = $get['code'];
		// $state = $get['state'];
		// $token = $this->linelogin->token($code,$state); // curl เพื่อขอ id_token
        // $token = json_decode($token);
        // DD(base64_decode($token->id_token));
        try {
     
            $user = Socialite::driver('google')->user();
            // DD($user);

            $finduser = User::where('social_id', $user->id)->first();
      
            if($finduser){
      
                
                if($finduser->ban_status == "yes"){
                    return redirect()->route('login')
                    ->with(['error'=>'ID คุณถูกระงับการใช้งาน']);
                }else {
                    Auth::login($finduser);
                    return redirect('/');
                }
                
      
            }else{
                $newUser = User::create([
                    
                    'username' => "GOOGLE_".$user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'class_user' => "user",
                    'avatar' => $user->avatar,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'password' => Hash::make('my-google-generator'),
                    'check_repass'=> 'false',
                    'ban_status'=> 'no'
                ]);
     
                Auth::login($newUser);
      
                return redirect('/');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}