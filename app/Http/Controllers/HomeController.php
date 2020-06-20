<?php

namespace App\Http\Controllers;

use App\File;
use App\FileLog;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function welcome(File $files, FileLog $flie_logs, Request $request){
        $files = $files->orderBy('created_at','desc');
        if(isset($request->search) && $request->search!=''){
            $search = $request->search;
            $files = $files->where(function($q) use($search){
                if($search[0] == "*"){
                    $ext = explode('.',$search)[1];
                    $q->where('file_name','regexp','^.*\.('.$ext.')$');
                }else{
                    $q->where('file_name','like','%'.$search.'%');
                }
            });
        }
        $files = $files->paginate(10);
        $flie_logs = $flie_logs->orderBy('created_at','desc')->paginate(10);
        return view('welcome',compact('files','flie_logs'));
    }
    public function uploadFile(File $file, FileLog $flie_log, Request $request){
        if ($request->hasFile('input_file')) {  
            $path = public_path ('images/uploaded_file');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $icon = $request->file('input_file')->store('public/images/uploaded_file');
            $name = str_replace('public/images/uploaded_file/', '', $icon);
            $ext = pathinfo($icon, PATHINFO_EXTENSION);
            File::create([
                'file_name' => $name,
                'file_type' => $ext
            ]);
            $flie_log->create([
                'message' => $name." uploaded"
            ]);
        }
        return redirect()->route('welcome');
    }

    public function delete(File $file, FileLog $flie_log, $id){
        $file = $file->where('id',$id)->first();
        $name = $file->file_name;
        $file->delete();
        $flie_log->create([
            'message' => $name." deleted"
        ]);
        return redirect()->route('welcome');
    }
}
