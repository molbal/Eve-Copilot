<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\Location\LocationService;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use BotMan\BotMan\BotMan;

    class EmergencyCommands {

        /** @var ResourceLookupService  */
        private $rlp;
        /** @var LocationService  */
        private $locationService;

        /**
         * LocationCommands constructor.
         *
         * @param ResourceLookupService $rlp
         * @param LocationService       $locationService
         */
        public function __construct(ResourceLookupService $rlp, LocationService $locationService) {
            $this->rlp = $rlp;
            $this->locationService = $locationService;
        }

        private function mayday(): \Closure {
            return function (BotMan $bot, string $charId) {
                try {
                    $message = "MAYDAY! \n";

                    $currentShip = $this->locationService->getCurrentShip(ChatCharLink::getActive($bot->getUser()->getId()));
                    $status = $this->locationService->getCurrentLocation(ChatCharLink::getActive($bot->getUser()->getId()));
                    $message .= " I am in ".$status->solar_system_name." and I need assistance. My ship name is a named  ".$currentShip->ship_name;

                } catch (\Exception $e) {
                    $bot->reply("❌ Error! " . $e->getMessage());
                }
            };

        }
    }