<?php

namespace App\Middleware;

use SergiX44\Nutgram\Nutgram;

class ChooseLanguageMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        $bot->onText('Русский  🇷🇺', function (Nutgram $bot) {
            $bot->sendMessage('Вы выбрали русский язык.');
        });
        $bot->onText('O\'zbek 🇺🇿', function (Nutgram $bot) {
            $bot->sendMessage('Вы выбрали узбекский язык.');
        });
        $bot->onText('English 🇺🇸', function (Nutgram $bot) {
            $bot->sendMessage('Вы выбрали англиский язык.');
        });
        $next($bot);
    }
}
