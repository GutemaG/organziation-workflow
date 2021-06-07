<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Utilities\Fields;
use App\Http\Controllers\Api\Utilities\Validation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;


class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * check if user is authenticated through token
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next){
           if(!Auth::guard('sanctum')->check()){
               return response()->json([
                   'status' => 401,
                   'message' => 'Unauthorized',
               ]);
           }
           return $next($request);
        });
    }

    /**
     * check the user logged in is admin
     *
     * @return mixed
     */
    private function is_admin(){
        return auth('sanctum')->user()->is_admin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if(!$this->is_admin()){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }
        $users = User::select(['id', 'user_name', 'first_name', 'last_name', 'email', 'phone', 'is_admin', 'is_active'])
                    ->where('is_admin', false)->orderBy('user_name', 'asc')->get();
        return response()->json([
            'status' => 200,
            'message' => [
                'users' => $users,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if(!$this->is_admin()){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }
        $validator = $this->validator($request->only(Fields::all()));
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => [
                    'error' => $validator->errors(),
                ],
            ]);
        }
        $user = $this->save_user($validator->validated());
        if(empty($user))
            return response()->json([
                'status' => 400,
                'message' => 'error occurred while registering',
            ]);

        return response()->json([
            'status' => 201,
            'message' => 'user registered successfully',
        ]);
    }

    /**
     * validate incoming data
     *
     * @param $data
     * @param bool $update
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validator($data, $update=false){
        if($update)
            return Validator::make($data, Validation::update_rules());
        return Validator::make($data, Validation::rules());
    }


    /**
     * create or update user
     *
     * @param $validator
     * @param null $user
     * @return User|null
     */
    private function save_user($validator, $user=null){
        try{
            DB::beginTransaction();
            if($user){
                $user->update(Fields::filter_user_fields($validator));
                $user->permission()->update(Fields::filter_permission_fields($validator));
            }
            else{
                $user = User::create(Fields::filter_user_fields($validator));
                $user->permission()->create(Fields::filter_permission_fields($validator));
            }
            DB::commit();
            return $user;
        }
        catch (Exception $e){
            DB::rollBack();
            return null;
        }
    }

    /**
     * Display the specified user.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        if($this->is_admin()){
            $user = User::where('id', $id)->where('is_admin', false)->with(['permission'])->first();
            if(empty($user))
                return response()->json([
                    'status' => 404,
                    'message' => 'user doesn\'t exist',
                ]);
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'user' => $user
            ]);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized',
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if(!$this->is_admin()){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }

        $validator = $this->validator($request->only(Fields::except(['password_confirmation'])), true);
        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'message' => [
                    'error' => $validator->errors(),
                ],
            ]);
        }
        $user = $this->save_user($validator->validated(), $user);
        if(empty($user))
            return response()->json([
                'status' => 400,
                'message' => 'error occurred while updating user data',
                'user' => '',
            ]);

        return response()->json([
            'status' => 201,
            'message' => 'user data updated successfully',
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified user (precisely soft delete).
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if($this->is_admin()){
            $user = User::where('id', $id)->where('is_admin', false)->first();
            if(empty($user))
                return response()->json([
                    'status' => 404,
                    'message' => 'user doesn\'t exist',
                ]);
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => 'user delete successfully',
            ]);
        }
        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized',
        ]);

    }
}
