<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'sometimes|required',
            'abilities' => 'sometimes|array',
        ]);

        $user = User::where('email', request('email'))->first();


        if ($user && Hash::check(request('password'), $user->password)) {
            $device_name =request()->post('device_name',request()->userAgent());
           $token= $user->createToken($device_name, request('abilities'));


           return response()->json([
            'success'=>true,
               'token'=>$token->plainTextToken,
                'user'=>$user
           ],201);
        }

        return response()->json([
            'success'=>false,
            'message' => 'The provided credentials are incorrect.'
        ], 401);

    }

    public function destroy($token=null)
    {
        $user=auth()->guard('sanctum')->user();

        if(!$token){
            $user->currentAccessToken()->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Token deleted successfully'
            ],200);
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if (
            $user->id == $personalAccessToken->tokenable_id &&
            get_class($user) == $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
            return response()->json([
                'success'=>true,
                'message'=>'Token deleted successfully'
            ],200);
        }

        return response()->json([
            'success'=>false,
            'message'=>'Token not found'
        ],404);
    }

    public function clearTokens()
    {
        $user=auth()->guard('sanctum')->user();
        $user->tokens()->delete();

        return response()->json([
            'success'=>true,
            'message'=>'Tokens deleted successfully'
        ],200);
    }
}
