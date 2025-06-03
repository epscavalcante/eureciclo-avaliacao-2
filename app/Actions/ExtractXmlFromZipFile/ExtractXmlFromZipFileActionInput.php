<?php

namespace App\Actions\ExtractXmlFromZipFile;

class ExtractXmlFromZipFileActionInput
{
    public function __construct(
        public readonly int $fileId
    ) {}
}
