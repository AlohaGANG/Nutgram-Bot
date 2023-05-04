<?php

namespace App\Middleware;

use App\Conversations\BotMenuConversation;
use SergiX44\Nutgram\Middleware\Link;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;

class ChooseLanguageMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        $bot->onText('Русский  🇷🇺', function (Nutgram $bot) {
            app()->setLocale('ru');
            BotMenuConversation::begin($bot);
        });
        $bot->onText('O\'zbek 🇺🇿', function (Nutgram $bot) {
            app()->setLocale('uz');
            BotMenuConversation::begin($bot);
        });
        $bot->onText('English 🇺🇸', function (Nutgram $bot) {
            app()->setLocale('en');
            BotMenuConversation::begin($bot);
        });
        $next($bot);
    }
}
