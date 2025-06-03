<?php

use App\Models\File;

describe('File Model Tests', function () {

    test('Deve validar o getFilePath', function () {
        $fileModel = File::factory()->make([
            'folder' => 'folder_test',
            'file_name' => 'file.ext',
        ]);

        expect($fileModel->getFilePath())->toBe('folder_test/file.ext');
    });

    test('Deve validar o getPathOfExtractedFiles', function () {
        $fileModel = File::factory()->make([
            'folder' => 'folder_test',
            'file_name' => 'file.ext',
        ]);

        expect($fileModel->getPathOfExtractedFiles())->toBe('folder_test/extracted');
    });
});
