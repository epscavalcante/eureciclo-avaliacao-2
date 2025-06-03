<?php

namespace App\Actions\ListArticles;

use App\Models\Article;

class ListArticlesAction
{
    public function execute(ListArticlesActionInput $input): ListArticlesActionOutput
    {
        $articlesCollectionModel = Article::query()->paginate(
            perPage: $input->perPage,
            page: $input->page
        );
        $articlesTotal = $articlesCollectionModel->total();
        $articleModels = $articlesCollectionModel->items();
        $articlesOutputItems = array_map(
            callback: fn (Article $article) => new ListArticlesActionItemOutput(
                id: $article->id,
                date: $article->data,
                title: $article->titulo
            ),
            array: $articleModels
        );

        return new ListArticlesActionOutput(
            total: $articlesTotal,
            items: $articlesOutputItems
        );
    }
}
