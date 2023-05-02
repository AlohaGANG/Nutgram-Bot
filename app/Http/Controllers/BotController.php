<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class BotController extends Controller
{
    public function __invoke(Nutgram $bot)
    {
        $bot = new Nutgram('5974423828:AAFU0qFk_6ZYekmk0BjHlw2JFMQuuvVHUd0');
        $bot->onCommand('start', function (Nutgram $bot) {
            return $bot->sendMessage('Hello, world!');
        })->description('The start command!');

        $bot->run();
    }
}
