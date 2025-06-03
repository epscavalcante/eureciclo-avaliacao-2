<?php

namespace App\Actions\ImportArticleFromXml;

use App\Events\ArticleImportedEvent;
use App\Models\Article;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ImportArticleFromXmlAction
{
    public function execute(ImportArticleFromXmlActionInput $input): void
    {
        $file = File::query()->findOrFail($input->fileId);
        $storage = Storage::disk($file->driver);

        $xmlString = $storage->get($input->xmlFilePath);
        if (is_null($xmlString)) {
            throw new Exception('XML file not found');
        }

        $xml = simplexml_load_string($xmlString);
        $articleData = [
            'file_id' => $file->id,
            'identificacao' => $this->getXmlValueOrAttribute($xml->article->body, ['Identifica'], []) ?? null,
            'data' => $this->getXmlValueOrAttribute($xml->article->body, ['Data'], []) ?? $this->getXmlValueOrAttribute($xml->article, [], ['pubDate']),
            'ementa' => $this->getXmlValueOrAttribute($xml->article->body, ['Ementa'], []) ?? null,
            'titulo' => $this->getXmlValueOrAttribute($xml->article->body, ['Titulo'], []) ?? null,
            'subtitulo' => $this->getXmlValueOrAttribute($xml->article->body, ['SubTitulo'], []) ?? null,
            'texto' => $this->getXmlValueOrAttribute($xml->article->body, ['Texto'], []) ?? null,
            'metadata' => json_decode(json_encode($xml, 1), true),
        ];

        $articleModel = Article::create($articleData);

        ArticleImportedEvent::dispatch($articleModel);
    }

    public function getXmlValueOrAttribute(SimpleXMLElement $baseNode, array $elementPaths = [], array $attributeNames = []): ?string
    {
        foreach ($elementPaths as $path) {
            if (isset($baseNode->$path) && strlen(trim((string) $baseNode->$path)) > 0) {
                return trim((string) $baseNode->$path);
            }
        }

        foreach ($attributeNames as $attr) {
            if (isset($baseNode[$attr]) && strlen(trim((string) $baseNode[$attr])) > 0) {
                return trim((string) $baseNode[$attr]);
            }
        }

        return null;
    }
}
