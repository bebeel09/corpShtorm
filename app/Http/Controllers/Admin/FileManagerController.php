<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;

class FileManagerController extends Controller
{
    public function getFileURL(Request $request){
        $validatedData = $request->validate([
            'files' => 'file',
        ]);

        $originalName=date('U').$request->file('files')->getClientOriginalName();

        $linkToFile = $request->file('files')->storeAs('files',$originalName,'public');
        echo url($linkToFile);
    }

    public function getFile($fileName){
        return Storage::download('public/files/'.$fileName, $fileName);
    }

    public function getCatalogFile($fileName){
        return Storage::download('public/Catalog/'.$fileName, $fileName);
    }

    public function getImgURL(Request $request){
        $validatedData = $request->validate([
            'files' => 'image',
        ]);

        $linkToImg = $request->file('file')->store('img','public');
        echo url($linkToImg);
    }

    public function getImg($ImgName){
        return Storage::download('public/img/'.$ImgName, $ImgName);
    }

    public function getAvatar($avatarName){
        return Storage::download('public/avatar/'.$avatarName, $avatarName);
    }
}
