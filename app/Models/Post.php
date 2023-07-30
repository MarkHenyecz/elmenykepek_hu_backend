<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $hidden = [
        'character_id',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'character_id',
    ];

    public function character() {
        return $this->belongsTo(Character::class);
    }

    public function images() {
        return $this->hasMany(PostImage::class);
    }
}
