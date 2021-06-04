<?php

namespace App\Http\Controllers;

use App\slide;
use Image;
use Illuminate\Http\Request;
use Validator,Redirect,Response;;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
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
        if(request()->ajax()) {
            $data = DB::table('slide')->orderBy("position","ASC")->get();

        return datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('public', function($row){
            $ch = "";
            $title = "OFF";
            $value = "off";
            $color = "btn-light";
            if($row->is_active == "y"){
                $ch = "checked";
                $title = "ON";
                $value = "on";
                $color = "btn-success";
            }  
            return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" '.$ch.' data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="public" class="btn '.$color.' box_shadow isCheckPublic">'.$title.'</a>';
            
              
        })
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light btn_rounded box_shadow editBtn">Edit</a>';

            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
             return $btn;
        })
        ->rawColumns(['action' ,'public'])
        ->make(true);
    }
    return view('slide');
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

        // DD($request->all());
        // return response()->json(['success'=>'Added new records.' , 'data'=> $request->hasFile('imgInp')]);


        $validator = Validator::make($request->all(), [
            'slide_name'=> 'required',
            'imgInp' => [ 'required', 'image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
        ],[
            'imgInp.required' => 'กรุณาใส่รูปด้วยค่ะ'
        ]);

        if ($validator->passes()) {
            // $publisher = Slide::create([
            //     'slide_name' => $request->slide_name,
            //     'slide_images' => $request->slide_images,
            // ]);
            $slide = new Slide();
            $slide->slide_name = $request->slide_name;
            $slide->position = $request->position;
            $slide->is_active = "y";
            
            

            if($request->hasFile('imgInp')) {
                $filenamewithextension = $request->file('imgInp')->getClientOriginalName();
                $extension = $request->file('imgInp')->getClientOriginalExtension();
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                
                //check dir path 
                $path_dir = 'public/slide-images';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }

                //Upload File
                $path = public_path('storage/slide-images/'.$filenametostore);
                $img =   Image::make($request->file('imgInp')->getRealPath())->save($path);

                $slide->slide_images = $filenametostore;
            
            }
            $slide->save();
            return response()->json(['success'=>'Added new records.']);
        }
    	return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $slide = Slide::find($id);
        return response()->json($slide);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(request()->ajax()) {
            if($request->has('fn')){
                if($request->fn === "public"){
                    Slide::find($id)->update([
                        'is_active' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.']);
                    return response()->json(['success'=>'Item saved successfully.' , 'public_status' => $request->status , 'fn' => $request->fn]);
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'slide_name'=> 'required',
            'imgInp' => [ 'image' , 'mimes:jpeg,png,jpg,gif,svg' ,'max:2048'],
        ]);

        if ($validator->passes()) {

            
            $slide = Slide::find($id);
            $slide->slide_name = $request->slide_name;
            $slide->position = $request->position;
            
            //1 วิธี
            // $publisher = Publisher::updateOrCreate(['id' => $id],[
            //     'publisher' => $request->name,
            // ]);

            if($request->hasFile('imgInp')) {

                $filenamewithextension = $request->file('imgInp')->getClientOriginalName();
                $extension = $request->file('imgInp')->getClientOriginalExtension();
                $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
        
                //check dir path 
                $path_dir = 'public/slide-images';
                if(!Storage::exists($path_dir)){
                    Storage::makeDirectory($path_dir);
                }

                //Upload File
                $path = public_path('storage/slide-images/'.$filenametostore);
                $img =   Image::make($request->file('imgInp')->getRealPath())->save($path);

                // DELETE FILE
                $slide_db = Slide::find($id);
                $path_dir_old_full = 'public/slide-images/' .$slide_db->slide_images;
                if(Storage::exists($path_dir_old_full)){
                    Storage::delete($path_dir_old_full);
                }

                $slide->slide_images = $filenametostore;
                
            }

            $slide->save();


            return response()->json(['success'=>'Item saved successfully.']);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }

        //  Slide::find($id)->delete();
         $slide = Slide::find($id);

         if($slide->slide_images){
            
            // DELETE FILE
           $path_dir = 'public/slide-images';
           $path_dir_old = $path_dir . '/' .$slide->slide_images ;
                if(Storage::exists($path_dir_old)){
                    Storage::delete($path_dir_old);
                }
         }
         $slide->delete();
    
       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
