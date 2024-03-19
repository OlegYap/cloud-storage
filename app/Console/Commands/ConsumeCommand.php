<?php

namespace App\Console\Commands;

use App\Services\RabbitMqService;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:consume';

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
        $rabbitMq->consume('tester', function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        });


        /*$connection = new AMQPStreamConnection('rabbitmq', 5672, 'user', 'password');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $channel->basic_consume('hello', '', false, true, false, false, $callback);

        try {
            $channel->consume();
        } catch (\Throwable $exception) {
            echo $exception->getMessage();
        }*/
    }
}
