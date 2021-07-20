<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlineRequestTest extends TestCase
{
    public function testUpdate() {
        $user = User::where('type', UserType::staff())->inRandomOrder()->first();
        $this->actingAs($user);
        $response = $this->putJson('api/online-requests/1',[]);

        $response->dump();
    }
}
