<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john.dow@example.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $this->json('POST', '/api/auth/signup', $payload)
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Successfully created user!'
            ]);
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('POST', '/api/auth/signup')
            ->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ]
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '123456789',
        ];

        $this->json('post', '/api/auth/signup', $payload)
            ->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'password' => ['The password confirmation does not match.'],
                ]
            ]);
    }
}
