<?php

namespace App\Listeners;

use App\Events\XmlFilesImportedEvent;
use App\Jobs\ImportArticleFromXmlJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class SendArticleToBeImportedFromXml implements ShouldQueue
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
    public function handle(XmlFilesImportedEvent $event): void
    {
        $xmlsPaths = Storage::disk($event->file->driver)->allFiles($event->file->getPathOfXmlFiles());

        $batch = Bus::batch([])->dispatch();

        foreach ($xmlsPaths as $xmlPath) {
            $batch->add(new ImportArticleFromXmlJob(
                fileId: $event->file->id,
                xmlPath: $xmlPath
            ));
        }
    }
}
