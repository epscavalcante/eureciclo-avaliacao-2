<?php

namespace App\Services\MessageBroker;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQMessageBroker implements MessageBroker
{
    private ?AMQPStreamConnection $connection = null;

    private ?AMQPChannel $channel = null;

    public function publish(string $exchange, array $data): void
    {
        $this->connect();

        $this->channel->exchange_declare(
            exchange: $exchange,
            type: AMQPExchangeType::DIRECT,
            passive: false,
            durable: true,
            auto_delete: false
        );

        $this->channel->basic_publish(
            exchange: $exchange,
            msg: new AMQPMessage(
                body: json_encode($data),
                properties: [
                    'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                ]
            ),
        );

        $this->disconect();
    }

    private function connect(): void
    {
        if ($this->connection) {
            $this->channel = $this->connection->channel();

            return;
        }
        // dd(config('services.rabbitmq'));
        $this->connection = new AMQPStreamConnection(
            host: config('services.rabbitmq.host'),
            user: config('services.rabbitmq.user'),
            password: config('services.rabbitmq.password'),
            port: config('services.rabbitmq.port'),
            vhost: config('services.rabbitmq.vhost')
        );

        $this->channel = $this->connection->channel();
    }

    private function disconect(): void
    {
        $this->channel->close();

        $this->connection->close();
    }
}
