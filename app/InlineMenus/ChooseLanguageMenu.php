<?php

namespace App\InlineMenus;

use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class ChooseLanguageMenu extends InlineMenu
{
    public function start(Nutgram $bot)
    {
        $this->menuText('Choose a language')
            ->addButtonRow(InlineKeyboardButton::make('Русский  🇷🇺', callback_data: 'set_lang_ru'))
            ->addButtonRow(InlineKeyboardButton::make('O\'zbek 🇺🇿', callback_data: 'set_lang_uz'))
            ->addButtonRow(InlineKeyboardButton::make('English 🇺🇸', callback_data: 'set_lang_us'))
            ->orNext('none')
            ->showMenu();
    }
    public function handleLanguage(Nutgram $bot){

        $language = $bot->callbackQuery()->data;
        $bot->answerCallbackQuery();
        $this->menuText("Choosen: $language!")
            ->showMenu();
        $bot->onCallbackQueryData('set_lang_ru', function (Nutgram $bot){
            $bot->answerCallbackQuery([
                'text' => 'my answer',
                'show_alert' => true,
            ]);
            $bot->sendMessage('lol');
        });
    }
    public function none(Nutgram $bot){
        $bot->sendMessage('Bye!');
        $this->end();
    }

}
