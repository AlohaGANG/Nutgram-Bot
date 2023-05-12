<?php

namespace App\Conversations;

use App\Models\TelegramUser;
use App\Services\ICafeCloudService;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;

class RegisterConversation extends Conversation
{
    public $member_account;
    public $member_password;
    public function start(Nutgram $bot)
    {
        $chatId = $bot->message()->chat->id;
        $user = DB::table('telegram_users')->where('chat_id', $chatId)->first();
        if ($user && $user->is_registered === false) {
            $this->secondStep($bot);
            return;
        }
        if ($user && $user->is_registered === true) {
            $bot->sendMessage(__('messages.AccountInfo4'));
            $this->end();
        }
    }
    public function secondStep(Nutgram $bot){
        $bot->sendMessage(__('register.Login'), [
            'reply_markup' => ForceReply::make(
                force_reply: true,
                input_field_placeholder: 'Type something',
                selective: true,
            ),
        ]);
        $this->next('thirdStep');
    }
    public function thirdStep(Nutgram $bot){
        $bot->sendMessage(__('register.Password'), [
            'reply_markup' => ForceReply::make(
                force_reply: true,
                input_field_placeholder: 'Type something',
                selective: true,
            ),
        ]);
        $this->member_account = $bot->message()->text;
        $this->next('recap');
    }
    public function recap(Nutgram $bot){
        $chatId = $bot->message()->chat->id;
        $this->member_password = $bot->message()->text;
        $this->accountRegister($this->member_account, $this->member_password);
        DB::table('telegram_users')->where('chat_id',$chatId)->update(['is_registered' => true]);
        $this->end();
    }

    public function accountRegister($member_account, $member_password){
        $options = [
            'multipart' => [
                [
                    'name' => 'member_account',
                    'contents' => $member_account
                ],
                [
                    'name' => 'member_password',
                    'contents' => $member_password
                ]
            ]];
        $import = new ICafeCloudService();

        $response = $import->client->request('POST' , 'api/v2/cafe/74954/members', $options);

        $data = json_decode($response->getBody()->getContents());

        if ($data->message === "success"){
            $this->bot->sendMessage(__('messages.Ready') . "\n".__('messages.AccountInfo1')."{$this->member_account}" .
            "\n".__('messages.AccountInfo2')."{$this->member_password}" . "\n".__('messages.AccountInfo3'));
        }
        if ($data->message === "Account exists"){
            $this->bot->sendMessage(__('messages.AccountBeReg'));
            sleep(2);
            BotMenuConversation::begin($this->bot);
        }
    }
}
