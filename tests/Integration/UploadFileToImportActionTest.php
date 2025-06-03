<?php

use App\Actions\UploadFileToImport\UploadFileToImportAction;
use App\Actions\UploadFileToImport\UploadFileToImportActionInput;
use App\Events\ImportArticleRequestedEvent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

describe('UploadFileToImportAction Test', function () {
    test('Deve falhar ao enviar um arquivo que não ZIP', function () {
        Storage::fake();
        $file = UploadedFile::fake()->create('fake.pdf', 1234);
        $action = new UploadFileToImportAction;
        $input = new UploadFileToImportActionInput(
            pathName: $file->getRealPath(),
            mimeType: $file->getMimeType(),
            size: $file->getSize(),
            originalName: $file->getClientOriginalName(),
        );
        $action->execute($input);
    })->throws(Exception::class, 'Apenas arquivos ZIP são permitidos.');

    test('Deve falhar ao enviar um arquivo maior que o permitido', function () {
        Storage::fake();
        $file = UploadedFile::fake()->create('fake.zip', 99999999999);
        $action = new UploadFileToImportAction;
        $input = new UploadFileToImportActionInput(
            pathName: $file->getRealPath(),
            mimeType: $file->getMimeType(),
            size: $file->getSize(),
            originalName: $file->getClientOriginalName(),
        );
        $action->execute($input);
    })->throws(Exception::class, 'Arquivo muito grande.');

    test('Deve fazer o upload do arquivo', function () {
        Storage::fake();
        Event::fake();
        $file = UploadedFile::fake()->create('fake.zip', 1000);
        $action = new UploadFileToImportAction;
        $input = new UploadFileToImportActionInput(
            pathName: $file->getRealPath(),
            mimeType: $file->getMimeType(),
            size: $file->getSize(),
            originalName: $file->getClientOriginalName(),
        );
        $action->execute($input);
        Event::assertDispatchedTimes(ImportArticleRequestedEvent::class, 1);
    });
});
