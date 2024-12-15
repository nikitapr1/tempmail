<?php

namespace App\Http\Middleware;

use App\Models\Mailbox;
use Closure;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt; // лишний
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class MailboxCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {

        if ($request->hasCookie('uuid')) { // вынести в класс enum
            if (!session('uuid'))
            {
                session(['uuid' => $request->cookie('uuid')]); // вынести в класс enum
            }
            return $next($request);
        }

        $attempt = 0;
        $uuid = (string) Str::uuid();

        while (true) {
            try {
                $address = preg_replace('/@example\..*/', "@".env("APP_DOMAIN"), fake()->unique()->safeEmail);
                $mailbox = new Mailbox();
                $mailbox->address = $address;
                $mailbox->uuid = $uuid;
                $mailbox->saveOrFail();

            } catch (UniqueConstraintViolationException) {
                $attempt++;
            }

            if ($attempt > 10) {
                $mailbox = null;
                throw new \Exception('Не удалось создать уникальный адрес');
            }

            if ($mailbox->id) {
                break;
            }

        }

        session(['uuid' => $uuid]); // вынести в класс enum
        return $next($request)->withCookie(cookie()->forever('uuid', $uuid)); // вынести в класс enum
    }


}
