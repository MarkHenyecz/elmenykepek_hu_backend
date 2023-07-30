<?php
namespace App\Enums;

use App\Models\Post;

enum LikeTypeEnum: string 
{
    case Post = Post::class;
}