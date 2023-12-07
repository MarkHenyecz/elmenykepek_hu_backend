<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function likes() {
        return $this->hasMany(Like::class, 'liked_id', 'id')->where('liked_type', Post::class);
    }

    protected $appends = [
        'likes',
        'isLiked',
    ];

    public function getLikesAttribute() {
        return $this->likes()->count();
    }

    public function getIsLikedAttribute() {
        $user = Auth::user();
        if(!$user)
            return false;

        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
