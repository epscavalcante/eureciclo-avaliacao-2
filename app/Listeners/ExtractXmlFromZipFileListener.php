<?php

namespace App\Listeners;

use App\Actions\ExtractXmlFromZipFile\ExtractXmlFromZipFileAction;
use App\Actions\ExtractXmlFromZipFile\ExtractXmlFromZipFileActionInput;
use App\Events\ZipFileUploadedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExtractXmlFromZipFileListener implements ShouldQueue
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
    public function handle(ZipFileUploadedEvent $event): void
    {
        $action = new ExtractXmlFromZipFileAction;
        $input = new ExtractXmlFromZipFileActionInput(
            fileId: $event->file->id,
        );
        $action->execute($input);
    }
}
