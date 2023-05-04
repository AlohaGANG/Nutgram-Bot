<?php

namespace App\Console\Commands;

use App\Handlers\Commands\StartCommand;
use App\InlineMenus\ChooseLanguageMenu;
use App\Middleware\ChooseLanguageMiddleware;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Logger\ConsoleLogger;
use SergiX44\Nutgram\Nutgram;

class BotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bot started command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Nutgram $bot)
    {
        $bot = new Nutgram($_ENV['TELEGRAM_TOKEN'],[
            'timeout' => $_ENV['CONNECT_TIMEOUT'],
            'logger' => ConsoleLogger::class]);

        $bot->registerCommand(StartCommand::class)
            ->middleware(ChooseLanguageMiddleware::class);

        $bot->registerMyCommands();

        $bot->run();
    }
}
