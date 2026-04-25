<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        $token = $user->createToken('ApiToken');

         // if fcm token is provided save it
         if($request->filled('fcm_token')){
            $token->accessToken->fcm_token = $request->fcm_token;
            $token->accessToken->save();
        }
        $data = [
            'user' => $user,
            'token'=>$token->plainTextToken
        ];

        return $this->api_success_massage('User Created Successfuly',$data);
    }

    public function login(LoginRequest $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return $this->api_error_massage('Client Login Failed');
    }

    $token = $user->createToken('ApiToken');

    if ($request->filled('fcm_token')) {
        $token->accessToken->fcm_token = $request->fcm_token;
        $token->accessToken->save();
    }

    $data = [
        'user' => $user,
        'token' => $token->plainTextToken
    ];

    return $this->api_success_massage('User Login Successfully', $data);
}


}
