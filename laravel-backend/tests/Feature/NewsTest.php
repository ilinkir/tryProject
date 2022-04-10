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
    public function testResponseListNewsReturnsDataInValidFormat()
    {
        $response = $this->json('get','/api/news');

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'news' => [
                    '*' => [
                        'id',
                        'title',
                        'code',
                        'preview_text',
                        'text',
                        'image_id',
                        'category_id',
                        'is_active',
                        'sort',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'last_page',
                'per_page',
                'current_page',
                'has_more_pages',
                'has_pages',
                'total',
                'filters' => [
                    'year' => [],
                    'categories',
                ],
            ]);
    }
}
