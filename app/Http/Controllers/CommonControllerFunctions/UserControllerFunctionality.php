<?php


namespace App\Http\Controllers\CommonControllerFunctions;

use App\Http\Controllers\Utilities\UserType;
use PHPUnit\Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\Validation;
use App\Models\User;

class UserControllerFunctionality
{
    /**
     * Return a listing of the It team members, staff and reception for admin.
     * Return a listing of the staff and reception for it team member.
     *
     * @param $userType
     * @return array
     */
    public static function index($userType)
    {
        if($userType == UserType::getAdmin())
            $users = User::where('type', '!=', UserType::getAdmin())
                ->orderBy('user_name', 'asc')->get();
        elseif ($userType == UserType::getItTeamMember())
            $users = User::whereIn('type', [UserType::getReception(), UserType::getStaff()])
                ->orderBy('user_name', 'asc')->get();
        else
            return [
                'status' => 401,
                'error' => 'Unauthorized.',
            ];
        return [
            'status' => 200,
            'users' => empty($users) ? [] : $users->makeHidden(['updated_at']),
        ];
    }


    /**
     * Register new It team member and assign permissions.
     *
     * @param Request $request
     * @param $userType
     * @return array
     * @throws ValidationException
     */
    public static function store(Request $request, $userType)
    {
        $fields = $request->only(Fields::$user_fields);
        $validator = UserControllerFunctionality::validator($fields);

        if($validator->fails()){
            return [
                'status' => 400,
                'error' => $validator->errors(),
            ];
        }

        if($userType == UserType::getAdmin() && $fields['type'] == UserType::getAdmin())
            return [
              'status' => 400,
              'error' => ['type' => 'You can\'t register user with admin privilege.']
            ];
        elseif ($userType == UserType::getItTeamMember() &&
            (in_array($fields['type'], [UserType::getItTeamMember(), UserType::getAdmin()]))
        )
            return [
                'status' => 400,
                'error' => ['type' => 'You can\'t register user with admin or It team member privilege.']
            ];

        $user = UserControllerFunctionality::save_user($validator->validated());
        if(empty($user))
            return [
                'status' => 400,
                'error' => 'error occurred while registering.',
            ];

        return [
            'status' => 201,
            'user' => User::where('id', $user->id)
                ->first()->makeHidden(['updated_at']),
        ];
    }

    /**
     * validate incoming data both for storing and updating.
     *
     * @param $data
     * @param bool $update
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private static function validator($data, $update=false){
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
    private static function save_user($validator, $user=null){
        try{
            DB::beginTransaction();
            if($user){
                $user->update(Fields::filter_user_fields($validator));
            }
            else{
                $user = User::create(Fields::filter_user_fields($validator));
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
     * Return the specified user if it is not admin; if admin requested.
     * Return the specified user if it is not admin and it team member; if it team member requested.
     *
     * @param $id
     * @param $userType
     * @return array
     */
    public static function show($id, $userType)
    {
        if($userType == UserType::getAdmin())
            $user = User::where('id', $id)->where('type', '!=', UserType::getAdmin())->first();
        elseif ($userType == UserType::getItTeamMember())
            $user = User::where('id', $id)->whereIn('type', [UserType::getStaff(), UserType::getReception()])
                ->first();
        else
            return [
                'status' => 401,
                'error' => 'Unauthorized.',
            ];

        if(empty($user))
            return [
                'status' => 404,
                'error' => 'user doesn\'t exist',
            ];
        return [
            'status' => 200,
            'user' => $user->makeHidden(['updated_at']),
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
    private static function getUpdateFields(Request $request, User $user){
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


    private static function checkUserPrivilege(User $user, $userType, $newUserType){
        if($userType == UserType::getAdmin())
            if($user->type == UserType::getAdmin())
                return [
                    'status' => 400,
                    'error' => ['type' => 'You can\'t update user with admin privilege.']
                ];
            elseif($newUserType == UserType::getAdmin())
                return [
                    'status' => 400,
                    'error' => ['type' => 'You can\'t assassin user with admin privilege.']
                ];
            else
                return null;

        elseif ($userType == UserType::getItTeamMember())
            if (in_array($user->type, [UserType::getItTeamMember(), UserType::getAdmin()]))
                return [
                    'status' => 400,
                    'error' => ['type' => 'You can\'t update user with admin or It team member privilege.']
                ];
            elseif(in_array($newUserType, [UserType::getItTeamMember(), UserType::getAdmin()]))
                return [
                    'status' => 400,
                    'error' => ['type' => 'You can\'t assassin user with admin or It team member privilege.']
                ];
            else
                return null;

        else
            return null;

    }

    /**
     * Update a specific user information and permission
     *
     * @param Request $request
     * @param $id
     * @param UserType $userType
     * @return array
     * @throws ValidationException
     */
    public static function update(Request $request, $id, $userType)
    {
        $user = User::find($id);
        if(empty($user))
            return [
                'status' => 404,
                'error' => 'User doesn\'t exist.',
            ];

        $canBeUpdatedResult = UserControllerFunctionality::checkUserPrivilege($user, $userType, $request->get('type'));
        if(! empty($canBeUpdatedResult))
            return $canBeUpdatedResult;

        $fields = UserControllerFunctionality::getUpdateFields($request, $user);
        $validator = UserControllerFunctionality::validator($fields, true);
        if($validator->fails()){
            return [
                'status' => 400,
                'error' => $validator->errors(),
            ];
        }
        $user = UserControllerFunctionality::save_user($validator->validated(), $user);
        if(empty($user))
            return [
                'status' => 400,
                'error' => 'error occurred while updating.',
            ];

        return [
            'status' => 201,
            'user' => User::where('id', $user->id)
                ->first()->makeHidden(['updated_at']),
        ];
    }

    /**
     * Remove the specified user (precisely soft delete).
     *
     * @param $id
     * @param $userType
     * @return array|int[]
     */
    public static function destroy($id, $userType)
    {
        $user = User::where('id', $id)->where('type', '!=', UserType::getAdmin())->first();
        if(empty($user))
            return [
                'status' => 404,
                'error' => 'User doesn\'t exist.',
            ];

        if($userType == UserType::getAdmin() && $user->type == UserType::getAdmin())
            return [
                'status' => 400,
                'error' => 'Bad request.',
            ];
        elseif ($userType == UserType::getItTeamMember() &&
            in_array($user->type, [UserType::getItTeamMember(), UserType::getAdmin()])
        )
            return [
                'status' => 400,
                'error' => 'Bad request.',
            ];

        $user->delete();
        return [
            'status' => 200,
        ];
    }
}
