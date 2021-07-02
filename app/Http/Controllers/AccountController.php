<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Rule;
use App\Models\User;

class AccountController extends Controller
{
    /**
     * Check if user is authenticated if not redirect him/her to login page.
     *
     * AccountController constructor.
     */
    public function __construct()
    {
            if($this->middleware(function ($request, $next){
                if(auth()->check())
                    return $next($request);
                return response()->redirectTo(route('login'));
            }));
    }

    /**
     * Update authenticated user data.
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        $fields =  self::getUpdateFields($request);
        $validator = Validator::make($fields, Rule::only(User::class, array_keys($fields)));
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
            $user->update($data);
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

    /**
     * Return only updated fields associated with their values.
     *
     * @param Request $request
     * @return array
     */
    private static function getUpdateFields(Request $request){
        $data = [];
        foreach ($request->only(Fields::except(User::class, ['password', 'password_confirmation', 'type'])) as $key => $item){
            if($request->get($key) != auth()->user()[$key])
                $data[$key] = $item;
        }
        return $data;
    }
}
