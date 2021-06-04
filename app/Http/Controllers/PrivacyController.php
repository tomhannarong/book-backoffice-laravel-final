<?php

namespace App\Http\Controllers;

use App\Privacy;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PrivacyController extends Controller
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
            $data = DB::table('privacy')->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('public', function($row){
                $ch = "";
                $title = "OFF";
                $value = "off";
                $color = "btn-light";
                if($row->approve_status == "y"){
                    $ch = "checked";
                    $title = "ON";
                    $value = "on";
                    $color = "btn-success";
                }  
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" '.$ch.' data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="public" class="btn '.$color.' box_shadow isCheckPublic">'.$title.'</a>';
                
                  
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn btn-light btn_rounded box_shadow editBtn">Edit</a>';

                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','public'])
            ->make(true);
        }
        return view('privacy');
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
        if(request()->ajax()) {
            
            if($request->fn){
                if($request->fn == "upload_image_detail"){
                    $file = request()->file('file') ;
                    $filenamewithextension = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $filenametostore = date('mdYHis') . uniqid().'.'.$extension;
                    //check dir path 
                    $path_dir = 'public/policy-images';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
                    //Resize image here
                    $thumbnailpath = base_path().'/public/storage/policy-images/'.$filenametostore;
                    $width = 500; // your max width
                    $height = 500; // your max height
                    $img = Image::make($file->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);

                    return response()->json(['location'=>  asset('storage/policy-images/'.$filenametostore) ]);

                }                
            }
        }
        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'description'=> 'required',
        ]);

        if ($validator->passes()) {
            $privacy = Privacy::create([
                'news_title' => $request->title,
                'news_detail' => $request->description,
                'approve_status' => "y",
            ]);
            return response()->json(['success'=>'Added new records.' ]);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function show(Privacy $privacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
        $privacy = Privacy::find($id);
        return response()->json($privacy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(request()->ajax()) {
            if($request->has('fn')){
                if($request->fn === "public"){
                    Privacy::find($id)->update([
                        'approve_status' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.']);
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'title'=> 'required',
            'description'=> 'required',
        ]);

        if ($validator->passes()) {
            //1 วิธี
            $privacy = Privacy::updateOrCreate(['id' => $id],[
                'news_title' => $request->title,
                'news_detail' => $request->description
            ]);
            return response()->json(['success'=>'Item saved successfully.' ]);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         Privacy::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
