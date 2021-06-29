<?php


namespace Database\Factories;


use App\Http\Controllers\Utilities\UserType;
use Illuminate\support\Str;
use \App\Models\Affair;
use \App\Models\Procedure;
use Faker\Factory;
class Utility
{
    /**
     * return random ethiopian phone number.
     *
     * @return string
     */
    public static function getPhoneNumber(){
        $phoneNumber = '+2519';

        for($i = 0; $i < 8; $i++)
            $phoneNumber .= rand(0,9);
        return $phoneNumber;
    }

    /**
     * return random user type.
     * To identify if user is it team member, staff or reception.
     * But it will not include admin type because we assume that admin is created only once.
     *
     * @return String
     */
    public static function getUserType(){
        $userTypes = [
            UserType::getItTeamMember(),
            UserType::getReception(),
            UserType::getStaff()
        ];

        return $userTypes[array_rand($userTypes)];
    }
    public static function test()
    {
        $faker = Factory::create();
        //Fields: [id, procedure_id, affair_id, name, description]
        $affairs_id = Affair::pluck('id');
        $procedures_id = Procedure::pluck('id')->toArray();
        $affair =$faker->randomElement($affairs_id, null);
        $name = '';
        $description='';
        if(empty($affair)){
           $name = Str::random(10);
           $description = Str::random(10);
        }
        else{

        }
        return [
            'affair_id'=>$affair,
            'procedure_id'=>$faker->randomElement($procedures_id),
            'name' =>$name,
            'description' =>$description,
        ];
    }
}
