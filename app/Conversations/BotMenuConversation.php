<?php

namespace App\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;

class BotMenuConversation extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->sendMessage(__('messages.ChooseLanguageMessage'),[
            'reply_markup' => ReplyKeyboardRemove::make(true),
        ]);
        $this->end();
    }
    public function closing(Nutgram $bot)
    {
        $bot->sendMessage(__('messages.MainMenuMassage'), [
            'reply_markup' => ReplyKeyboardMarkup::make()->addRow(
                KeyboardButton::make(__('buttonsLocale.Location')),
                KeyboardButton::make(__('buttonsLocale.Call')),
            )->addRow(
                KeyboardButton::make(__('buttonsLocale.Book')),
                KeyboardButton::make(__('buttonsLocale.Prices')),
            )->addRow(
                KeyboardButton::make(__('buttonsLocale.FreeComputers')),
                KeyboardButton::make(__('buttonsLocale.Registration')),
            )
        ]);
    }
}
