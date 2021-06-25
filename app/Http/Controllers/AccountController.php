<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Validation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function __construct()
    {
            if($this->middleware(function ($request, $next){
                if(auth()->check())
                    return $next($request);
                return response()->redirectTo(route('login'));
            }));
    }

    public function update(Request $request){User::withTrashed()->restore();
        $fields =  self::getUpdateFields($request);
        $validator = Validator::make($fields, Validation::update_rules(array_keys($fields)));
        if ($validator->fails()){
            return [
                'status' => 400,
                'error' => $validator->errors(),
            ];
        }
        $data = $validator->validated();

        try {
            $user = User::find(auth()->user()->getAuthIdentifier());
            DB::beginTransaction();
            $user->update(Fields::filter_user_fields($data));
            DB::commit();
            return response()->json([
                'status' => 200,
            ]);
        }
        catch (\Exception $e){
            DB::rollBack();
            return  response()->json([
                'status' => 400,
                'error' => [
                    'error' => ['something when\'t wrong during updating please retry again.'],
                ]
            ]);
        }
    }

    private static function getUpdateFields(Request $request){
        $fields = [];
        foreach ($request->only(Fields::except(['password', 'password_confirmation', 'type'])) as $key => $item){
            if($request->get($key) != auth()->user()[$key])
                $fields[$key] = $item;
        }
        return $fields;
    }
}
