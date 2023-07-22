<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public static function IsImage(UploadedFile $file)
    {
        $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];

        return in_array($file->getMimeType(), $allowedMimeTypes);
    }

    public function uploadFile(Request $request) {
        $file = $request->file('file');


        if(is_null($file))
            return response('', 400);

        $dbFile = new File();
        $dbFile->uploadFile($file, request()->user()->id);
        $dbFile->save();

        return $dbFile;
    }
}
