<?php

namespace App\Models;

use App\Http\Controllers\FileController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Webpatser\Uuid\Uuid;

class File extends Model
{
    use HasFactory;

    protected $hidden = [
        'user_id',
        'region',
        'bucket',
        'key',
        'is_public',
        'is_backedup',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'url'
    ];

    public function uploadFile(UploadedFile $file, int $user_id) {
        $this->user_id = $user_id;
        $path = 'misc';

        if(FileController::IsImage($file)) {
            $path = 'images';
        }

        $fullPath = $path.'/'.$this->user_id;
        $fileName = Uuid::generate().'.'.$file->getClientOriginalExtension();

        $file->storeAs($fullPath, $fileName, 's3');

        $this->name = $file->getClientOriginalName();
        $this->region = env('AWS_DEFAULT_REGION', 'eu-central-1');
        $this->bucket = env('AWS_BUCKET', 'elmenykepekhu');
        $this->key = $fullPath.'/'.$fileName;
        $this->is_public = true;
    }

    public function getUrlAttribute() {
        $s3 = Storage::disk('s3')->getClient();

        if($this->is_public) {
            return $s3->getObjectUrl( $this->bucket, $this->key );
        } else {
            return $s3->temporaryUrl( $this->bucket, $this->key, now()->addMinutes(10) );
        }
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
