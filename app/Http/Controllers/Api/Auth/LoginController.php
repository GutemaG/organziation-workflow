<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request){
            if(Auth::guard('sanctum')->check()){
                return response()->json([
                        'status' => 200,
                        'message' => 'you have already logged in',
                    ]);
            }

            $validator = $this->validator($request->only(['user_name', 'password']));

            if($validator->fails()){
                return response()->json([
                   'status' => 400,
                    'message' => $validator->errors(),
                ]);
            }

            $credentials = $validator->validated();
            if(!Auth::attempt($credentials)){
                return response()->json([
                    'status' => 400,
                    'message' => 'incorrect user name or password',
                ]);
            }

            $user = User::where('user_name', $credentials['user_name'])
                ->select(['id', 'user_name', 'first_name', 'last_name', 'email', 'phone', 'is_admin', 'is_active','created_at'])
                ->first();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 200,
                'message' => 'Successfully logged in',
                'user' => $user,
                'token' => $token,
            ]);
    }

    private function validator($data){
        return Validator::make($data, $this->rules());
    }

    private function rules(){
        return [
            'user_name' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
