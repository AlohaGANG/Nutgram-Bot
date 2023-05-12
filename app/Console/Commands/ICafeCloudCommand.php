<?php

namespace App\Console\Commands;

use App\Services\ICafeCloudService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;

class ICafeCloudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icafe:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $options = [
            'multipart' => [
                [
                    'name' => 'member_account',
                    'contents' => 'testaccount'
                ],
                [
                    'name' => 'member_password',
                    'contents' => 'testaccount'
                ]
            ]];

        $import = new ICafeCloudService();

        $response = $import->client->request('POST' , 'api/v2/cafe/74954/members', $options);

        $data = json_decode($response->getBody()->getContents());

        if ($data->message === "success"){
            echo "Готово";
        }
        if ($data->message === "Account exists"){
            echo "Такой аккаунт уже существует";
        }

    }
}
