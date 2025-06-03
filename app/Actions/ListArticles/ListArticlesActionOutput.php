<?php

namespace App\Actions\ListArticles;

class ListArticlesActionOutput
{
    /**
     * @param ListArticlesActionItemOutput[] $items
     */
    public function __construct(
        public readonly int $total = 1,
        public readonly array $items,
    ) {}
}
