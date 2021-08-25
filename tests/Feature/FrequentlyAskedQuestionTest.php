<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\FrequentlyAskedQuestion;
use App\Models\User;

class FrequentlyAskedQuestionTest extends MyTestCase
{
    protected string $url = '/api/faqs';

    protected bool $defaultTest = false;

    public function testIndex(): void
    {
        $faqs = FrequentlyAskedQuestion::orderBy('question', 'asc')->get()->toArray();
        $this->getJson($this->url)->assertExactJson(['status' => 200,'faqs' => $faqs]);
        $this->printSuccessMessage('faq index method passed ');
    }

    public function testStore(): void
    {
        $this->assertAuthorizationAndAuthentication($this->url, 'post');
        $user = $this->getUser(UserType::staff());
        $this->assertFieldRequiredValidation($user);
        $data = ['question' => 'this is test question?', 'answer' => 'this is test answer.'];
        $response = $this->postJson($this->url, $data);
        $faq = FrequentlyAskedQuestion::where('question', $data['question'])->get()->first()->toArray();
        $this->assertDatabaseHas('frequently_asked_questions', $data);
        $response->assertExactJson(['status' => 200, 'faq' => $faq]);
        $this->postJson($this->url, $data)->assertExactJson([
            'status' => 422,
            'error' => [
                'question' => ["The question has already been taken."],
            ]
        ]);
        $this->printSuccessMessage('faq store method passed ');
    }

    public function testShow(): void
    {
        $faq = $this->randomData(FrequentlyAskedQuestion::class);
        $this->getJson("$this->url/$faq->id")->assertExactJson(['status' => 200, 'faq' => $faq->toArray()]);
        $this->printSuccessMessage('faq show method passed ');
    }

    public function testUpdate(): void
    {
        $faq = $this->randomData(FrequentlyAskedQuestion::class);
        $this->assertAuthorizationAndAuthentication("$this->url/$faq->id", 'put');
        $user = $this->getUser(UserType::staff());
        $this->assertFieldRequiredValidation($user, true, "$this->url/$faq->id");
        $this->actingAs($user);
        $faq->answer = "this is changer answer for testing purpose.";
        $this->putJson("$this->url/$faq->id", ['question' => $faq->question, 'answer' => $faq->answer])
                ->assertExactJson(['status' => 200, 'faq' => $faq->toArray()]);
        $this->assertDatabaseHas('frequently_asked_questions', [
            'id' => $faq->id,
           'question' => $faq->question,
           'answer' => 'this is changer answer for testing purpose.',
        ]);
        $this->printSuccessMessage('faq update method passed ');
    }

    public function testDestroy(): void
    {
        $faq = $this->randomData(FrequentlyAskedQuestion::class);
        $this->assertAuthorizationAndAuthentication("$this->url/$faq->id", 'delete');
        $user = $this->getUser(UserType::staff());
        $this->actingAs($user);
        $this->deleteJson("$this->url/$faq->id")->assertExactJson(['status' => 200,]);
        $this->assertSoftDeleted($faq);
        $this->printSuccessMessage('faq destroy method passed ');
    }

    /**
     * @param string $url
     * @param string $method
     * @return void
     */
    private function assertAuthorizationAndAuthentication(string $url, string $method): void
    {
        $this->checkAuthentication($method, $url);
        $usersType = [UserType::admin(), UserType::reception(), UserType::itTeam()];
        $user = $this->getUser($usersType[array_rand($usersType)]);
        $this->checkAuthorization($user, $method, $url);
    }

    /**
     * @param string $method
     * @param string $url
     */
    private function checkAuthentication(string $method, string $url): void
    {
        switch ($method) {
            case 'post':
                $this->postJson($url)->assertExactJson(['message' => 'Unauthenticated.',]);
                break;
            case 'delete':
                $this->deleteJson($url)->assertExactJson(['message' => 'Unauthenticated.',]);
                break;
            default:
                $this->putJson($url)->assertExactJson(['message' => 'Unauthenticated.',]);
                break;
        }
    }

    /**
     * @param User $user
     * @param string $method
     * @param string $url
     */
    private function checkAuthorization(User $user, string $method, string $url): void
    {
        $this->actingAs($user);
        switch ($method) {
            case 'post':
                $this->postJson($url)->assertExactJson($this->unauthorizedResponse());
                break;
            case 'delete':
                $this->deleteJson($url)->assertExactJson($this->unauthorizedResponse());
                break;
            default:
                $this->putJson($url)->assertExactJson($this->unauthorizedResponse());
                break;
        }
    }

    /**
     * @param User $user
     * @param bool $update
     * @param string|null $url
     */
    private function assertFieldRequiredValidation(User $user, bool $update=false, string $url=null): void
    {
        $this->actingAs($user);
        if ($update)
            $response = $this->putJson($url);
        else
            $response = $this->postJson($this->url);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'question' => ["The question field is required."],
                'answer' => ["The answer field is required."]
            ]
        ]);
    }


}
