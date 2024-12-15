<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('main.index')
    ->middleware(\App\Http\Middleware\MailboxCookie::class);
