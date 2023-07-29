<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private function getQuery() {
        return Post::query()
            ->with(['images.image', 'character.profilePicture', 'character.user']);
    }

    public function createPost(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'character_id' => 'required|integer|exists:characters,id',
            'images' => 'required|array',
        ]);

        $post = new Post();
        $post->fill($validated);
        $post->slug = Str::slug($validated['title']);
        $post->save();
        
        foreach ($validated['images'] as $imageId) {
            if(!File::where([['id', $imageId],['user_id', request()->user()->id]])->exists()) continue;

            $postImage = new PostImage();
            $postImage->post_id = $post->id;
            $postImage->image_id = $imageId;
            $postImage->save();
        }

        return ['id' => $post->id];
    }

    public function getPosts(Request $request) {
        return $this->getQuery()
            ->orderByDesc('created_at')
            ->paginate(perPage: 5, page: $request->page ?? 0);
    }

    public function getPost(string $slug) {
        $post = $this->getQuery()
            ->where('slug', $slug)
            ->first();

        if(is_null($post))
            return response('', 404);

        return $post;
    }
}
