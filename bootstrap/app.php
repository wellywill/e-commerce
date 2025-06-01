<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->validateCsrfTokens(except: [
            // Coba keduanya jika tidak yakin mana yang tepat
            'midtrans-callback',
            'e-commerce/public/midtrans-callback',
            // Jika Anda menggunakan Ngrok, URL lengkapnya seperti ini:
            'https://06c6-180-254-140-212.ngrok-free.app/e-commerce/public/midtrans-callback',

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
