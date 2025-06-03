<?php

namespace App\Actions\ExtractXmlFromZipFile;

use App\Events\XmlFilesImportedEvent;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ExtractXmlFromZipFileAction
{
    public function execute(ExtractXmlFromZipFileActionInput $input): void
    {
        $file = File::query()->findOrFail($input->fileId);

        $storage = Storage::drive($file->driver);

        $zipPath = $storage->path($file->getFilePath());

        $zip = new ZipArchive;
        if ($zip->open($zipPath) !== true) {
            throw new Exception('Erro ao abrir arquivo');
        }

        $extractPath = $file->getPathOfExtractedFiles();
        $storage->makeDirectory($extractPath);
        $zip->extractTo($storage->path($extractPath));
        $zip->close();

        $xmlFilePaths = glob($storage->path($extractPath).'/*.xml');

        foreach ($xmlFilePaths as $xmlFilePath) {
            $xmlFileContent = file_get_contents($xmlFilePath);
            $xmlFileName = array_reverse(explode('/', $xmlFilePath))[0];
            $storage->put($file->folder.'\/xmls\/'.$xmlFileName, $xmlFileContent);
        }

        $storage->deleteDirectory($extractPath);

        XmlFilesImportedEvent::dispatch($file);
    }
}
