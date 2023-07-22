<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $hidden = [
        'user_id',
        'picture_id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'picture_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function profilePicture() {
        return $this->hasOne(File::class, 'id', 'picture_id');
    }
}
