<?php

namespace App\Handlers\Commands;

use App\InlineMenus\ChooseLanguageMenu;
use App\Models\TelegramUser;
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
        $chatId = $bot->message()->chat->id;
        $user = TelegramUser::where('chat_id', $chatId)->first();
        if (!$user) {
            $user = new TelegramUser();
            $user->chat_id = $chatId;
        }
        $user->username = $bot->message()->chat->username;
        $user->first_name = $bot->message()->chat->first_name;
        $user->last_name = $bot->message()->chat->last_name;
        $user->save();

        $bot->sendMessage('Welcome! Choose your language.', [
            'reply_markup' => ReplyKeyboardMarkup::make()->addRow(
                KeyboardButton::make('Русский  🇷🇺'),
                KeyboardButton::make('O\'zbek 🇺🇿'),
                KeyboardButton::make('English 🇺🇸'),
            )
        ]);
    }
}
