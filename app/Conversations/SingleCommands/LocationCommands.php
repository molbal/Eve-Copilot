<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Location\LocationService;
    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use Closure;
    use Illuminate\Support\Facades\Log;

    class LocationCommands {


        /**
         * @return Closure
         */
        public static function statusCommand(): Closure {
            return function (BotMan $bot) {
                $bot->types();
                $location = "There was an error. ";
                try {

                    $locationService = new LocationService();
                    $currentShip = $locationService->getCurrentShip(ChatCharLink::getActive($bot->getUser()->getId()));
                    $status = $locationService->getCurrentLocation(ChatCharLink::getActive($bot->getUser()->getId()));

                    $dockedName = $status->station_name ?? $status->structure_name ?? null;
                    $statusText = "Your are " . ((isset($status->station_id) || isset($status->structure_id)) ? "docked" : "in space") .
                        " in " . $status->solar_system_name . " " . ($dockedName ? "($dockedName)" : "") .
                        " with a " . $currentShip->ship_name;


                    $attachment = new Image(ImageAPI::getRenderLink($currentShip->ship_type_id));

                    // Build message object
                    $message = OutgoingMessage::create($statusText)
                        ->withAttachment($attachment);

                    $bot->reply($message);
                } catch (Exception $e) {
                    $location .= $e->getMessage() . " " . $e->getFile() . " @" . $e->getLine();
                    Log::error($location);
                    $bot->reply("An error occurred while coming up with the response. (".$e->getMessage().")");
                }

            };
        }
    }