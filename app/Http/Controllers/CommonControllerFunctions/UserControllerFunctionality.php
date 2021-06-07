<?php


namespace App\Http\Controllers\CommonControllerFunctions;

use PHPUnit\Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Utilities\Fields;
use App\Http\Controllers\Api\Utilities\Validation;
use App\Models\User;

class UserControllerFunctionality extends Controller
{
    /**
     * return a listing of It team members but not admin.
     *
     * @return array
     */
    public function index()
    {
        $users = User::where('is_admin', false)->where('is_active', true)
            ->with(['permission'])->orderBy('user_name', 'asc')->get();
        return [
            'status' => 200,
            'users' => empty($users) ? [] : $users->makeHidden(['email_verified_at', 'updated_at']),
        ];
    }


    /**
     * Register new It team member and assign permissions.
     *
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->only(Fields::all()));
        if($validator->fails()){
            return [
                'status' => 400,
                'error' => $validator->errors(),
            ];
        }
        $user = $this->save_user($validator->validated());
        if(empty($user))
            return [
                'status' => 400,
                'error' => 'error occurred while registering.',
            ];

        return [
            'status' => 201,
            'user' => User::with(['permission'])->where('id', $user->id)
                ->first()->makeHidden(['updated_at', 'email_verified_at']),
        ];
    }

    /**
     * validate incoming data both for storing and updating.
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
     * Store or update user
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
                $user->markEmailAsVerified();
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
     * Display the specified user if it is not admin.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        $user = User::where('id', $id)->where('is_admin', false)->with(['permission'])->first();
        if(empty($user))
            return [
                'status' => 404,
                'message' => 'user doesn\'t exist',
            ];
        return [
            'status' => 200,
            'user' => $user->makeHidden(['updated_at', 'email_verified_at']),
        ];
    }


    /**
     * Remove user_name and email if they are not updated so they don't have to be updated
     * and if we didn't do this it will fail unique validation
     *
     * @param Request $request
     * @param User $user
     * @return array
     */
    private function getUpdateFields(Request $request, User $user){
        if(
            $request->get('email') == $user->email &&
            $request->get('user_name') == $user->user_name
        )
            return $request->only(Fields::except(['password_confirmation', 'email', 'user_name']));
        else if($request->get('email') == $user->email)
            return $request->only(Fields::except(['password_confirmation', 'email']));
        else if($request->get('user_name') == $user->user_name)
            return $request->only(Fields::except(['password_confirmation', 'user_name']));
        else
            return $request->only(Fields::except(['password_confirmation']));
    }


    /**
     * Update a specific user information and permission
     *
     * @param Request $request
     * @param User $user
     * @return array
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        $fields = $this->getUpdateFields($request, $user);
        $validator = $this->validator($fields, true);
        if($validator->fails()){
            return [
                'status' => 400,
                'error' => $validator->errors(),
            ];
        }
        $user = $this->save_user($validator->validated(), $user);
        if(empty($user))
            return [
                'status' => 400,
                'error' => 'error occurred while updating.',
            ];

        return [
            'status' => 201,
            'user' => User::with(['permission'])->where('id', $user->id)
                ->first()->makeHidden(['updated_at', 'email_verified_at']),
        ];
    }

    /**
     * Remove the specified user (precisely soft delete).
     *
     * @param $id
     * @return array|int[]
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->where('is_admin', false)->first();
        if(empty($user))
            return [
                'status' => 404,
                'error' => 'User doesn\'t exist.',
            ];
        $user->delete();
        return [
            'status' => 200,
        ];
    }
}
