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


	/**
	 * Introduction & fallback command
	 */
	/** @var MiscCommands $miscCommands */
	$miscCommands = resolve('App\Conversations\SingleCommands\MiscCommands');
	$botman->hears("Hi|Hello|Yo|Sup|Hey|o7|o/|Oi", $miscCommands->sayHi());
	$botman->fallback($miscCommands->fallback());
