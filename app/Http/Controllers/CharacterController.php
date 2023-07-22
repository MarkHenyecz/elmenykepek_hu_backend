<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\File;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CharacterController extends Controller
{
    public function createCharacter(Request $request) {
        $validated = $request->validate([
            'name' => 'string|max:255|required',
            'picture_id' => [
                'integer',
                'min:1',
                'exists:files,id'
            ],
        ]);

        $userId = request()->user()->id;
        if(array_key_exists('picture_id', $validated)) {
            $profileImage = File::where('id', $validated['picture_id'])->first();

            if($profileImage->user_id != request()->user()->id) 
                return response('', 401);
        }

        $character = new Character();
        $character->fill($validated);
        $character->user_id = $userId;
        $character->save();

        return ['id' => $character->id];
    }

    public function getCharacters() {
        return request()->user()->characters;
    }

    public function getCharacter(int $id) {
        $character = Character::where('id', $id)->first();

        if(is_null($character))
            return response('', 404);

        return $character;
    }
}
