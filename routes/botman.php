<?php

	use App\Connector\ChatCharLink;
	use App\Connector\DotlanConnector\Entities\RouteStep;
	use App\Connector\DotlanConnector\RouteConnector;
	use App\Connector\EveAPI\Universe\ResourceLookupService;
	use App\Connector\SecurityStatusTools;
	use App\Conversations\LinkCharacterConversation;
	use App\Conversations\SetEmergencyContactConversation;
	use App\Conversations\SetHomeConversation;
	use App\Conversations\SingleCommands\CharacterManagementCommands;
	use App\Conversations\SingleCommands\EmergencyCommands;
	use App\Conversations\SingleCommands\IntelCommands;
	use App\Conversations\SingleCommands\LocationCommands;
	use App\Conversations\SingleCommands\MiscCommands;
	use BotMan\BotMan\BotMan;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Log;


	/** @var \BotMan\BotMan\BotMan $botman */
	$botman = resolve('botman');


	/**
	 * Character management commands
	 */
	/** @var CharacterManagementCommands $charManagement */
	$charManagement = resolve('App\Conversations\SingleCommands\CharacterManagementCommands');
	$botman->hears("Switch to {charName}", $charManagement->switchToCharacter());
	$botman->hears("My chars|My characters", $charManagement->listMyCharacters());
	$botman->hears('Link char|Link character|Add character|Add char', function (BotMan $bot) {
		$bot->startConversation(new LinkCharacterConversation);
	});
	$botman->hears('Set home|New home', function (BotMan $bot) {
		$bot->startConversation(new SetHomeConversation);
	});
	$botman->hears('New emergency contact|Set emergency contact', function (BotMan $bot) {
		$bot->startConversation(new SetEmergencyContactConversation);
	});


	/**
	 * Location Service commands
	 */
	/** @var LocationCommands $locationCommands */
	$locationCommands = resolve('App\Conversations\SingleCommands\LocationCommands');
	$botman->hears("Status", $locationCommands->statusCommand());
	$botman->hears("Navigate {target}", $locationCommands->navigateTo());
	$botman->hears("Navigate to {target}", $locationCommands->navigateTo());
	$botman->hears("Go to {target}", $locationCommands->navigateTo());
	$botman->hears("Set route to {target}", $locationCommands->navigateTo());
    $botman->hears("Scout route from {a} to {b} {c}", $locationCommands->autoScout());
    $botman->hears("Check route from {a} to {b} {c}", $locationCommands->autoScout());
    $botman->hears("Check between {a} and {b} {c}", $locationCommands->autoScout());
    $botman->hears("Scout between {a} and {b} {c}", $locationCommands->autoScout());
    $botman->hears("Route check {a} {b} {c}", $locationCommands->autoScout());
    $botman->hears("Autoscout {a} {b} {c}", $locationCommands->autoScout());
    $botman->hears("Scout route from {a} to {b}", $locationCommands->autoScout());
    $botman->hears("Check route from {a} to {b}", $locationCommands->autoScout());
    $botman->hears("Check between {a} and {b}", $locationCommands->autoScout());
    $botman->hears("Scout between {a} and {b}", $locationCommands->autoScout());
    $botman->hears("Route check {a} {b}", $locationCommands->autoScout());
    $botman->hears("Autoscout {a} {b}", $locationCommands->autoScout());
	$botman->hears("When do we get to {target}", $locationCommands->notifyWhenArrived());
	$botman->hears("Tell me when we reach {target}", $locationCommands->notifyWhenArrived());
	$botman->hears("Tell me when we get to {target}", $locationCommands->notifyWhenArrived());
	$botman->hears("Are we in {target} yet", $locationCommands->notifyWhenArrived());
	$botman->hears("Autoscout", function (BotMan $bot) {
		$info = "This command checks whether it is for your to travel this route. For the start system and end system give solar system names, and for the route type parameter give either: quickest, fast, quick, shortest, short for the shortest route, safe, safest, safer, highest for the safe route, and unsafe, unsafest, shadiest, lowest for the unsafe route.\r\nThe bot will check the security statuses of systems and compare it to your own, checking if faction police will shoot you. At the same time it checks kill numbers in system and notify you when the kill number is more than 10 for the last 3 hours. ";
		$bot->reply($info);
		$bot->reply("To use it send me 'Scout route from {Start system} to {End system} {Route type}' (You don't have to write the { characters } around the parameters)");
	});

	/**
	 * Emergency contacts
	 */
	/** @var EmergencyCommands $emergencyCommands */
	$emergencyCommands = resolve('App\Conversations\SingleCommands\EmergencyCommands');
	$botman->hears("mayday|call reinforcements|send help", $emergencyCommands->mayday());


    /**
     * Intelligence service
     */
    /** @var IntelCommands $intelService */
    $intelService = resolve('App\Conversations\SingleCommands\IntelCommands');
    $botman->hears("whois {charId}", $intelService->simpleWhois());
    $botman->hears("identify {targetName}", $intelService->identify());
    $botman->hears("ID {targetName}", $intelService->identify());
	$botman->hears("deep scan {targetName}", $intelService->thoroughScan());
	$botman->hears("thorough scan {targetName}", $intelService->thoroughScan());
	$botman->hears("threat estimation {targetName}", $intelService->thoroughScan());
	$botman->hears("deep scan", $intelService->thoroughScan());
	$botman->hears("thorough scan", $intelService->thoroughScan());
	$botman->hears("threat estimation", $intelService->thoroughScan());
	$botman->hears("How elite is {targetName}", $intelService->howElite());


	/**
	 * Introduction & fallback command
	 */
	/** @var MiscCommands $miscCommands */
	$miscCommands = resolve('App\Conversations\SingleCommands\MiscCommands');
	$botman->hears("Hi|Hello|Yo|Sup|Hey|o7|o/|Oi", $miscCommands->sayHi());
	$botman->fallback($miscCommands->fallback());
