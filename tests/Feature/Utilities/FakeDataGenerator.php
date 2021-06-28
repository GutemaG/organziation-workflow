<?php


namespace Tests\Feature\Utilities;


use App\Models\Building;
use Database\Factories\Utility;
use Faker\Factory;
use Illuminate\Support\Str;

class FakeDataGenerator
{
    public static function userData(){
        $faker = Factory::create();
        return [
            'user_name' => $faker->unique()->name(),
            'first_name' => $faker->name(),
            'last_name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'phone' => Utility::getPhoneNumber(),
            'type' => Utility::getUserType(),
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
    }

    public static function buildingData(){
        $faker = Factory::create();
        $data = [
            'number' => $faker->unique()->buildingNumber,
            'number_of_offices' => $faker->numberBetween(100, 900),
        ];
        while (true){
            if (empty(Building::where('number', $data['number'])->first()))
                break;
            else
                $data['number'] = $faker->unique()->buildingNumber;
        }
        return $data;
    }

    public static function bureauData() {
        $faker = Factory::create();

        $latitude = $faker->latitude();
        $longitude = $faker->longitude();
        $data = Utility::getBuildingNumberAndOfficeNumber();
        $buildingNumber = $data['building_number'];
        $officeNumber = $data['office_number'];
        $sentences = $faker->sentences(rand(5, 16));
        $paragraph = implode($sentences); dump($buildingNumber);
        return [
            'name' => $faker->unique()->name(),
            'description' => $paragraph,
            'accountable_to' => Utility::getBureauId(),
            'location' => Utility::getLocation($latitude, $longitude),
            'building_number' => $buildingNumber,
            'office_number' => "$officeNumber",
        ];
    }

    public static function userDataOnly($fields=[]){
        $data = self::userData();
        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($key, $fields);
        })->all();
    }

    public static function userDataExcept($fields=[]){
        $data = self::userData();
        return collect($data)->filter(function ($value, $key) use ($fields) {
            return !in_array($key, $fields);
        })->all();
    }

    public static function buildingDataOnly($fields=[]){
        $data = self::buildingData();
        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($key, $fields);
        })->all();
    }
}
