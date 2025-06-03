<?php

namespace App\Jobs;

use App\Actions\ImportArticleFromXml\ImportArticleFromXmlAction;
use App\Actions\ImportArticleFromXml\ImportArticleFromXmlActionInput;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ImportArticleFromXmlJob implements ShouldQueue
{
    use Batchable, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $fileId,
        private readonly string $xmlPath
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $action = new ImportArticleFromXmlAction;
        $input = new ImportArticleFromXmlActionInput(
            fileId: $this->fileId,
            xmlFilePath: $this->xmlPath
        );
        $action->execute($input);
    }
}
