<?php

namespace App\Http\Controllers;

use App\Enums\LikeTypeEnum;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class LikeController extends Controller
{
    public function like(Request $request, int $id) {
        $validated = $request->validate([
            'liked_type' => ['required', new Enum(LikeTypeEnum::class)],
        ]);

        $alreadyLiked = Like::where(
            [
                ['liked_type', $validated['liked_type']],
                ['liked_id', $id],
                ['user_id', request()->user()->id]
            ])
            ->first();

        if(!is_null($alreadyLiked)) {
            $alreadyLiked->delete();
            return;
        }

        $newLike = new Like($validated);
        $newLike->liked_id = $id;
        $newLike->user_id = request()->user()->id;
        $newLike->save();

        return;
    }

    public function getLikes(Request $request, int $id) {
        $validated = $request->validate([
            'liked_type' => ['required', new Enum(LikeTypeEnum::class)],
        ]);

        $query = Like::query()->where([['liked_type', $validated['liked_type']],['liked_id', $id]]);
        $user = auth('sanctum')->user();

        return [
            'likes' => $query->count(),
            'liked' => !is_null($user) ? $query->where('user_id', $user->id)->exists() : false
        ];
    }
}
