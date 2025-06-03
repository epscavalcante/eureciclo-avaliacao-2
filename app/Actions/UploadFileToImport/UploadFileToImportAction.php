<?php

namespace App\Actions\UploadFileToImport;

use App\Events\ImportArticleRequestedEvent;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadFileToImportAction
{
    public function execute(UploadFileToImportActionInput $input): void
    {
        if ($input->mimeType !== 'application/zip') {
            throw new Exception('Apenas arquivos ZIP são permitidos.');
        }

        if ($input->size > 900_000_000) {
            throw new Exception('Arquivo muito grande.');
        }

        $fileModel = File::create([
            'driver' => Storage::getDefaultDriver(),
            'folder' => Str::uuid()->toString(),
            'file_name' => Str::uuid()->toString().'.zip',
            'file_original_name' => $input->originalName,
        ]);

        $stream = fopen($input->pathName, 'rb');

        if ($stream === false) {
            throw new Exception('Erro ao abrir arquivo para leitura');
        }

        Storage::disk($fileModel->driver)->put(
            path: $fileModel->folder.'/'.$fileModel->file_name,
            contents: $stream,
        );

        ImportArticleRequestedEvent::dispatch($fileModel);
    }
}
