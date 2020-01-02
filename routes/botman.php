<?php

    use App\Conversations\ExampleConversation;
    use App\Conversations\LinkCharacterConversation;
    use App\Http\Controllers\BotManController;
	use BotMan\BotMan\BotMan;

	use Illuminate\Support\Facades\Cache;


	/** @var \BotMan\BotMan\BotMan $botman */
	$botman = resolve('botman');

	$botman->hears('Hi', function (BotMan $bot) {
		$bot->reply('Hello! (You said ' . $bot->getMessage()->getText() . ')');
	});
	$botman->hears('Link character', function(BotMan $bot) {

        $bot->startConversation(new LinkCharacterConversation);
    });

	$botman->hears("whoami", function (BotMan $bot) {
		$bot->typesAndWaits(1);
		$bot->reply("You are user#".$bot->getUser()->getId()."");
	});

	$botman->hears("cache", function (BotMan $bot) {
		Cache::put("Test-".$bot->getUser()->getId(), "ssa", 60);
		$bot->typesAndWaits(1);
		$bot->reply("Put it in the cache: " . Cache::get("Test-".$bot->getUser()->getId()));
	});
//	$botman->hears("Let's get started");
