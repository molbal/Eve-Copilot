<?php

    use App\Conversations\LinkCharacterConversation;
    use App\Conversations\SingleCommands\CharacterManagementCommands;
    use App\Conversations\SingleCommands\IntelCommands;
    use App\Conversations\SingleCommands\LocationCommands;
    use BotMan\BotMan\BotMan;


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

    /**
     * Location Service commands
     */
    /** @var LocationCommands $charManagement */
    $locationCommands = resolve('App\Conversations\SingleCommands\LocationCommands');
    $botman->hears("Status", $locationCommands->statusCommand());

    /**
     * Intelligence service
     */
    /** @var IntelCommands $intelService */
    $intelService = resolve('App\Conversations\SingleCommands\IntelCommands');
    $botman->hears("whois {charId}", $intelService->simpleWhois());


    /**
     * Fallback command
     */
    $botman->fallback(function (BotMan $bot) {
        $bot->reply('🤷‍♂️ Sorry, I did not understand what you said. Please check for typos or what I can understand here: https://co-pilot.eve-nt.uk#features');
    });