<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;

class CarsTest extends \Tests\TestCase
{
    public function testGetOwnCarsWithoutAuthUser()
    {
        $response = $this->json('get', '/api/user/cars');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testGetOwnCarsByUser()
    {
        $user = User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        $userRepository = \Mockery::mock(\App\Repositories\User\UserCarsRepository::class);
        app()->instance(\App\Repositories\User\UserCarsRepository::class, $userRepository);

        $userRepository->shouldReceive('findByUserId')
            ->once()
            ->with($user->id)
            ->andReturn(collect());

        $carsRepository = \Mockery::mock(\App\Repositories\CarsRepository::class);
        app()->instance(\App\Repositories\CarsRepository::class, $carsRepository);

        $carsRepository->shouldReceive('getById')
            ->once()
            ->with([])
            ->andReturn(Collection::empty());

        $response = $this->json('get','/api/user/cars');

        $response->assertStatus(Response::HTTP_OK);
    }
}
