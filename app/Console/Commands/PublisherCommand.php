<?php

namespace App\Console\Commands;

use App\Services\RabbitMqService;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class PublisherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     *
     */
    public function handle()
    {
        $rabbitMq = new RabbitMqService('rabbitmq',5672,'user','password');
        $rabbitMq->publish('tester','Test',);

/*        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, true, false, false);

        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";
        $channel->close();
        $connection->close();*/
    }
}
