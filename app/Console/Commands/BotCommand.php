<?php

namespace App\Console\Commands;

use App\Conversations\BookComputerConversation;
use App\Conversations\ComputerPriceConversation;
use App\Conversations\FreeComputerConversation;
use App\Conversations\RegisterConversation;
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

        $bot->onText('Where are we?|Где мы находимся?|Qayerdamiz?', function (Nutgram $bot){
            $bot->sendLocation(41.270121,69.191031);
        });
        $bot->onText('Contact us|Связаться с нами|Biz bilan bog\'lanish', function (Nutgram $bot){
            $bot->sendContact('Team Pro','+998954101717');
        });
        $bot->onText('Computer booking|Бронь компьютера|Kompyuter buyurtma', BookComputerConversation::class);

        $bot->onText('Pricing|Тарифы|Narxlar', ComputerPriceConversation::class);

        $bot->onText('Available computers|Свободные компьютеры|Bo\'sh kompyuterlar',
            FreeComputerConversation::class);

        $bot->onText('Club registration|Регистрация в клубе|Klubga ro\'yxatdan o\'tish',
            RegisterConversation::class);

        $bot->registerMyCommands();

        $bot->run();
    }
}
