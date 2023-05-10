<?php

namespace App\Conversations;

use App\Services\ICafeCloudService;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ComputerPriceConversation extends Conversation
{

    public function start(Nutgram $bot)
    {
        $text = $this->jsonRequest();
        $bot->sendMessage($text);
        $this->end();
    }

    public function jsonRequest(){
        $data_array = [];
        $import = new ICafeCloudService();
        $sum_message = __('messages.Sum');
        $response = $import->client->request('GET','api/v2/cafe/74954/prices');
        $data = json_decode($response->getBody()->getContents());

        foreach ($data->data as $item){
            $data_array[$item->price_name] = $item->price_price1;
        }
        $prices = [];
        foreach ($data_array as $price_name => $price_value) {
            $prices[] = "{$price_name}: {$price_value} $sum_message";
        }

        // объединяем строки с помощью implode()
        $text = implode("\n", $prices);
        return $text;
    }
}
