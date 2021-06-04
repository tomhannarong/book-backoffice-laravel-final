<?php

namespace App\Http\Controllers;
use App\User;
use App\Publisher;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Image;
use Illuminate\Support\Str;


class ProfileController extends Controller
{

    public function __construct() //check login
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

        return view('front-end.profile');
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
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         if($id != Auth::user()->id){
            abort(404);
         }
        //$user_db = User::find($id);
        $user = User::find($id);
        $publishers = Publisher::all();

            // $path_dir = 'public/profile-uploads/'.$user_db->avatar;
            // $isExists = Storage::exists($path_dir);

        //return response()->json(['data' => $user_db , 'status_file'=>$isExists , 'pathname' => $path_dir ]);
        return view('front-end.profile', [
            'user' => $user ,
            'publishers' => $publishers ,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id )
    {

        $user_db = User::find($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user_db->email, 'email')],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user_db->username, 'username')],
            'password' => ['required', 'string', 'min:8'],
            'imgInp' => ['image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
        ]);

        if(password_verify($request->password, $user_db->password)) {
            if ($validator->passes()) {
                $user = User::find($id);
                if($request->newpassword){
                        $user->name = $request->name;
                        $user->email = $request->email ;
                        $user->username = $request->username ;
                        $user->password = Hash::make($request->newpassword) ;
                        $user->check_repass = 'true' ;
                    //auth()->logout();
                }else{
                        $user->name = $request->name;
                        $user->email = $request->email ;
                        $user->username = $request->username ;
                }

                if($request->hasFile('imgInp')) {
                    $filenamewithextension = $request->file('imgInp')->getClientOriginalName();

                    $extension = $request->file('imgInp')->getClientOriginalExtension();

                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;

                    $path_dir = 'public/profile-uploads/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
        
                    //Upload File
                    $path = public_path('storage/profile-uploads/'.$filenametostore);
                    $img =   Image::make($request->file('imgInp')->getRealPath())->save($path);
            
                    //Resize image here
                    $thumbnailpath = base_path().'/public/storage/profile-uploads/thumbnail/'.$filenametostore;
                    // $photofull = base_path().'/public/storage/profile-uploads/'.$filenametostore;
                    // $thumbnailpath = public_path('storage/profile-uploads/thumbnail/'.$filenametostore);
                    // $photofull = public_path('storage/profile-uploads/thumbnail/'.$filenametostore);
                    $width = 600; // your max width
                    $height = 600; // your max height
                    $img = Image::make($request->file('imgInp')->getRealPath());
                    // $img = Image::make($thumbnailpath);
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);
                    // $img->save($photofull);

                    // DELETE FILE
                    $user_delete_db = User::find($id);
                    $path_dir_old_thumbnail = $path_dir . '/' .$user_delete_db->picture ;
                    $path_dir_old_full = 'public/profile-uploads/' .$user_delete_db->picture;
                    if(Storage::exists($path_dir_old_thumbnail)){
                        Storage::delete($path_dir_old_thumbnail); 
                    }
                    if(Storage::exists($path_dir_old_full)){
                        Storage::delete($path_dir_old_full);
                    }

                    $user->avatar = $filenametostore;
                    
                }
                $user->save();
                auth()->logout();

                return response()->json(['success'=>'Item saved successfully.' ]);

            }
            return response()->json(['error'=>$validator->errors()->all() ]);
        }else{
            $a=array();
            if($validator->errors()->all()){
                array_push($a,$validator->errors()->all());
            }
            array_push($a,["password incorrect."]);
            //$result = array_filter($array);
            return response()->json(['error'=>$a]);
        }




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
