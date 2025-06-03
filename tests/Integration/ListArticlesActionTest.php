<?php

use App\Actions\ListArticles\ListArticlesAction;
use App\Actions\ListArticles\ListArticlesActionInput;
use App\Actions\ListArticles\ListArticlesActionOutput;
use App\Models\Article;

describe('List Articles Action Test', function () {

    test('Deve retornar uma lista vazia', function () {
        $action = new ListArticlesAction;
        $input = new ListArticlesActionInput(
            page: 1,
            perPage: 5
        );
        $output = $action->execute($input);
        expect($output)->toBeInstanceOf(ListArticlesActionOutput::class);
        expect($output->total)->toBe(0);
        expect($output->items)->toBeArray();
        expect($output->items)->toHaveLength(0);
    });

    test('Deve retornar uma lista com os parametros default', function () {
        Article::factory()->count(20)->create();
        $action = new ListArticlesAction;
        $input = new ListArticlesActionInput(
            page: 1,
            perPage: 5
        );
        $output = $action->execute($input);
        expect($output)->toBeInstanceOf(ListArticlesActionOutput::class);
        expect($output->total)->toBe(20);
        expect($output->items)->toBeArray();
        expect($output->items)->toHaveLength(5);
    });

    test('Deve retornar uma lista com os parametros customizados', function () {
        Article::factory()->count(10)->create();
        $action = new ListArticlesAction;
        $input = new ListArticlesActionInput(
            page: 2,
            perPage: 1
        );
        $output = $action->execute($input);
        expect($output)->toBeInstanceOf(ListArticlesActionOutput::class);
        expect($output->total)->toBe(10);
        expect($output->items)->toBeArray();
        expect($output->items)->toHaveLength(1);
    });
});
