<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(then: fn () => Route::get('/', fn () => 'hello'))
    ->create();
