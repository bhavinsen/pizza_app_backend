<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function testUserLoginsSuccessfully()
    {
        // $user = factory(User::class)->create([
        //     'email' => 'testlogin@user.com',
        //     'password' => bcrypt('123456789'),
        // ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => '123456789'];

        $this->json('POST', 'api/auth/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'access_token', 'token_type', 'expires_at'
            ]);
    }
}
