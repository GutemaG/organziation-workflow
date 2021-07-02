<?php


namespace Tests\Feature\Utilities;


use App\Models\Building;
use App\Models\Bureau;
use Database\Factories\Utility;
use Faker\Factory;

class FakeDataGenerator
{
    public static function userData(){
        $faker = Factory::create();
        $data = [
            'user_name' => $faker->unique()->userName,
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail(),
            'phone' => Utility::getPhoneNumber(),
            'type' => Utility::getUserType(),
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];

        while (! empty(Building::where('user_name', $data['user_name'])->orWhere('email', $data['email'])->first())) {
            $data['user_name'] = $faker->unique()->userName;
            $data['email'] = $faker->unique()->safeEmail();
        }
        return $data;
    }

    public static function buildingData(){
        $faker = Factory::create();
        $data = [
            'name' => implode($faker->unique()->words(rand(2,6))),
            'number' => $faker->unique()->buildingNumber,
            'number_of_offices' => $faker->numberBetween(100, 900),
            'description' => $faker->paragraph(rand(6, 10)),
        ];

        while (! empty(Building::where('name', $data['name'])->orWhere('number', $data['number'])->first())) {
            $data['name'] = implode($faker->unique()->words(rand(2,6)));
            $data['number'] = $faker->unique()->buildingNumber;
        }
        return $data;
    }

    public static function bureauData() {
        $faker = Factory::create();

        $latitude = $faker->latitude();
        $longitude = $faker->longitude();
        $data = Utility::getBuildingNumberAndOfficeNumber();
        $data = [
            'name' => $faker->unique()->name(),
            'description' => $faker->paragraph(rand(5, 16)),
            'accountable_to' => Utility::getBureauId(),
            'location' => Utility::getLocation($latitude, $longitude),
            'building_number' => $data['building_number'],
            'office_number' => $data['office_number'],
        ];

        while (! empty(Bureau::where('name', $data['name'])->first())) {
            $data['name'] = $faker->unique()->name();
        }
        return $data;
    }

    public static function get($table) {
        switch ($table){
            case 'user':
                return self::userData();
                break;
            case 'building':
                return self::buildingData();
                break;
            case 'bureau':
                return self::bureauData();
                break;
            default:
                return null;
        }
    }

    public static function only($table, $fields=[]){
        $data = self::get($table);
        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($key, $fields);
        })->all();
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
