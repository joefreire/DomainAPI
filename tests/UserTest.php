<?php

use App\Models\User;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $user = User::where('email', 'test@json.com')->first();
        if (empty($user)) {
            $response = $this->call('POST', '/register', ['name' => 'TestPHPUnit', 'email' => 'test@json.com', 'password' => 'password']);
            $this->assertEquals(200, $response->status());
        }
        $this->seeInDatabase('users', ['email' => 'test@json.com']);
    }
    public function testFailCreateUser()
    {
        $response = $this->call('POST', '/register', ['name' => 'Test', 'email' => 'test', 'password' => 'teste1234']);
        $this->assertEquals(400, $response->status());
    }
    public function testLoginUser()
    {
        $response = $this->call('POST', '/login', ['email' => 'test@json.com', 'password' => 'password']);
        $this->assertEquals(200, $response->status());
    }
    public function testFailLoginUser()
    {
        $response = $this->call('POST', '/login', ['email' => 'test@json.com', 'password' => 'dsad']);
        $this->assertEquals(400, $response->status());
    }
}
