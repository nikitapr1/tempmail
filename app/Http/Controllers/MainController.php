<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Mailbox;
use Illuminate\Support\Facades\Crypt; // мишний импорт

class MainController extends Controller
{

    public function index()
    {
        $uuid = session('uuid'); // вынести в константу или класс-enum
        dd(Mailbox::query()->find(1)->get()->address);
        $mailbox = Mailbox::where('uuid', $uuid)->first(); // сгенереировать ide helper
        $address = $mailbox->address;
        if ($mailbox === null) {
            return view("welcome", ['errorMessage' => 'Не удалось получить доступ к почтовому ящику']);

        }

        $emails = Email::query()->where('to', $address)->orderBy('date', 'desc')->get();


        return view("welcome", compact('address', 'emails'));
    }


}
