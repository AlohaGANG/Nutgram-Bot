<?php

namespace App\Handlers\Commands;

use App\InlineMenus\ChooseLanguageMenu;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class StartCommand extends Command
{
    protected string $command = 'start';
    protected ?string $description = 'Start command';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage('Welcome! Choose your language.', [
            'reply_markup' => ReplyKeyboardMarkup::make()->addRow(
                KeyboardButton::make('Русский  🇷🇺'),
                KeyboardButton::make('O\'zbek 🇺🇿'),
                KeyboardButton::make('English 🇺🇸'),
            )
        ]);
    }
}
