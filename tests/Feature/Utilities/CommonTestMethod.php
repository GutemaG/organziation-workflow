<?php

namespace Tests\Feature\Utilities;

use App\Http\Controllers\Utilities\UserType;
use App\Models\Bureau;
use App\Models\User;
use Tests\TestCase;

class CommonTestMethod extends TestCase
{
    private  $url;
    private $modelNumber;

    public function __construct($url, $modelNumber) {
        parent::__construct();
        $this->url = $url;
        $this->modelNumber = $modelNumber;
    }

    private static function printSuccessMessage($message){
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n</info>");
        print_r("<info>  $message --- success.  \n</info>");
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n\n\n</info>");
    }

    private static function getUser($type){
        if(! in_array($type, UserType::all()))
            return null;
        else
            return User::where('type', $type)->first();
    }

    public function testUnauthenticatedUserCanAccess(){
        $this->get('/');
//       self::checkResponseOfUnauthenticatedUser($response);
//        $response = (new CommonTestMethod)->post($url);
//       self::checkResponseOfUnauthenticatedUser($response);
//
//        $response = (new CommonTestMethod)->get($url . '5/');
//       self::checkResponseOfUnauthenticatedUser($response);
//
//        $response = (new CommonTestMethod)->put($url . '5/', []);
//       self::checkResponseOfUnauthenticatedUser($response);
//
//        $response = (new CommonTestMethod)->delete($url . '5/');
//       self::checkResponseOfUnauthenticatedUser($response);
//       self::printSuccessMessage('unauthenticated user can access buildings or store ' . $modelName);
    }

    private static function checkResponseOfUnauthenticatedUser($response){
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    private static function assertUnauthorizedUser($response){
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }

    private static function assertAllUrlsForStaffAndReceptionUsers($type, $url){
       self::actingAs(self::getUser($type));
        $response = self::get($url);
       self::assertUnauthorizedUser($response);

        $response = self::post($url, []);
       self::assertUnauthorizedUser($response);

        for ($i = 0; $i < 10; $i++){
            $bureaus = Bureau::orderBy('name', 'asc')->limit(10);
            foreach ($bureaus as $bureau){
                $response = self::get($url . $bureau->id);
               self::assertUnauthorizedUser($response);

                $response = self::put($url . $bureau->id, []);
               self::assertUnauthorizedUser($response);

                $response = self::delete($url . $bureau->id);
               self::assertUnauthorizedUser($response);
            }
        }
    }

    public static function testStaffCanAccessUsers($url, $modelName){
       self::assertAllUrlsForStaffAndReceptionUsers(UserType::getStaff(), $url);
       self::printSuccessMessage('authenticated staff can access any buildings or can store ' . $modelName);

    }

    public static function testReceptionCanAccessUsers($url, $modelName){
       self::assertAllUrlsForStaffAndReceptionUsers(UserType::getReception(), $url);
       self::printSuccessMessage('authenticated reception can access any buildings or can store ' . $modelName);
    }
}
