<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

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
        $this->middleware('auth');
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
            $user->update(Fields::filterUserFields($data));
            // return Fields::filter_user_fields($data);
            $user->update($data);
            DB::commit();
            return response()->json([
                'status' => 200,
                'user' => User::find($user->id),
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

    /**
     * Change password of authenticated user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request) {
        $data = $request->only(['current_password', 'password', 'password_confirmation']);
        $validator = Validator::make($data,
            [
                'current_password' =>  ['required', 'string'],
                'password' =>  ['required', 'confirmed', 'string', Rules\Password::defaults()],
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->errors(),
            ]);
        }
        if (! Hash::check($data['current_password'], auth()->user()->password))
            return response()->json([
                'status' => 400,
                'error' => [
                    'current_password' => ['The password you entered didn\'t match with current password.'],
                ],
            ]);

        else {
            try {
                DB::beginTransaction();
                auth()->user()->update([
                    'password' => Hash::make($data['password']),
                ]);
                DB::commit();
                return response()->json([
                    'status' => 200,
                ]);
            }
            catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 400,
                    'error' => [
                        'error' => ["Something went wrong during updating password."]
                    ],
                ]);
            }
        }

    }
}
