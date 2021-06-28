<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Utilities\FakeDataGenerator;
use Tests\TestCase;

class BureauTest extends TestCase
{
    private function printSuccessMessage($message){
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n</info>");
        print_r("<info>  $message --- success.  \n</info>");
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n\n\n</info>");
    }

    private function getUser($type){
        if(! in_array($type, UserType::all()))
            return null;
        else
            return User::where('type', $type)->first();
    }

    public function testIndex() {
        $this->actingAs($this->getUser(UserType::getAdmin()));
        $data = FakeDataGenerator::bureauData();
        $response = $this->post('api/bureaus', $data);
        dump($data);
        $response->dump();

    }
}
