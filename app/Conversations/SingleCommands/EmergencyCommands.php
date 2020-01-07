<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\Location\LocationService;
    use App\Connector\EveAPI\Mail\MailService;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Helpers\CharacterSettings;
    use BotMan\BotMan\BotMan;

    class EmergencyCommands {

        /** @var ResourceLookupService  */
        private $rlp;
        /** @var LocationService  */
        private $locationService;

        /** @var MailService */
        private $mailService;


        /**
         * LocationCommands constructor.
         *
         * @param ResourceLookupService $rlp
         * @param LocationService       $locationService
         * @param MailService           $mailService
         */
        public function __construct(ResourceLookupService $rlp, LocationService $locationService, MailService $mailService) {
            $this->rlp = $rlp;
            $this->locationService = $locationService;
            $this->mailService = $mailService;
        }

        /**
         * @return \Closure
         */
        public function mayday(): \Closure {
            return function (BotMan $bot) {
                try {
                    $message = "MAYDAY! \n";



                    $charId = ChatCharLink::getActive($bot->getUser()->getId());
                    $emergencyId = CharacterSettings::getSettings($charId, "EMERGENCY_CONTACT_ID");
                    if (!$emergencyId) {
                        $bot->reply("You don't have an emergency contact set! Write me 'Set emergency contact' to select an emergency response person");
                        return;
                    }
                    $currentShip = $this->locationService->getCurrentShip($charId);
                    $status = $this->locationService->getCurrentLocation($charId);
                    $message .= sprintf("I am in %s and I need immediate assistance.
                    I am flying a %s named  %s. Please send help ASAP!",
                        $status->solar_system_name,
                        $currentShip->ship_type_name,
                        $currentShip->ship_name);



                    if ($this->mailService->sendMaiItoCharacter($charId, $emergencyId, "HELP", $message)) {
                        $bot->reply("Message sent!");
                    }
                } catch (\Exception $e) {
                    $bot->reply("❌ Error! " . $e->getMessage(). " (".$e->getFile()."@".$e->getLine().")");
                }
            };

        }
    }