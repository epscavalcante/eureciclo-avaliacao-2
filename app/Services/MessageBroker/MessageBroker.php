<?php

namespace App\Services\MessageBroker;

interface MessageBroker
{
    public function publish(string $exchange, array $data): void;
}
