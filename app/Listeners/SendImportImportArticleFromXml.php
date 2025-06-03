<?php

namespace App\Listeners;

use App\Actions\ImportArticleFromXml\ImportArticleFromXmlAction;
use App\Actions\ImportArticleFromXml\ImportArticleFromXmlActionInput;
use App\Events\UploadedFileProcessedEvent;
use Illuminate\Support\Facades\Storage;

class SendImportImportArticleFromXml
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UploadedFileProcessedEvent $event): void
    {
        $xmlsPaths = Storage::disk($event->file->driver)->allFiles($event->file->getPathOfXmlFiles());

        $action = new ImportArticleFromXmlAction;
        foreach ($xmlsPaths as $xmlPath) {
            $input = new ImportArticleFromXmlActionInput(
                fileId: $event->file->id,
                xmlFilePath: $xmlPath
            );
            $action->execute($input);
        }
    }
}
