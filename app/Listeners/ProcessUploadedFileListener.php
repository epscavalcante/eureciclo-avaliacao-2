<?php

namespace App\Listeners;

use App\Actions\ProcessUploadedFile\ProcessUploadedFileAction;
use App\Actions\ProcessUploadedFile\ProcessUploadedFileActionInput;
use App\Events\ImportArticleRequestedEvent;

class ProcessUploadedFileListener
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
    public function handle(ImportArticleRequestedEvent $event): void
    {
        $action = new ProcessUploadedFileAction;
        $input = new ProcessUploadedFileActionInput(
            fileId: $event->file->id,
        );
        $action->execute($input);
    }
}
