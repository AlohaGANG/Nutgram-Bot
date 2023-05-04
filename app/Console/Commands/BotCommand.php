<?php

namespace App\Console\Commands;

use App\Handlers\Commands\StartCommand;
use App\InlineMenus\ChooseLanguageMenu;
use App\Middleware\ChooseLanguageMiddleware;
use App\Middleware\MainMenuMiddleware;
use App\Middleware\SendLocationMiddleware;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Logger\ConsoleLogger;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;

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

        $bot->onText('Location|Локация|Manzil', function (Nutgram $bot){
            $bot->sendLocation(41.270121,69.191031);
        });
        $bot->onText('Call|Позвонить|Qo\'ng\'iroq qilish', function (Nutgram $bot){
            $bot->sendContact('Team Pro','+998954101717');
        });

        $bot->registerMyCommands();

        $bot->run();
    }
}
