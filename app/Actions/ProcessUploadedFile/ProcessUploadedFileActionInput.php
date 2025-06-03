<?php

namespace App\Actions\ProcessUploadedFile;

class ProcessUploadedFileActionInput
{
    public function __construct(
        public readonly int $fileId
    ) {}
}
