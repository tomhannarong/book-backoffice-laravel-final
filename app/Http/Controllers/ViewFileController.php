<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;

class ViewFileController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function preView($name)
    {
        // return("123");
        $filename = 'app/public/file-preview/'.$name.'.pdf';
        $path = storage_path($filename);
        if(file_exists($path)){
            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }else{
            return back();
        }
    }
    public function fileEbook($name)
    {
        if (Auth::check()) {
            if(Auth::user()->class_user === 'admin'){
                $filename = 'app/public/file-ebooks/'.$name.'.pdf';
                $path = storage_path($filename);
                if(file_exists($path)){
                    return Response::make(file_get_contents($path), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="'.$filename.'"'
                    ]);
                }else{
                    return back();
                }
            }
            return back();
        }else{
            return back();
        }
    }
   
    public function view($name)
    {
        // return("123");
        // return view("front-end-ebook.view123");
        if (Auth::check()) {
            $filename = 'app/public/file-ebooks/'.$name.'.pdf';
            $path = storage_path($filename);
            if(file_exists($path)){
                return view("front-end-ebook.view",[
                    'pdf_name' => $name 
                ]);
            }else{
                return back();
            }
            return back();
        }else{
            return back();
        }
    }
}
