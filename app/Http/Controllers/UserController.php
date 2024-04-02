<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\RabbitMqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Events\Registered;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/*use MongoDB\Driver\Session;*/

class UserController extends Controller
{
    //
    public function getRegistration()
    {
        return view('register');
    }

    public function postRegistration(RegisterRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $user = $this->create($data);

        $rabbitMq = new RabbitMqService('rabbitmq',5672,'user','password');
        $rabbitMq->publish('testMail','verification');

        $user->sendEmailVerificationNotification();
        event(new Registered($user));
        $rabbitMq->consume('testMail', function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        });
        return redirect(url("login"))->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'city' => $data['city']
        ]);
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin(LoginRequest $request)
    {
        $request->validated();
        $credentials = $request->only('email','password');
        if (Auth::attempt($credentials)) {
            return redirect(url("main"))->withSuccess('Signed in');
        }
        return redirect('login')->withSuccess('Login details are not valid');
    }
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
