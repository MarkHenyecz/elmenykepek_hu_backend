<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $hidden = [
        'id',
        'post_id',
        'image_id',
        'created_at',
        'updated_at',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function image() {
        return $this->hasOne(File::class, 'id', 'image_id');
    }
}
