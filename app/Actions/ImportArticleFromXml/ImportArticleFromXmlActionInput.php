<?php

namespace App\Actions\ImportArticleFromXml;

class ImportArticleFromXmlActionInput
{
    public function __construct(
        public readonly int $fileId,
        public readonly string $xmlFilePath
    ) {}
}
