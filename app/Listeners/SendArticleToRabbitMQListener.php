<?php

namespace App\Listeners;

use App\Events\ArticleImportedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendArticleToRabbitMQListener implements ShouldQueue
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
    public function handle(ArticleImportedEvent $event): void
    {
        Log::info('Send article to RabbitMQ', $event->article->toArray());
    }
}
