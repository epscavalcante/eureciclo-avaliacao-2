<?php

namespace App\Listeners;

use App\Events\ArticleImportedEvent;
use App\Services\MessageBroker\MessageBroker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendArticleToRabbitMQListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private readonly MessageBroker $messageBroker)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ArticleImportedEvent $event): void
    {
        Log::info('Send article to RabbitMQ', $event->article->toArray());
        $this->messageBroker->publish(
            exchange: 'articles.imported',
            data: $event->article->toArray()
        );
    }
}
