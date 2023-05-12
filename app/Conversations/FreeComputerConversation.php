<?php

namespace App\Conversations;

use App\Services\ICafeCloudService;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class FreeComputerConversation extends Conversation
{
    public function start(Nutgram $bot)
    {
        $text = $this->jsonRequest();
        $bot->sendMessage($text);
        $this->end();
    }

    public function jsonRequest(){

        $pcsInUsing = 0;
        $allPcs = 0;
        $freePc = 0;
        $ps5InUsing = 0;
        $freePS = 0;
        $allPs5 = 0;

        $import = new ICafeCloudService();

        $response = $import->client->request('GET' , 'api/v2/cafe/74954/pcs');

        $data = json_decode($response->getBody()->getContents());

        foreach ($data->data as $item){
            if (substr($item->pc_name, 0,7) === "tpro-pc"){
                $allPcs++;
                if (substr($item->pc_name, 0,7) === "tpro-pc" && $item->pc_in_using === 1){
                    $pcsInUsing++;
                }
            }
            if(substr($item->pc_name,  0 ,3) === "PS5"){
                $allPs5++;
                if (substr($item->pc_name,  0 ,3) === "PS5" && $item->pc_in_using === 1){
                    $ps5InUsing++;
                }
            }
        }
        $freePc = $allPcs - $pcsInUsing;
        $freePS = $allPs5 - $ps5InUsing;

    $text = __('messages.FreeCom',['pcsInUsing' => $pcsInUsing, 'freePc' => $freePc, 'allPcs' =>$allPcs]) . "\n" .
    __('messages.FreePs', ['ps5InUsing' => $ps5InUsing, 'freePS' => $freePS, 'allPs5' => $allPs5]);

        return $text;
    }
}
