<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{

    protected  $user;
    protected  $userLoginData;
    public function getData()
    {
        $this->user = User::where('name', 'TestPHPUnit')->first();
        if (empty($this->user)) {
            $this->user = User::factory()->create();
        }
        $response = $this->call('POST', '/login', ['email' => $this->user->email, 'password' => 'password']);
        $this->assertEquals(200, $response->status());
        $this->userLoginData = json_decode($response->getContent());
    }
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
