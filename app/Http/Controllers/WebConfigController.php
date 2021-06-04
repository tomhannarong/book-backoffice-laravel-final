<?php

namespace App\Http\Controllers;

use App\WebConfig;
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

class WebConfigController extends Controller
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
       $web_config = WebConfig::first();
        return view('config',['web_config'=> $web_config]);
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
        // $validator = Validator::make($request->all(), [
        //     'name'=> 'required',
        // ]);
        //return("id:".$id."id:".$request->id."code:".$request->code);
        // if ($validator->passes()) {
            //1 วิธี
            $web_config = WebConfig::find($id);
            $web_config->shop_name = $request->shop_name ;
            $web_config->tag_title = $request->tag_title ;
            $web_config->tag_keyword = $request->tag_keyword ;
            $web_config->tag_description = $request->tag_description ;
            $web_config->publisher = $request->publisher ;
            $web_config->address = $request->address ;
            $web_config->subdistric = $request->subdistric ;
            $web_config->distric = $request->distric ;
            $web_config->province = $request->province ;
            $web_config->zipcode = $request->zipcode ;
            $web_config->tel = $request->tel ;
            $web_config->mobile_number = $request->mobile_number ;
            $web_config->fax = $request->fax ;
            $web_config->email = $request->email ;
            $web_config->email_news = $request->email_news ;
            $web_config->buffet = $request->buffet ;
            $web_config->share_admin = $request->share_admin ;
            $web_config->share_pub = $request->share_pub ;
            $web_config->fee = $request->fee ;
            $web_config->cancel_time = $request->cancel_time ;
            
            
            if($request->hasFile('imgInp')) {
                // return response()->json(['success'=>'Added new records.' , 'request' => $request->all() , 'id' => $id]);
                $filenamewithextension = $request->file('imgInp')->getClientOriginalName();
                $extension = $request->file('imgInp')->getClientOriginalExtension();
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;

                $path_dir = 'public/logo-uploads/thumbnail';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
    
                //Upload File full 
                $path = public_path('storage/logo-uploads/'.$filenametostore);
                $img =   Image::make($request->file('imgInp')->getRealPath())->save($path);
                // $request->file('imgInp')->storeAs('public/logo-uploads/thumbnail', $filenametostore);
        
                //Resize image here
                $thumbnailpath = base_path().'/public/storage/logo-uploads/thumbnail/'.$filenametostore;
                // $photofull = base_path().'/public/storage/logo-uploads/'.$filenametostore;
    
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
                $config_delete_db = WebConfig::find($id);
                $path_dir_old_thumbnail = $path_dir . '/' .$config_delete_db->logo ;
                $path_dir_old_full = 'public/logo-uploads/' .$config_delete_db->logo;
                if(Storage::exists($path_dir_old_thumbnail)){
                    Storage::delete($path_dir_old_thumbnail); 
                }
                if(Storage::exists($path_dir_old_full)){
                    Storage::delete($path_dir_old_full);
                }

                $web_config->logo = $filenametostore;
                
            }
            $web_config->save();
            // return response()->json(['success'=>'Added new records.' , 'request' => $request->all() , 'id' => $id]);


            // $publisher = WebConfig::updateOrCreate(['id' => $id],[
            //     'publisher' => $request->name,
            // ]);
            return response()->json(['success'=>'Item saved successfully.' , 'buffet'=>$web_config->buffet]);
        // }

        //  return response()->json(['error'=>$validator->errors()->all()]);
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
