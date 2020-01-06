<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Location\LocationService;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Helpers\CharacterSettings;
    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use Closure;
    use Illuminate\Support\Facades\Log;

    class LocationCommands {

        private $locationService;
        private $rlp;

        /**
         * LocationCommands constructor.
         *
         * @param LocationService       $locationService
         * @param ResourceLookupService $rlp
         */
        public function __construct(LocationService $locationService, ResourceLookupService $rlp) {
            $this->locationService = $locationService;
            $this->rlp = $rlp;
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
                        ". Your ship is a " . $currentShip->ship_type_name . " and its name is " . $currentShip->ship_name;


                    $attachment = new Image(ImageAPI::getRenderLink($currentShip->ship_type_id));

                    // Build message object
                    $message = OutgoingMessage::create("")
                        ->withAttachment($attachment);

                    $bot->reply($message);
                    $bot->reply($statusText);
                } catch (\Exception $e) {
                    $location .= $e->getMessage() . " " . $e->getFile() . " @" . $e->getLine();
                    Log::error($location);
                    $bot->reply("An error occurred while coming up with the response. (" . $e->getMessage() . ":" . $e->getFile() . "@" . $e->getLine() . ")");
                }

            };
        }


        public function navigateTo(): Closure {
            return function (Botman $bot, string $target) {
                try {

                    switch (mb_strtolower($target)) {
                        case "jita":
                            $target_id = "60003760";
                            $name = "Jita (Trade hub station work 🚚)";
                            break;
                        case "hek":
                            $target_id = "60011866";
                            $name = "Hek (Trade hub station work 🚚)";
                            break;
                        case 'amarr':
                            $target_id = "60008494";
                            $name = "Amarr (Trade hub station work 🚚)";
                            break;
                        case 'rens':
                            $target_id = "60004588";
                            $name = "Rens (Trade hub station work 🚚)";
                            break;
                        case 'dodixie':
                            $target_id = "60011866";
                            $name = "Dodixie (Trade hub station work 🚚)";
                            break;
                        case 'home':
                            $target_id = CharacterSettings::getSettings($bot->getUser()->getId(), "HOME_ID");
                            if (!$target_id) {
                                throw new \RuntimeException("You don't have a home set. Send 'set home' to set it.");
                            }
                            $name = "🏠 Home";
                            break;
                        default:
                            // Try structure
                            try {
                                $target_id = $this->rlp->getStructureId($target);
                                $name = "$target (Structure 🏢)";
                            } catch (\Exception $e) {

                                // Try station
                                try {
                                    $target_id = $this->rlp->getStationId($target);
                                    $name = "$target (Station 🏢)";
                                } catch (\Exception $e) {

                                    // Try solar system
                                    try {
                                        $target_id = $this->rlp->getSolarSystemId($target);
                                        $name = "$target (Solar system ☀)";
                                    } catch (\Exception $e) {
                                        throw new \Exception("Could not find any station, structure or system named this way!");
                                    }
                                }
                            }
                    }

                    $this->locationService->setWaypoint(ChatCharLink::getActive($bot->getUser()->getId()), $target_id);
                    $bot->reply("Route set to $name - Follow the waypoints or press Ctrl+S in EVE to toggle the autopilot.");
                } catch (\Exception $e) {
                    $bot->reply("Could not set waypoint: " . $e->getMessage(). " (".$e->getFile()."@".$e->getLine().")");
                }
            };
        }
    }