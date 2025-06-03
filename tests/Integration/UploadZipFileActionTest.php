<?php

use App\Actions\UploadZipFile\UploadZipFileAction;
use App\Actions\UploadZipFile\UploadZipFileActionInput;
use App\Events\ZipFileUploadedEvent;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

describe('UploadZipFileAction Test', function () {
    test('Deve falhar ao enviar um arquivo que não ZIP', function () {
        Storage::fake();
        $file = UploadedFile::fake()->create('fake.pdf', 1234);
        $action = new UploadZipFileAction;
        $input = new UploadZipFileActionInput(
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
        $action = new UploadZipFileAction;
        $input = new UploadZipFileActionInput(
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
        $action = new UploadZipFileAction;
        $input = new UploadZipFileActionInput(
            pathName: $file->getRealPath(),
            mimeType: $file->getMimeType(),
            size: $file->getSize(),
            originalName: $file->getClientOriginalName(),
        );
        $action->execute($input);
        Event::assertDispatchedTimes(ZipFileUploadedEvent::class, 1);
    });
});
