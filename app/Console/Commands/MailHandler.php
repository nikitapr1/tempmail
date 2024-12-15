<?php

namespace App\Console\Commands;

use App\Models\Email;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

// лишний
use PhpMimeMailParser;

class MailHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mail-handler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Handle incoming mails and save to database';

    /**
     * Execute the console command.
     */
    public function handle() //возр тип
    {
        $emailData = file_get_contents("php://stdin");

        $parser = new PhpMimeMailParser\Parser();
        $parser->setText($emailData);

        $name = $parser->getHeader('from');
        $from = $parser->getAddresses('from')[0]['address'];
        $to = $parser->getAddresses('to')[0]['address'];
        $subject = $parser->getHeader('subject');
        $body = $parser->getMessageBody('html');
        $date = Carbon::createFromFormat('D, d M Y H:i:s O', $parser->getHeader('date'), config('app.timezone'));

        Log::debug(json_encode([
            'name' => $name,
            'from' => $from,
            'to' => $to,
            'body' => $body,
            'date' => $date
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        Email::query()->create([ // ide helper
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'date' => $date
        ]);
    }
}
