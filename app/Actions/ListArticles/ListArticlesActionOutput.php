<?php

namespace App\Actions\ListArticles;

class ListArticlesActionOutput
{
    /**
     * @param  ListArticlesActionItemOutput[]  $items
     */
    public function __construct(
        public readonly int $total,
        public readonly array $items,
    ) {}
}
