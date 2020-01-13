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
	$botman->hears("testr {a} {b} {c}", function (BotMan $bot, string $a, string $b, $c) {
		try {
			$rc = new RouteConnector();
			$rlp = new ResourceLookupService();

			switch (strtolower($c)) {
				case 'quickest':
				case 'fast':
				case 'quick':
				case 'shortest':
				case 'short':
				default:
					$typeI = 1;
					$typeS = "short";
					break;
				case 'safe':
				case 'safest':
				case 'safer':
				case 'highest':
					$typeI = 2;
					$typeS = "safe";
					break;
				case 'unsafe':
				case 'unsafest':
				case 'shadiest':
				case 'lowest':
					$typeI = 3;
					$typeS = "unsafe";
					break;
			}

			/** @var RouteStep[] $systems */
			$systems = $rc->checkRouteSafety($a, $b, $typeI);

			$m = sprintf("🗺 Showing the %s route from %s to %s (%d jumps)", $typeS, ucfirst($a), ucfirst($b), count($systems));
			$sovs = [];
			$ssmin = new RouteStep('', +1.0);
			$ssmax = new RouteStep('', -1.0);
			$shoot = false;
			$sys = [];
			$chatId = $bot->getUser()->getId();
			$charId = ChatCharLink::getActive($chatId);
			$secStatus = $rlp->getSecurityStatus($charId);
			$shoot = 0;
			$camps = 0;
			foreach ($systems as $i => $system) {
				if (SecurityStatusTools::willFactionPoliceShootAtMe($secStatus, $system->securityStatus)) {
					$safe = "🏴";
					$shoot++;
				}
				else {
					$safe = "";
				}

				if ($system->kills >= 10) {
					$camp = sprintf("🏴‍☠️(%d kills lately)", $system->kills);
					$camps++;
				}
				else {
					$camp = "";
				}

				$sys[] = sprintf("%s (%1.1f)%s%s", $system->solarSystem, $system->securityStatus, $safe, $camp);
				$sovs[] = $system->sovereignty;
				if ($system->securityStatus < $ssmin->securityStatus) {
					$ssmin = $system;
				}
				if ($system->securityStatus > $ssmax->securityStatus) {
					$ssmax = $system;
				}

			}
			$m .= "\r\n\r\n 👉 " . implode("\r\n", $sys);
//			$m .= "\r\n\r\n 👉 " . implode(" » ", $sys);
			$m .= sprintf("\r\n\r\n 🛂 This route passes through the territories of %s (in route order)", implode(', ', array_unique($sovs)));
			$m .= sprintf("\r\n\r\n 👮‍ The route's minimum security status is %1.1f in %s and maximum is %1.1f in %s", $ssmin->securityStatus, $ssmin->solarSystem, $ssmax->securityStatus, $ssmax->solarSystem);

			if ($shoot) {
				$m .= sprintf("\r\n\r\n 🏴 Warning! Faction police will shoot at you in %d system%s marked with the black flag, because your security status is %1.2f", $shoot, (($shoot > 1) ? "s": ""), $secStatus);
			}
			if ($camps) {
				$m .= "\r\n\r\n 🏴‍☠️ Warning! The systems marked with a pirate flag had more than 10 kills in the last 3 hours - this could be a gatecamp.";
			}
			$bot->reply($m);
		} catch (Exception $e) {
			$bot->reply($e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
		}
	});


	/**
	 * Introduction & fallback command
	 */
	/** @var MiscCommands $miscCommands */
	$miscCommands = resolve('App\Conversations\SingleCommands\MiscCommands');
	$botman->hears("Hi|Hello|Yo|Sup|Hey|o7|o/|Oi", $miscCommands->sayHi());
	$botman->fallback($miscCommands->fallback());
