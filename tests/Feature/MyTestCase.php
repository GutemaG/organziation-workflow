<?php


namespace Tests\Feature;


use App\Http\Controllers\Utilities\UserType;
use App\Models\OnlineRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\Feature\Utilities\ModelInstances;
use Tests\TestCase;

class MyTestCase extends TestCase
{
    use RefreshDatabase, ModelInstances;

    protected $url = '';
    protected $modelName = '';
    protected $responseName = '';

    public function setUp(): void
    {
        $this->responseName = Str::snake(str_replace('App\\Models\\', '', $this->modelName));
        parent::setUp();
        MyDatabaseSeeder::seed();
    }

    protected function printSuccessMessage(string $message){
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n</info>");
        print_r("<info>  $message --- success.  \n</info>");
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n\n\n</info>");
    }

    public function testUnauthenticatedGuestCanAccess(): void
    {
        $data = $this->randomData($this->modelName);
        $id = $data->id;

        $this->assertIndex();

        $response = $this->postJson($this->url, []);
        $this->assertUnauthenticatedRequestResponse($response);

        $this->assertShow($id, $data);

        $response = $this->putJson($this->url . $id, []);
        $this->assertUnauthenticatedRequestResponse($response);

        $response = $this->deleteJson($this->url . $id);
        $this->assertUnauthenticatedRequestResponse($response);

        $this->printSuccessMessage('Unauthenticated guest can\'t access online request passed ');
    }

    protected function assertUnauthenticatedRequestResponse(TestResponse $response): void
    {
        $response->assertJson([
            "message" => "Unauthenticated."
        ]);
    }

    public function testUnauthorizedUserCanAccess(): void
    {
        $this->testReceptionCanAccess();

        $this->testStaffCanAccess();
    }

    protected function testReceptionCanAccess(): void
    {
        $user = $this->getUser(UserType::reception());
        $this->unauthorizedRequest($user);
        $this->printSuccessMessage('Reception user can\'t access online request passed ');
    }

    protected function testStaffCanAccess(): void
    {
        $user = $this->getUser(UserType::staff());
        $this->unauthorizedRequest($user);
        $this->printSuccessMessage('Staff user can\'t access online request passed ');
    }

    protected function unauthorizedRequest(User $user): void
    {
        if ($user) {
            $this->actingAs($user);
            $data = $this->randomData($this->modelName);
            $id = $data->id;

            $this->assertIndex();

            $response = $this->postJson($this->url, []);
            $response->assertJson($this->unauthorizedResponse());

            $this->assertShow($id, $data);

            $response = $this->putJson($this->url . $id, []);
            $response->assertJson($this->unauthorizedResponse());

            $response = $this->deleteJson($this->url . $id);
            $response->assertJson($this->unauthorizedResponse());

        }
    }

    protected function unauthorizedResponse(): array
    {
        return [
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ];
    }

    protected function assertIndex(): void
    {
        $data = $this->getAllData(OnlineRequest::class)->toArray();
        $response = $this->getJson($this->url);
        $response->assertExactJson([
            'status' => 200,
            Str::plural($this->responseName) => $data,
        ]);
    }

    protected function assertShow($id, ?Model $data): void
    {
        $response = $this->getJson($this->url . $id);
        $response->assertJson([
            'status' => 200,
            $this->responseName => $data->toArray(),
        ]);
    }


}
