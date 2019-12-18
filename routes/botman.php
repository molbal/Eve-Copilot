<?php
use App\Http\Controllers\BotManController;
	use BotMan\BotMan\BotMan;
	use Illuminate\Support\Facades\Log;

	/** @var \BotMan\BotMan\BotMan $botman */
	$botman = resolve('botman');
	info('incoming', request()->all()); // this line was added
$botman->hears('Hi', function (BotMan $bot) {
	Log::info("Saying back Hello");
    $bot->reply('Hello! (You said '.$bot->getMessage()->getText().')');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');