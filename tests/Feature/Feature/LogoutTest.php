<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LogoutTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@test.com']);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/auth/logout', $headers)->assertStatus(200);
    }
}
