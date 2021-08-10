<?php
namespace App\Http\Controllers;

use App\Http\Controllers\CommonControllerFunctions\UserControllerFunctionality;
use App\Http\Controllers\Utilities\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller{
    public function __construct()
    {
        if($this->middleware(function ($request, $next){
            if(auth()->check())
                return $next($request);
            return response()->redirectTo(route('login'));
        }));
    }

    public function index(){
        if(Gate::allows('is-admin'))
            return response()->json(UserControllerFunctionality::index(UserType::admin()));
        elseif (Gate::allows('is-it-team-member'))
            return response()->json(UserControllerFunctionality::index(UserType::supportiveStaff()));

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }

    public function store(Request $request){
        if(Gate::allows('is-admin'))
            return response()->json(UserControllerFunctionality::store($request, UserType::admin()));
        elseif (Gate::allows('is-it-team-member'))
            return response()->json(UserControllerFunctionality::store($request, UserType::supportiveStaff()));

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }

    public function show($id){
        if(Gate::allows('is-admin'))
            return response()->json(UserControllerFunctionality::show($id, UserType::admin()));
        elseif (Gate::allows('is-it-team-member'))
            return response()->json(UserControllerFunctionality::show($id, UserType::supportiveStaff()));

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }

    public function update(Request $request, $id){
        if(Gate::allows('is-admin'))
            return response()->json(UserControllerFunctionality::update($request, $id, UserType::admin()));
        elseif (Gate::allows('is-it-team-member'))
            return response()->json(UserControllerFunctionality::update($request, $id, UserType::supportiveStaff()));

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }

    public function destroy($id){
        if(Gate::allows('is-admin'))
            return response()->json(UserControllerFunctionality::destroy($id, UserType::admin()));
        elseif (Gate::allows('is-it-team-member'))
            return response()->json(UserControllerFunctionality::destroy($id, UserType::supportiveStaff()));

        return response()->json([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }
}
