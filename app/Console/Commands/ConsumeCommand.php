<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Mail\MailSend;
use App\Models\User;
use App\Services\RabbitMqService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

    protected $rabbitMqService;

    public function __construct()
    {
        parent::__construct();
        $this->rabbitMqService = new RabbitMqService('rabbitmq',5672,'user','password');
    }

    public function handle()
    {
        $this->rabbitMqService->consume('email',function ($message){
            $message = json_decode($message->body,true);
            $email = $message['email'];
            $fileName = $message['name'];
            Log::info('Получено сообщение из publish:', $message);
            Mail::to($email)->send(new MailSend($fileName));
        });
    }
}
