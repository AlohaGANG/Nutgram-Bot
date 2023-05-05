<?php

namespace App\Conversations;

use App\Handlers\MadelineprotoHandler;
use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

class BookComputerConversation extends Conversation
{
    public $name;
    public $phoneNumber;
    public $time;

    public function start(Nutgram $bot)
    {
        $bot->sendMessage(__('Booking.Name'), [
            'reply_markup' => ForceReply::make(
                force_reply: true,
                input_field_placeholder: 'Type something',
                selective: true,
            ),
        ]);
        $this->next('secondStep');
    }
    public function secondStep(Nutgram $bot){
        $bot->sendMessage(__('Booking.Time'), [
            'reply_markup' => ForceReply::make(
                force_reply: true,
                input_field_placeholder: 'Type something',
                selective: true,
            ),
        ]);
        $this->name = $bot->message()->text;
        $this->next('thirdStep');
    }
    public function thirdStep(Nutgram $bot){
        $bot->sendMessage(__('Booking.PhoneNumber'), [
            'parse_mode' => 'html',
            'reply_markup' => ReplyKeyboardMarkup::make()
                ->addRow(
                    KeyboardButton::make(__('buttonsLocale.ShareContact'), request_contact: true)
                )
        ]);
        $this->time = $bot->message()->text;
        $this->next('recap');
    }
    public function recap(Nutgram $bot){
        BotMenuConversation::begin($bot);
        $this->phoneNumber = $bot->message()->contact->phone_number;
        $this->sendMessage();
        $this->end();
    }

    public function sendMessage(){
        $settings = new Settings();

        $MadelineProto = new API(env('SESSION_PATH'));
        $MadelineProto->start();
        $MadelineProto->messages->sendMessage(['peer' => -899696384,
            'message' => "Имя : {$this->name} \nВремя брони : {$this->time} \nНомер телефона : {$this->phoneNumber}"]);
    }
}
