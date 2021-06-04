<?php

namespace App\Http\Controllers;

use App\BoardPost;
use App\BoardReply;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\DB;
use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BoardController extends Controller
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
            $data = DB::table('board_post')->get();

            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('pin', function($row){
                $ch = "";
                $title = "OFF";
                $value = "off";
                $color = "btn-light";
                if($row->pin == "y"){
                    $ch = "checked";
                    $title = "ON";
                    $value = "on";
                    $color = "btn-success";
                }  
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" '.$ch.' data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="public" class="btn '.$color.' isCheckPin">'.$title.'</a>';
            })
            ->addColumn('public', function($row){
                $ch = "";
                $title = "OFF";
                $value = "off";
                $color = "btn-light";
                if($row->show_status == "yes"){
                    $ch = "checked";
                    $title = "ON";
                    $value = "on";
                    $color = "btn-success";
                }  
                return $btn = '<a href="javascript:void(0)" data-toggle="tooltip" '.$ch.' data-id="'.$row->id.'" data-value="'.$value.'" data-original-title="public" class="btn '.$color.' isCheckPublic">'.$title.'</a>';
            })
            ->addColumn('action', function($row){
                $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="reply" class="edit btn btn-light btn_rounded viewReply">View Reply</a>';

                $btn .=' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-light btn_rounded editBtn">Edit</a>';

                $btn .=' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light btn_rounded deleteBtn">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','public','pin'])
            ->make(true);
        }
        return view('board.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('board.add-board');
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
                    $path_dir = 'public/board-des-images';
                    if(!Storage::exists($path_dir)){
                        Storage::makeDirectory($path_dir);
                    }
                    //Resize image here
                    $thumbnailpath = base_path().'/public/storage/board-des-images/'.$filenametostore;
                    $width = 500; // your max width
                    $height = 500; // your max height
                    $img = Image::make($file->getRealPath());
                    $img->height() > $img->width() ? $width=null : $height=null;
                    $img->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($thumbnailpath);

                    return response()->json(['location'=>  asset('storage/board-des-images/'.$filenametostore) ]);

                }                
            }
        }

        $validator = Validator::make($request->all(), [
            'topic'=> 'required',
            // 'description'=> 'required',
        ]);

        if ($validator->passes()) {
            $boardPost = BoardPost::create([
                'topic' => $request->topic,
                'post_description' => $request->description,
                'username' => $request->username,
                'show_status' => "yes",
                'pin' => "y",
                'post_date' => date('Y-m-d H:i:s'),
                'lastupdate' => date('Y-m-d H:i:s')
                
                
            ]);
            // return response()->json(['success'=>'Added new records.' ]);
            return redirect('admin/board');
        }
        return response()->json(['error'=>$validator->errors()->all()]);    
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()) {
            $data = DB::table('board_reply')->where('id',$id)->orderBy('id','ASC')->get();

            return datatables()->of($data)
            ->addIndexColumn()
            
            ->addColumn('reply', function($row){
               
                $html = html_entity_decode($row->reply);
                return $html;
            })
            ->addColumn('action', function($row){
               
                $btn =' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-light btn_rounded box_shadow deleteBtn">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','reply'])
            ->make(true);
        }
        return view('board.reply',[
            'id' => $id ,
        ]);
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
        $boardPost = BoardPost::find($id);
        return view("board.edit-board" , [
            'boardPost' => $boardPost ,
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
                if($request->fn === "public"){
                    BoardPost::find($id)->update([
                        'show_status' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.']);
                    return response()->json(['success'=>'Item saved successfully.' , 'public_status' => $request->status , 'fn' => $request->fn]);
                }
                if($request->fn === "pin"){
                    BoardPost::find($id)->update([
                        'pin' => $request->status
                    ]);
                    return response()->json(['success'=>'Item saved successfully.']);
                    return response()->json(['success'=>'Item saved successfully.' , 'public_status' => $request->status , 'fn' => $request->fn]);
                }
            }
        }

        $validator = Validator::make($request->all(), [
            'topic'=> 'required',
        ]);

        if ($validator->passes()) {
            //1 วิธี
            $BoardPost = BoardPost::updateOrCreate(['id' => $id],[
                'topic' => $request->topic,
                'post_description' => $request->description,
                'username' => $request->username,
                'lastupdate' => date('Y-m-d H:i:s')
                
            ]);
            return response()->json(['success'=>'Item saved successfully.' ]);
        }

         return response()->json(['error'=>$validator->errors()->all()]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        if(!$id){
            return response()->json(['error'=>'ID not found form front-end.']);
         }
         if($request->has('fn')){
            if($request->fn === "reply"){
                BoardReply::find($id)->delete();
                return response()->json(['success'=>'Record deleted Successfully.']);
            }
        }
         BoardPost::find($id)->delete();

       return response()->json(['success'=>'Record deleted Successfully.']);
    }
}
