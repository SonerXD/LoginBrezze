<?php
namespace App\Listeners;

use App\Events;
use Request;
use Illuminate\Auth\Events as LaravelEvents;
use Illuminate\Support\Facades\Log;

class LogActivity
{
    public function login(LaravelEvents\Login $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info("El usuario {$event->user->name} con correo:{$event->user->email} a iniciado sesion desde la IP: {$ip}", $event->user->only('id', 'email'));
    }

    public function logout(LaravelEvents\Logout $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info("El usuario {$event->user->name} con correo:{$event->user->email} cerro sesion desde la IP: {$ip}", $event->user->only('id', 'email'));
    }

    public function registered(LaravelEvents\Registered $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info("Usuario registrado con correo: {$event->user->email} desde la IP: {$ip}");
    }

    public function failed(LaravelEvents\Failed $event)
    {
        $ip = \Request::getClientIp(true);
        $this->info("El usuario {$event->credentials['email']} intento iniciar sesion pero fallo desde la IP: {$ip}", ['email' => $event->credentials['email']]);
    }

    protected function info(string $message, array $context = [])
    {
        //$class = class_basename($event::class);
        //$class = get_class($event);

        Log::info("{$message}", $context);
    }
}
