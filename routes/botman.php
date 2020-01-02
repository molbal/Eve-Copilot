<?php


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Location\LocationService;
    use App\Conversations\LinkCharacterConversation;
    use BotMan\BotMan\BotMan;

    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use Illuminate\Support\Facades\Cache;


    /** @var \BotMan\BotMan\BotMan $botman */
    $botman = resolve('botman');

    $botman->hears('Hi', function (BotMan $bot) {
        $bot->reply('Hello! (You said ' . $bot->getMessage()->getText() . ')');
    });
    $botman->hears('Link character', function (BotMan $bot) {

        $bot->startConversation(new LinkCharacterConversation);
    });

    $botman->hears("whoami", function (BotMan $bot) {
        $bot->typesAndWaits(1);
        $bot->reply("You are user#" . $bot->getUser()->getId() . "");
    });

    $botman->hears("cache", function (BotMan $bot) {
        Cache::put("Test-" . $bot->getUser()->getId(), "ssa", 60);
        $bot->typesAndWaits(1);
        $bot->reply("Put it in the cache: " . Cache::get("Test-" . $bot->getUser()->getId()));
    });

    $botman->hears("Status", function (BotMan $bot) {
        $bot->types();
        $location = "There was an error. ";
        try {

            $locationService = new LocationService();
            $currentShip = $locationService->getCurrentShip(ChatCharLink::getActive($bot->getUser()->getId()));
            $status = $locationService->getCurrentLocation(ChatCharLink::getActive($bot->getUser()->getId()));

            $dockedName = $status->station_name ?? $status->structure_name ?? null;
            $statusText = "Your are ".((isset($status->station_id) || isset($status->structure_id)) ? "docked" : "in space") .
                " in ".$status->solar_system_name . " ". ($dockedName ? "($dockedName)" : "").
                " with a ".$currentShip->ship_name;


            $attachment = new Image(ImageAPI::getRenderLink($currentShip->ship_type_id));

            // Build message object
            $message = OutgoingMessage::create($statusText)
                ->withAttachment($attachment);

            $bot->reply($message);
        } catch (Exception $e) {
            $location .= $e->getMessage() . " ". $e->getFile()." @".$e->getLine();
            $bot->reply($location);
        }

    });
    //	$botman->hears("Let's get started");
