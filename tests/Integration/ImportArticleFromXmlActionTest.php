<?php

use App\Actions\ImportArticleFromXml\ImportArticleFromXmlAction;
use App\Actions\ImportArticleFromXml\ImportArticleFromXmlActionInput;
use App\Events\ArticleImportedEvent;
use App\Listeners\SendArticleToRabbitMQListener;
use App\Models\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

describe('ImportArticleFromXmlAction Test', function () {
    test('Deve falhar ao não encontrar o arquivo enviado', function () {
        Storage::fake();
        $action = new ImportArticleFromXmlAction;
        $input = new ImportArticleFromXmlActionInput(
            fileId: 1,
            xmlFilePath: '/var/www/storage/fake.xml',
        );
        $action->execute($input);
    })->throws(ModelNotFoundException::class);

    test('Deve falhar ao não encontrar o arquivo xml', function () {
        $file = File::factory()->create(['driver' => 'public']);
        Storage::fake($file->driver);
        $action = new ImportArticleFromXmlAction;
        $input = new ImportArticleFromXmlActionInput(
            fileId: $file->id,
            xmlFilePath: '/var/www/storage/fake.xml',
        );
        $action->execute($input);
    })->throws(Exception::class, 'XML file not found');

    test('Deve salvar uma publicação através do XML', function () {
        $file = File::factory()->create(['driver' => 'public', 'folder' => '0c45fce0-e901-4100-9173-6d8b4ad536d7']);

        Storage::fake($file->driver);
        Event::fake();
        $xmlString = <<<XML
            \u{FEFF}<xml><article id="41546136" name="RESO 1632_ Dispoe ad referendum " idOficio="10783720" pubName="DO1" artType="Resolução" pubDate="02/01/2025" artClass="">
            <body>
                <Identifica><![CDATA[ RESOLUÇÃO Nº 1.632, DE 30 DE DEZEMBRO DE 2024]]></Identifica>
                <Data><![CDATA[]]></Data>
                <Ementa><![CDATA[ Dispõe, ad referendum do Plenário, sobre os procedimentos para ingresso e contratação de servidores no âmbito do Sistema CFMV/CRMVs.]]></Ementa>
                <Titulo />
                <SubTitulo />
                <Texto><![CDATA[<p class="identifica">RESOLUÇÃO Nº 1.632, DE 30 DE DEZEMBRO DE 2024</p><p class="ementa">Dispõe, ad referendum do Plenário...</p>]]></Texto>
            </body>
            <Midias />
            </article></xml>
            XML;
        $path = "{$file->getPathOfXmlFiles()}/file.xml";
        Storage::disk($file->driver)->put($path, $xmlString);

        $action = new ImportArticleFromXmlAction;
        $input = new ImportArticleFromXmlActionInput(
            fileId: $file->id,
            xmlFilePath: $file->getPathOfXmlFiles().'/file.xml',
        );
        $action->execute($input);
        Event::assertDispatchedTimes(ArticleImportedEvent::class, 1);
        Event::assertListening(ArticleImportedEvent::class, SendArticleToRabbitMQListener::class);
        $this->assertDatabaseCount('articles', 1);
    });
});
