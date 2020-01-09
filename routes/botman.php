<?php

    use App\Connector\DotlanConnector\Entities\RouteStep;
    use App\Connector\DotlanConnector\RouteConnector;
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
    $botman->hears("testr {a} {b} {c}", function (BotMan $bot, string $a, string $b,  $c) {
    	try {
    		$rc = new RouteConnector();

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

    		$m = sprintf("🗺 Showing the %s route from %s to %s:\n", $typeS, $a, $b);
    		$sovs = [];
    		foreach ($systems as $i => $system) {
    		    $m .= "\r\n".($i+1).": ".$system;
    		    $sovs[] = $system->sovereignty;
            }

    		$m .= "\r\n\r\n 🛂 This route passes through the territories of ".implode(', ', array_unique($sovs)) . " (in route order)";
    		$bot->reply($m);
    		$bot->reply("For more details check Dotlan maps: ".sprintf("http://evemaps.dotlan.net/route/%d:%s:%s",
                    $typeI, $a, $b));
    	}
		catch (Exception $e) {
    		$bot->reply($e->getMessage()." ".$e->getFile()." ".$e->getLine());
    	}
	});


    /**
     * Introduction & fallback command
     */
    /** @var MiscCommands $miscCommands */
    $miscCommands = resolve('App\Conversations\SingleCommands\MiscCommands');
    $botman->hears("Hi|Hello|Yo|Sup|Hey|o7|o/|Oi", $miscCommands->sayHi());
    $botman->fallback($miscCommands->fallback());
