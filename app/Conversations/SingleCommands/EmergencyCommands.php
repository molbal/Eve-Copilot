<?php


	namespace App\Conversations\SingleCommands;


	use App\Connector\ChatCharLink;
	use App\Connector\EveAPI\Location\LocationService;
	use App\Connector\EveAPI\Mail\MailService;
	use App\Connector\EveAPI\Universe\ResourceLookupService;
	use App\Helpers\CharacterSettings;
	use BotMan\BotMan\BotMan;

	class EmergencyCommands
	{

		/** @var ResourceLookupService */
		private $rlp;
		/** @var LocationService */
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
		public function __construct(ResourceLookupService $rlp, LocationService $locationService, MailService $mailService)
		{
			$this->rlp = $rlp;
			$this->locationService = $locationService;
			$this->mailService = $mailService;
		}

		/**
		 * @return \Closure
		 */
		public function mayday() : \Closure
		{
			return function (BotMan $bot) {
				try {

					$charId = ChatCharLink::getActive($bot->getUser()->getId());
					$emergencyId = CharacterSettings::getSettings($charId, "EMERGENCY_CONTACT_ID");
					if (!$emergencyId) {
						$bot->reply("You don't have an emergency contact set! Write me 'Set emergency contact' to select an emergency response person");

						return;
					}
					$currentShip = $this->locationService->getCurrentShip($charId);
					$status = $this->locationService->getCurrentLocation($charId);

					if (isset($status->station_id)) {
						throw new \Exception("I will not send that message, you are not in danger. You are safely docked in ".$status->station_name);
					}
					if (isset($status->structure_id)) {
						throw new \Exception("I will not send that message, you are not in danger. You are safely docked in ".$status->structure_name);
					}

					$message = sprintf("Hi %s,<br>

MAYDAY

I am flying a <font size=\"12\" color=\"#ffd98d00\"><loc><a href=\"showinfo:%d\">%s</loc></a> </font> named <b>%s</b> in <font size=\"12\" color=\"#ffd98d00\"><loc><a href=\"showinfo:5//%d\">%s</loc></a></font>.

I need help

Thank you, 
%s
<br><br><br>------<br>
This emergency message was sent from the <font size=\"12\" color=\"#ffd98d00\"><a href=\"showinfo:2//98626398\">The EVE Co-Pilot</a><br>
                    ", $this->rlp->getCharacterName($emergencyId), $currentShip->ship_type_id, $currentShip->ship_type_name, $currentShip->ship_name, $status->solar_system_id, $status->solar_system_name, $this->rlp->getCharacterName($charId));


					if ($this->mailService->sendMaiItoCharacter($charId, $emergencyId, "HELP", $message)) {
						$bot->reply("✔ Request for reinforcements sent! 🛡");
					}
				} catch (\Exception $e) {
					$bot->reply("❌ Error! " . $e->getMessage());
				}
			};

		}
	}