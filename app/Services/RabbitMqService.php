<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqService
{
    protected $connection;
    protected $channel;
    public function __construct(string $host, int $port, string $user, string $password)
    {
        $this->connection = new AMQPStreamConnection($host,$port,$user,$password);
        $this->channel = $this->connection->channel();
    }

    public function publish( string $queueName, string $messageBody)
    {
        $this->channel->queue_declare($queueName,false,true,false,false);
        $message = new AMQPMessage($messageBody);
        $this->channel->basic_publish($message,'',$queueName);
    }

    public function consume( string $queueName, callable $callback)
    {
        try {
            $this->channel->queue_declare($queueName, false, true, false, false);
            $this->channel->basic_consume($queueName, '', false, true, false, false, $callback);

            while ($this->channel->is_consuming()) {
                $this->channel->wait();
            }
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
