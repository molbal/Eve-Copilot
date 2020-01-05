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

        private $locationService;

        /**
         * LocationCommands constructor.
         *
         * @param $locationService
         */
        public function __construct(LocationService $locationService) {
            $this->locationService = $locationService;
        }


        /**
         * @return Closure
         */
        public function statusCommand(): Closure {
            return function (BotMan $bot) {
                $bot->types();
                $location = "There was an error. ";
                try {

                    $currentShip = $this->locationService->getCurrentShip(ChatCharLink::getActive($bot->getUser()->getId()));
                    $status = $this->locationService->getCurrentLocation(ChatCharLink::getActive($bot->getUser()->getId()));

                    $dockedName = $status->station_name ?? $status->structure_name ?? null;
                    $statusText = "Your are " . ((isset($status->station_id) || isset($status->structure_id)) ? "docked" : "in space") .
                        " in " . $status->solar_system_name . " " . ($dockedName ? "($dockedName)" : "") .
                        ". Your ship's name is: " . $currentShip->ship_name;


                    $attachment = new Image(ImageAPI::getRenderLink($currentShip->ship_type_id));

                    // Build message object
                    $message = OutgoingMessage::create("")
                        ->withAttachment($attachment);

                    $bot->reply($message);
                    $bot->reply($statusText);
                } catch (\Exception $e) {
                    $location .= $e->getMessage() . " " . $e->getFile() . " @" . $e->getLine();
                    Log::error($location);
                    $bot->reply("An error occurred while coming up with the response. (".$e->getMessage().")");
                }

            };
        }
    }