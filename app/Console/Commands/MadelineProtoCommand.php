<?php

namespace App\Console\Commands;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use Illuminate\Console\Command;

class MadelineProtoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'madeline:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the madelineproto client';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = new Settings();

        $MadelineProto = new API(env('SESSION_PATH'), $settings);
    }
}
