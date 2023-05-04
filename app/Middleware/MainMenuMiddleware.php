<?php

namespace App\Middleware;

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class MainMenuMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        $bot->sendMessage('Welcome! Choose your language.', [
            'reply_markup' => ReplyKeyboardMarkup::make()->addRow(
                KeyboardButton::make('lol'),
                KeyboardButton::make(__('buttonsLocale.Call')),
            )
        ]);
        $next($bot);
    }
}
