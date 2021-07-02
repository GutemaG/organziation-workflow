<?php


namespace Database\Factories;


use App\Http\Controllers\Utilities\UserType;
<<<<<<< HEAD
use Illuminate\support\Str;
use \App\Models\Affair;
use \App\Models\Procedure;
use Faker\Factory;
=======
use App\Models\Building;
use App\Models\Bureau;
use App\Models\User;

>>>>>>> master
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
<<<<<<< HEAD
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
=======

    public static function getLocation($latitude, $longitude){
        $location = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
        return json_encode($location);
    }

    public static function getBuildingNumberAndOfficeNumber() {
        $buildings = Building::select(['number', 'number_of_offices'])->get();
        $index = rand(1, count($buildings));
        $building = $buildings[$index - 1];
        return [
            'building_number' => $building->number,
            'office_number' => rand(1, $building->number_of_offices),
        ];
    }

    public static function getBureauId() {
        $bureau = Bureau::inRandomOrder()->first();
        // $index = rand(0, count($bureaus) - 1);
        if (empty($bureau))
            return null;
        return $bureau->id;
    }

    public static function getUserId() {
        $users = User::select('id')->get();
        $index = rand(0, count($users) - 1);
        return $users[$index]->id;
    }
>>>>>>> master
}
