<?php

use App\Actions\ExtractXmlFromZipFile\ExtractXmlFromZipFileAction;
use App\Actions\ExtractXmlFromZipFile\ExtractXmlFromZipFileActionInput;
use App\Events\XmlFilesImportedEvent;
use App\Listeners\SendArticleToBeImportedFromXml;
use App\Models\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

describe('ExtractXmlFromZipFile Action Test', function () {
    test('Deve falhar ao não encontrar o arquivo (model) a ser processado', function () {
        $action = new ExtractXmlFromZipFileAction;
        $input = new ExtractXmlFromZipFileActionInput(
            fileId: 1,
        );
        $action->execute($input);
    })->throws(ModelNotFoundException::class);

    test('Deve falhar ao não conseguir abrir o arquivo ZIP', function () {
        $file = File::factory()->create(['driver' => 'public', 'folder' => '0c45fce0-e901-4100-9173-6d8b4ad536d7']);
        Storage::fake($file->driver);

        $action = new ExtractXmlFromZipFileAction;
        $input = new ExtractXmlFromZipFileActionInput(
            fileId: 1,
        );
        $action->execute($input);
    })->throws(Exception::class, 'Erro ao abrir arquivo');

    test('Deve falhar ao não encontrar o arquivo (zip) a ser processado', function () {
        $file = File::factory()->create(['driver' => 'public', 'folder' => '0c45fce0-e901-4100-9173-6d8b4ad536d7']);
        Storage::fake($file->driver);

        $action = new ExtractXmlFromZipFileAction;
        $input = new ExtractXmlFromZipFileActionInput(
            fileId: 1,
        );
        $action->execute($input);
    })->throws(Exception::class, 'Erro ao abrir arquivo');

    test('Deve falhar ao processar o arquivo zip enviado', function () {
        $uploadFile = UploadedFile::fake()->create('fake.zip', 250);
        $fileModel = File::factory()->create([
            'driver' => 'public',
            'folder' => '0c45fce0-e901-4100-9173-6d8b4ad536d7',
            'file_name' => $uploadFile->getClientOriginalName(),
        ]);
        Event::fake();
        Storage::fake($fileModel->driver);
        Storage::disk($fileModel->driver)->putFileAs($fileModel->folder, $uploadFile, $fileModel->file_name);

        $action = new ExtractXmlFromZipFileAction;
        $input = new ExtractXmlFromZipFileActionInput(
            fileId: 1,
        );
        $action->execute($input);
        Event::assertDispatchedTimes(XmlFilesImportedEvent::class, 1);
        Event::assertListening(XmlFilesImportedEvent::class, SendArticleToBeImportedFromXml::class);
    });
});
