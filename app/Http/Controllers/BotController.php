<?php

namespace App\Http\Controllers;

use App\Conversations\BookComputerConversation;
use App\Conversations\ComputerPriceConversation;
use App\Conversations\FreeComputerConversation;
use App\Conversations\RegisterConversation;
use App\Handlers\Commands\StartCommand;
use App\InlineMenus\ChooseLanguageMenu;
use App\Middleware\ChooseLanguageMiddleware;
use SergiX44\Nutgram\Logger\ConsoleLogger;
use SergiX44\Nutgram\Nutgram;

class BotController extends Controller
{
    public function __invoke(Nutgram $bot)
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
