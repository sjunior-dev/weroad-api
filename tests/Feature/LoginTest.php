<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertSimilarJson(
                [
                    'errors' => [
                        'email' => ['The email field is required.'],
                        'password' => ['The password field is required.'],
                    ],
                    'message' => 'The email field is required. (and 1 more error)',
                ]
            );
    }

    public function testUserLoginsSuccessfully()
    {
        $email = 'test@login.com';
        $pass = 'test123#';
        $payload = [
            'email' => $email,
            'password' => $pass,
        ];
        User::factory(1)->create([
            'email' => $email,
            'password' => bcrypt($pass),
        ]);

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'apiToken',
                ],
            ]);
    }
}
