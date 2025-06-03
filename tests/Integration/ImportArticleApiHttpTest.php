<?php

use Illuminate\Http\UploadedFile;

describe('ImportArticles Api Http Test', function () {

    describe('Receives 422 - Unprocessable Entity', function () {
        test('Enviado nenhum arquivo`', function () {
            $response = $this->postJson(
                route('articles.import'),
                []
            );
            $response->assertUnprocessable();
            $response->assertJson([
                'message' => 'The file zip field is required.',
                'errors' => [
                    'file_zip' => [
                        'The file zip field is required.',
                    ],
                ],
            ]);
        });

        test('Enviado arquivo com mimetype diferente de ZIP`', function () {

            $file = UploadedFile::fake()->create('fake.pdf', 100);
            $response = $this->postJson(
                route('articles.import'),
                [
                    'file_zip' => $file,
                ]
            );
            $response->assertUnprocessable();
            $response->assertJson([
                'message' => 'The file zip field must be a file of type: zip.',
                'errors' => [
                    'file_zip' => [
                        'The file zip field must be a file of type: zip.',
                    ],
                ],
            ]);
        });

        test('Enviado arquivo ZIP com tamanho superior ao permitido`', function () {

            $file = UploadedFile::fake()->create('fake.zip', 9000001);
            $response = $this->postJson(
                route('articles.import'),
                [
                    'file_zip' => $file,
                ]
            );
            $response->assertUnprocessable();
            $response->assertJson([
                'message' => 'The file zip field must not be greater than 900000 kilobytes.',
                'errors' => [
                    'file_zip' => [
                        'The file zip field must not be greater than 900000 kilobytes.',
                    ],
                ],
            ]);
        });
    });

    describe('Receives 200 - OK', function () {
        test('Deve importar os xml', function () {
            $file = UploadedFile::fake()->create('file.zip', 345212);
            $response = $this->postJson(
                route('articles.import'),
                [
                    'file_zip' => $file,
                ]
            );
            $response->assertNoContent();
        });
    });
});
