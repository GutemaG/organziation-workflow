<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\CommonControllerFunctions\UserControllerFunctionality;
use App\Models\User;


class UserController extends UserControllerFunctionality
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            if(! auth()->check())
                return response()->redirectTo(route('login'));
            return $next($request);
        });
    }

    /**
     * Display a listing of the It team members but not admin.
     * It is only allowed for admin.
     *
     * @return JsonResponse
     */
    public function index()
    {
        // return Auth::user();

        if(! Gate::allows('is-admin'))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
                
            ]);

        return response()->json(parent::index());
    }


    /**
     * Register new It team member and assign permission.
     * It is only allowed for admin.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException it will not throw validation Exception because it has been handled.
     */
    public function store(Request $request)
    {
        if(! Gate::allows('is-admin'))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        return response()->json(parent::store($request));
    }


    /**
     * Display the specified It team member but not admin.
     * It is only allowed for admin.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        if(! Gate::allows('is-admin'))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);

        return response()->json(parent::show($id));
    }


    /**
     * Update the specified It team member information and permission in storage.
     * It is only allowed for admin.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        if(! Gate::allows('is-admin'))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        return response()->json(parent::update($request, $user));
    }

    /**
     * Remove the specified user (precisely soft delete).
     * It is only allowed for admin.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if(! Gate::allows('is-admin'))
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized.',
            ]);
        return response()->json(parent::destroy($id));
    }
}
