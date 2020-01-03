<?php

    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Location\LocationService;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Conversations\LinkCharacterConversation;
    use App\Conversations\SingleCommands\CharacterManagementCommands;
    use App\Conversations\SingleCommands\LocationCommands;
    use BotMan\BotMan\BotMan;

    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use Illuminate\Support\Facades\Cache;

    /** @var \BotMan\BotMan\BotMan $botman */
    $botman = resolve('botman');

    $botman->hears('Link char|Link character|Add character|Add char', function (BotMan $bot) {
        $bot->startConversation(new LinkCharacterConversation);
    });
    $botman->hears("whois {charId}", function (BotMan $bot, string $charId) {
        try {
            $bot->reply("Looking up code..");
            $rlp = new ResourceLookupService();
            $bot->reply(print_r($rlp->getCharacterName($charId), 1));
        } catch (Exception $e) {
            $bot->reply("Cannot find this character: ".$e->getMessage());
        }
    });

    /**
     * @return Closure
     */




    /**
     * Character management commands
     */
    /** @var CharacterManagementCommands $charManagement */
    $charManagement = resolve('App\Conversations\SingleCommands\CharacterManagementCommands');
    $botman->hears("Switch to {charName}", $charManagement->switchToCharacter());
    $botman->hears("My chars|My characters", $charManagement->listMyCharacters());

    /**
     * Location Service
     */
    $botman->hears("Status", LocationCommands::statusCommand());


    $botman->fallback(function (BotMan $bot) {
        $bot->reply('🤷‍♂️ Sorry, I did not understand what you said. Please check for typos or what I can understand here: https://co-pilot.eve-nt.uk#features');
    });