<?php

namespace App\Models;

use App\Enum\LikeTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const possibleTypes = [
        Post::class,
    ];

    protected $fillable = [
        'liked_id', 
        'liked_type', 
        'user_id'
    ];

    public function liked() {
        return $this->belongsTo($this->liked_type, 'liked_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
