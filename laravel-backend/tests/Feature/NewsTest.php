<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class NewsTest extends TestCase
{
    /**
     * Get List News, Filters
     *
     * @return void
     */ // Написать тест на получение новостей, добавление с авторизацией, только определенные пользаки могут... , изучить моки, стабы
    public function testResponseListNews()
    {
        $response = $this->get('/api/news');

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'news' => '*'
            ]);
    }
}
