<?php

namespace App\Http\Controllers;

use App\Product;
use App\BookType;
use App\Publisher;
use App\User;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
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
             //DD("123");
                $data = DB::table('users')->orderBy('created_at' ,'DESC')
                ->select('*')
                ->get();
                
   
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('stop_id', function($row){ 
                $ch = "";
                $title = "OFF";
                $value = "no";
                $color = "btn-light";
                if($row->ban_status == "yes"){
                    $ch = "checked";
                    $title = "ON";
                    $value = "yes";
                    $color = "btn-warning";
                } 
               return $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="StopID" class="edit btn '.$color.' box_shadow stop_id_Btn">'.$title.'</a>';
   
            })
            ->addColumn('change_password', function($row){     
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="change_password" class="edit btn btn-light box_shadow btn_rounded change_password_Btn">change password</a>';

                  
            })
            ->addColumn('blog', function($row){     
             
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="blog" class="edit btn btn-light box_shadow btn_rounded blogBtn">blog</a>';

                  
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light box_shadow btn_rounded editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light box_shadow btn_rounded deleteBtn">Delete</a>';
                 return $btn;
            })
            
            ->rawColumns(["action", "stop_id", "change_password", "blog"])
            ->make(true);
        }
        //$books = Book::all();
        return view("members.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("members.add-member");
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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required' , 'string', 'max:255' ,'unique:users,username'] ,
            'email' => ['required' , 'string', 'email', 'max:255','unique:users,email'] ,
            'name_picture' => ['image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
        ]);
        if ($validator->passes()) {
            $user = new User();
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->alias = $request->alias;
            $user->name = $request->name;
            $user->sid = $request->id_card;
            $user->address_full = $request->address_full;
            $user->subdistric = $request->subdistric;
            $user->distric = $request->distric;
            $user->province = $request->province;
            $user->zipcode = $request->zipcode;
            $user->email = $request->email;
            $user->tel = $request->mobile;
            $user->class_user = $request->class_user ;
            $user->ban_status = "no";
            
            //รูปปก
            if($request->hasFile('name_picture')) {
                //get filename with extension
                $filenamewithextension = $request->file('name_picture')->getClientOriginalName();
        
                //get filename without extension
                //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        
                //get file extension
                $extension = $request->file('name_picture')->getClientOriginalExtension();
        
                //filename to store
                //$filenametostore = $filename.'_'.time().'.'.$extension;
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
        
                //check dir path 
                $path_dir = 'public/profile-uploads/thumbnail';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }

                //Upload File
                $path = public_path('storage/profile-uploads/'.$filenametostore);
                $img =   Image::make($request->file('name_picture')->getRealPath())->save($path);
        
                //Resize image here
                // $thumbnailpath = public_path('storage/user-images/thumbnail/'.$filenametostore);
                $thumbnailpath = base_path().'/public/storage/profile-uploads/thumbnail/'.$filenametostore;
                // $photofull = base_path().'/public/storage/profile-uploads/'.$filenametostore;
                $width = 600; // your max width
                $height = 600; // your max height
                $img = Image::make($request->file('name_picture')->getRealPath());
                $img->height() > $img->width() ? $width=null : $height=null;
                $img->resize($width, $height, function($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);
                // $img->save($photofull);
                $user->avatar = $filenametostore;
                
            }
            $user->save();
            return response()->json(['success'=>'Item saved successfully.' , 'user' => $user->id , ]);
            //return redirect()->route('member.index');
        }
        return response()->json(['error'=>$validator->errors()->all() ]);
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
        $user = User::find($id);
        if (!$user){
            abort(404);
        }
        //DD($product->all());
        return view("members.edit-member" , [
           'user' => $user
        ]);
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
        if(request()->ajax()) { 
            if($request->has('fn')){
                if($request->fn === "band"){
                    $user =  User::find($id)->update([
                        'ban_status' => $request->val
                    ]);
                    if($user){
                        return response()->json(['success'=>'Item saved successfully.' , 'band ID' => $request->val , 'fn' => $request->fn]);
                    }else{
                        return response()->json(['Error'=>'Item Error not success.' ]);
                    }
                    
                }else if($request->fn === "change_password"){
                    $user =  User::find($id)->update([
                        'password' => Hash::make($request->password),
                    ]);
                    if($user){
                        return response()->json(['success'=>'Item saved successfully.' , 'pass' => "****" , 'fn' => $request->fn]);
                    }else{
                        return response()->json(['Error'=>'Item Error not success.' ]);
                    }
                }
                
            }

            $user = User::find($id);

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->email, 'email')],
                'name_picture' => ['image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
            ]);
            if ($validator->passes()) {

                $user->name = $request->name;
                $user->sid = $request->id_card;
                $user->address_full = $request->address_full;
                $user->subdistric = $request->subdistric;
                $user->distric = $request->distric;
                $user->province = $request->province;
                $user->zipcode = $request->zipcode;
                $user->email = $request->email;
                $user->tel = $request->mobile;
                $user->class_user = $request->class_user ;

                //รูปปก
                if($request->hasFile('name_picture')) {
                    //get filename with extension
                    $filenamewithextension = $request->file('name_picture')->getClientOriginalName();
            
                    //get filename without extension
                    //$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            
                    //get file extension
                    $extension = $request->file('name_picture')->getClientOriginalExtension();
            
                    //filename to store
                    //$filenametostore = $filename.'_'.time().'.'.$extension;
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
            
                    //check dir path 
                    $path_dir = 'public/profile-uploads/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }

                    //Upload File
                    $path = public_path('storage/profile-uploads/'.$filenametostore);
                    $img =   Image::make($request->file('name_picture')->getRealPath())->save($path);
            
                    //Resize image here
                    // $thumbnailpath = public_path('storage/user-images/thumbnail/'.$filenametostore);
                    $thumbnailpath = base_path().'/public/storage/profile-uploads/thumbnail/'.$filenametostore;
                    // $photofull = base_path().'/public/storage/profile-uploads/'.$filenametostore;

                    $width = 600; // your max width
                    $height = 600; // your max height
                    $img = Image::make($request->file('name_picture')->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);
                    // $img->save($photofull);

                    // DELETE FILE
                    $user_db = User::find($id);
                    $path_dir_old_thumbnail = $path_dir . '/' .$user_db->avatar ;
                    $path_dir_old_full = 'public/profile-uploads/' .$user_db->avatar;
                    if(Storage::exists($path_dir_old_thumbnail)){
                        Storage::delete($path_dir_old_thumbnail); 
                    }
                    if(Storage::exists($path_dir_old_full)){
                        Storage::delete($path_dir_old_full);
                    }

                    $user->avatar = $filenametostore;
                    
                }
            
                $user->save();

                return response()->json(['success'=>'Item saved successfully.' ]);
            }
            return response()->json(['error'=>$validator->errors()->all() ]);
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
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         $user = User::find($id);
         //รูปปก
         if($user->avatar){
             // DELETE FILE
            $path_dir = 'public/user-images/thumbnail';
            $path_dir_old_thumbnail = $path_dir . '/' .$user->avatar ;
            $path_dir_old_full = 'public/user-images/' .$user->avatar;
            if(Storage::exists($path_dir_old_thumbnail)){
                Storage::delete($path_dir_old_thumbnail); 
            }
            if(Storage::exists($path_dir_old_full)){
                Storage::delete($path_dir_old_full);
            }
         }
        
         $user->delete();
         //return response()->json(['success'=>'Record deleted Successfully.' , 'status' => $product->picture]);
       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
