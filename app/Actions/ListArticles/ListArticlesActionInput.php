<?php

namespace App\Actions\ListArticles;

class ListArticlesActionInput
{
    public function __construct(
        public readonly ?int $page = 1,
        public readonly ?int $perPage = 5,
    ) {}
}
