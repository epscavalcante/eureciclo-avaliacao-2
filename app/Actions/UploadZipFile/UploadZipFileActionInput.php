<?php

namespace App\Actions\UploadZipFile;

class UploadZipFileActionInput
{
    public function __construct(
        public readonly string $pathName,
        public readonly string $mimeType,
        public readonly string $originalName,
        public readonly int $size,
    ) {}
}
