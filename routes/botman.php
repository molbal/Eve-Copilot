<?php

	use App\Http\Controllers\BotManController;
	use BotMan\BotMan\BotMan;
	use BotMan\Drivers\Facebook\Extensions\Airline\AirlineAirport;
	use BotMan\Drivers\Facebook\Extensions\Airline\AirlineExtendedFlightInfo;
	use BotMan\Drivers\Facebook\Extensions\Airline\AirlineFlightSchedule;
	use BotMan\Drivers\Facebook\Extensions\Airline\AirlinePassengerInfo;
	use BotMan\Drivers\Facebook\Extensions\Airline\AirlinePassengerSegmentInfo;
	use BotMan\Drivers\Facebook\Extensions\AirlineItineraryTemplate;
	use BotMan\Drivers\Facebook\Interfaces\Airline;
	use Illuminate\Support\Facades\Log;

	/** @var \BotMan\BotMan\BotMan $botman */
	$botman = resolve('botman');
	info('incoming', request()->all()); // this line was added
	$botman->hears('Hi', function (BotMan $bot) {
		$bot->reply('Hello! (You said ' . $bot->getMessage()->getText() . ')');
	});
	$botman->hears('Start conversation', BotManController::class . '@startConversation');
	$botman->hears("whoami", function (BotMan $bot) {
		$bot->typesAndWaits(1);
		$bot->reply("You are user#".$bot->getUser()->getId()."");
	});

//	$botman->hears("Let's get started");
