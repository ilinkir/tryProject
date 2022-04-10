<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;

class AuthTest extends TestCase
{
    use WithFaker;

    public function testUserIsCreatedSuccessfully()
    {
        $payload = [
            'name' => 'test' . $this->faker->name,
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
        ];

        $this->json('post', '/api/sanctum/register', $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('token');
            });

        $this->assertDatabaseHas('users', Arr::only($payload, ['name', 'email']));
    }

    public function testCreateUserWithMissingParams()
    {
        $payload = [
            'name' => 'test' . $this->faker->name,
            'email' => $this->faker->email(),
        ];

        $this->json('post', '/api/sanctum/register', $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure(['errors']);
    }

    public function testMissingUserGetToken()
    {
        $payload = [
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
            'device_name' => $this->faker->userAgent(),
        ];

        $this->json('post', '/api/sanctum/token', $payload)
            ->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure(['error']);
    }

    public function testUserGetTokenSuccesfully()
    {
        $password = $this->faker->password();

        $payload = [
            'name' => 'test' . $this->faker->name,
            'email' => $this->faker->email(),
        ];

        User::query()->create(
            array_merge(
                $payload, ['password' => Hash::make($password)]
            )
        );


        $this->json('post', '/api/sanctum/token', array_merge($payload, ['password' => $password]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['token']);
    }
}
