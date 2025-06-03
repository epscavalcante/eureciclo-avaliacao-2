<?php

use App\Models\Article;

describe('ListArticles Api Http Test', function () {

    describe('Receives 422 - Unprocessable Entity', function () {
        test('Enviado nenhum query params inválidos`', function () {
            $response = $this->getJson(
                route(
                    name: 'articles.list',
                    parameters: [
                        'outro' => 'blalabla',
                        'page' => 'page',
                        'per_page' => 'per_page',
                    ]
                ),

            );
            $response->assertUnprocessable();
            $response->assertJson([
                'message' => 'The page field must be an integer. (and 1 more error)',
                'errors' => [
                    'page' => [
                        'The page field must be an integer.',
                    ],

                    'per_page' => [
                        'The per page field must be an integer.',
                    ],
                ],
            ]);
        });
    });

    describe('Receives 200 - OK', function () {
        test('Deve receber uma lista vazia', function () {
            $response = $this->getJson(
                route(
                    name: 'articles.list',
                    parameters: []
                ),
            );
            $response->assertOk();
            $response->assertJson(
                [
                    'data' => [
                        'total' => 0,
                        'items' => [],
                    ],
                ]
            );
        });

        test('Deve receber uma lista paginada', function () {
            Article::factory()->count(5)->create();
            $responsePage1 = $this->getJson(
                route(
                    name: 'articles.list',
                    parameters: [
                        'page' => 1,
                        'per_page' => 4,
                    ]
                ),
            );
            $responsePage1->assertOk();
            expect($responsePage1->json('data.total'))->toBe(5);
            expect($responsePage1->json('data.items'))->toHaveLength(4);

            $responsePage2 = $this->getJson(
                route(
                    name: 'articles.list',
                    parameters: [
                        'page' => 2,
                        'per_page' => 4,
                    ]
                ),
            );

            $responsePage2->assertOk();
            expect($responsePage2->json('data.total'))->toBe(5);
            expect($responsePage2->json('data.items'))->toHaveLength(1);
        });
    });
});
