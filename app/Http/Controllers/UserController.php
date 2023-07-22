<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'string|required|unique:App\Models\User,name|max:255',
            'email' => 'email|required|unique:App\Models\User,email|max:255',
            'password' => ['required', 'string'],
        ]);

        $user = new User();
        $user->fill($validated);
        $user->password = Hash::make($validated['password']);
        $user->save();
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string'
            ],
            'password' => [
                'required', 
                'string'
            ],
        ]);

        $user = User::where('name', $validated['name'])->orWhere('email', $validated['name'])->first();
        
        if(is_null($user)) 
            return response('', 404);

        if(!Hash::check($validated['password'], $user->password))
            return response('', 400);

        PersonalAccessToken::where([['tokenable_type', 'App\Models\User'],['tokenable_id', $user->id]])->delete();
        $token = $user->createToken('api_token');

        return ['token' => $token->plainTextToken];
    }
}
