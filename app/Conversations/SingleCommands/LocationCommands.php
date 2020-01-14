<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
	use App\Connector\DotlanConnector\Entities\RouteStep;
	use App\Connector\DotlanConnector\RouteConnector;
	use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Location\LocationService;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
	use App\Connector\SecurityStatusTools;
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
                    $charId = ChatCharLink::getActive($bot->getUser()->getId());

                    switch (mb_strtolower($target)) {
                        case "jita":
                            $target_id = "60003760";
                            $name = "Jita (Trade hub station 🚚)";
                            break;
                        case "hek":
                            $target_id = "60005686";
                            $name = "Hek (Trade hub station 🚚)";
                            break;
                        case 'amarr':
                            $target_id = "60008494";
                            $name = "Amarr (Trade hub station 🚚)";
                            break;
                        case 'rens':
                            $target_id = "60004588";
                            $name = "Rens (Trade hub station 🚚)";
                            break;
                        case 'dodixie':
                            $target_id = "60011866";
                            $name = "Dodixie (Trade hub station 🚚)";
                            break;
                        case 'home':
                            $target_id = CharacterSettings::getSettings($charId, "HOME_ID");
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

                    $this->locationService->setWaypoint($charId, $target_id);
                    $bot->reply("Route set to $name - Follow the waypoints or press Ctrl+S in EVE to toggle the autopilot.");
                } catch (\Exception $e) {
                    $bot->reply("Could not set waypoint: " . $e->getMessage(). " (".$e->getFile()."@".$e->getLine().")");
                }
            };
        }



		/**
		 * @return Closure
		 */
		function autoScout() : Closure {
			return function (BotMan $bot, string $a, string $b, $c) {
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

					$m = sprintf("🗺 Showing the %s route from %s to %s (%d jumps)", $typeS, ucfirst($a), ucfirst($b), count($systems));
					$sovs = [];
					$ssmin = new RouteStep('', +1.0);
					$ssmax = new RouteStep('', -1.0);
					$shoot = false;
					$sys = [];
					$chatId = $bot->getUser()->getId();
					$charId = ChatCharLink::getActive($chatId);
					$secStatus = $this->rlp->getSecurityStatus($charId);
					$shoot = 0;
					$camps = 0;
					foreach ($systems as $i => $system) {
						if (SecurityStatusTools::willFactionPoliceShootAtMe($secStatus, $system->securityStatus)) {
							$safe = "🏴";
							$shoot++;
						} else {
							$safe = "";
						}

						if ($system->kills >= 10) {
							$camp = sprintf("🏴‍☠️(%d kills lately)", $system->kills);
							$camps++;
						} else {
							$camp = "";
						}

						$sys[] = sprintf("%s (%1.1f)%s%s", $system->solarSystem, $system->securityStatus, $safe, $camp);
						$sovs[] = $system->sovereignty;
						if ($system->securityStatus < $ssmin->securityStatus) {
							$ssmin = $system;
						}
						if ($system->securityStatus > $ssmax->securityStatus) {
							$ssmax = $system;
						}

					}
					$m .= "\r\n\r\n 👉 " . implode("\r\n", $sys);
//			$m .= "\r\n\r\n 👉 " . implode(" » ", $sys);
					$m .= sprintf("\r\n\r\n 🛂 This route passes through the territories of %s (in route order)", implode(', ', array_unique($sovs)));
					$m .= sprintf("\r\n\r\n 👮‍ The route's minimum security status is %1.1f in %s and maximum is %1.1f in %s", $ssmin->securityStatus, $ssmin->solarSystem, $ssmax->securityStatus, $ssmax->solarSystem);

					if ($shoot) {
						$m .= sprintf("\r\n\r\n 🏴 Warning! Faction police will shoot at you in %d system%s marked with the black flag, because your security status is %1.2f", $shoot, (($shoot > 1) ? "s" : ""), $secStatus);
					}
					if ($camps) {
						$m .= "\r\n\r\n 🏴‍☠️ Warning! The systems marked with a pirate flag had more than 10 kills in the last 3 hours - this could be a gatecamp.";
					}
					$bot->reply($m);
				} catch (\Exception $e) {
					$bot->reply($e->getMessage() . " " . $e->getFile() . " " . $e->getLine());
				}
			};
		}
    }