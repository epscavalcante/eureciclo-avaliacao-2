<?php

namespace App\Actions\ListArticles;

class ListArticlesActionItemOutput
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $date,
        public readonly ?string $title,
    ) {}
}
