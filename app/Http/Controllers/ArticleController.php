<?php

namespace App\Http\Controllers;

use App\Actions\ListArticles\ListArticlesAction;
use App\Actions\ListArticles\ListArticlesActionInput;
use App\Actions\UploadFileToImport\UploadFileToImportAction;
use App\Actions\UploadFileToImport\UploadFileToImportActionInput;
use App\Http\Requests\ImportArticleRequest;
use App\Http\Requests\ListArticleRequest;
use App\Http\Resources\ListArticleResource;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

class ArticleController extends Controller
{
    public function import(ImportArticleRequest $request): Response
    {
        /** @var UploadedFile */
        $uploadedFile = $request->validated('file_zip');
        $uploadInput = new UploadFileToImportActionInput(
            pathName: $uploadedFile->getRealPath(),
            mimeType: $uploadedFile->getMimeType(),
            originalName: $uploadedFile->getClientOriginalName(),
            size: $uploadedFile->getSize()
        );
        $uploadAction = new UploadFileToImportAction;
        $uploadAction->execute($uploadInput);

        return response()->noContent();
    }

    public function list(ListArticleRequest $request): ListArticleResource
    {
        $action = new ListArticlesAction;
        $input = new ListArticlesActionInput(
            page: $request->validated('page', 1),
            perPage: $request->validated('per_page', 10),
        );
        $output = $action->execute($input);
        return new ListArticleResource(
            total: $output->total,
            items: $output->items
        );
    }
}
