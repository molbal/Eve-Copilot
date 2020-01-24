<?php


	namespace App\Conversations\SingleCommands;


	use App\Connector\ChatCharLink;
	use App\Connector\EveAPI\Location\LocationService;
	use App\Connector\EveAPI\Universe\ResourceLookupService;
	use App\Helpers\ConversationCache;
	use BotMan\BotMan\BotMan;
	use Closure;
	use Illuminate\Support\Facades\Cache;
	use Illuminate\Support\Facades\Log;
	use stringEncode\Exception;

	class IntelCommands
	{

		private $rlp;

		private $location;

		/**
		 * LocationCommands constructor.
		 *
		 * @param ResourceLookupService $rlp
		 * @param LocationService       $location
		 */
		public function __construct(ResourceLookupService $rlp, LocationService $location)
		{
			$this->rlp = $rlp;
			$this->location = $location;
		}


		/**
		 * @return Closure
		 */
		public function simpleWhois() : Closure
		{
			return function (BotMan $bot, string $charId) {
				try {
					$bot->reply($this->rlp->getStationId($charId));
					//$bot->reply("Looking up code..");
					//$bot->reply(print_r($this->rlp->getCharacterName($charId), 1));
				} catch (\Exception $e) {
					$bot->reply("Cannot find this character: " . $e->getMessage());
				}
			};
		}

		/**
		 * @return Closure
		 */
		public function howElite() : Closure
		{
			return function (BotMan $bot, string $targetName) {

				try {
					$targetId = $this->rlp->getCharacterId($targetName);
					if (Cache::has("quickcache-$targetName")) {
						$ret = Cache::get("quickcache-$targetName");
					} else {
						$ret = file_get_contents("https://zkillboard.com/api/stats/characterID/$targetId/");
						Cache::put("quickcache-$targetName", $ret, 30);
					}
					$ret = json_decode($ret);
					$m = sprintf("😏 ELITE analysis for $targetName");
					$m .= "\r\n";
					$m .= sprintf("\r\n Kills efficiency: %d destroyed, %d lost, ratio: %1.1f%%", $ret->shipsDestroyed, $ret->shipsLost, ($ret->shipsDestroyed/max(1,$ret->shipsDestroyed+$ret->shipsLost))*100);
					$m .= sprintf("\r\n Points efficiency: %d destroyed, %d lost, ratio: %1.1f%%", $ret->pointsDestroyed, $ret->pointsLost, ($ret->pointsDestroyed/max(1,$ret->pointsDestroyed+$ret->pointsLost))*100);
					$m .= sprintf("\r\n ISK efficiency: %s ISK destroyed, %s ISK lost, ratio: %1.1f%%", number_format($ret->iskDestroyed, 0, ""," "), number_format($ret->iskLost, 0, ""," "), ($ret->iskDestroyed/max(1,$ret->iskDestroyed+$ret->iskLost))*100);

					$bot->reply($m);
				} catch (\Exception $e) {
					$bot->reply("Sorry, can't check how elite this guy is. Probably there is a typo in its name or it is missing from zKillboard.".$e->getMessage()." ".$e->getFile()." ".$e->getLine());
				}
			};
		}

		/**
		 * Identifies a character
		 *
		 * @return Closure
		 */
		public function identify() : Closure
		{
			return function (BotMan $bot, string $targetName) {
				try {
					$targetId = $this->rlp->getCharacterId($targetName);

					if (Cache::has("quickcache-$targetName")) {
						$ret = Cache::get("quickcache-$targetName");
					} else {
						$ret = file_get_contents("https://zkillboard.com/api/stats/characterID/$targetId/");
						Cache::put("quickcache-$targetName", $ret, 30);
					}
					$stats = json_decode($ret);
					if (!isset($stats->info->name)) {
						$bot->reply("I couldn't find  any info for this capsuleer, sorry.");
					} else {

						$targetName = $stats->info->name;

						try {
							$winRatio = $stats->shipsDestroyed / (($stats->shipsLost ?? 0) + ($stats->shipsDestroyed ?? 0)) * 100;
						} catch (\Exception $e) {
							$winRatio = 0;
						}

						$m = sprintf("🕵️‍♂️ Target pilot is %s (%1.1f security status).\r\n\r\nTarget has %d confirmed kills, %d%% dangerous, wins %2.1f%% of its fights and %d%% likely to call and receive reinforcements. (According to zKillboard)", $targetName, $stats->info->secStatus, $stats->allTimeSum ?? 0, $stats->dangerRatio ?? 0, $winRatio, $stats->gangRatio ?? 0);

						$convId = $bot->getUser()->getId();
						ConversationCache::put($convId, "identify-char-id", $targetId, 15);
						ConversationCache::put($convId, "identify-char-name", $targetName, 15);
						$bot->reply($m);
					}
				} catch (\Exception $e) {
					$bot->reply("Sorry, I can't find this pilot. 😫 ");
				}
			};
		}

		/**
		 * Executes a location aware, more thorough scan for the target capsuleer.
		 *
		 * @return Closure
		 */
		public function thoroughScan() : Closure
		{
			return function (BotMan $bot, $targetName = "") {
				try {
					$convId = $bot->getUser()->getId();
					if ($targetName) {
						$targetId = $this->rlp->getCharacterId($targetName);
					} else if (ConversationCache::has($convId, "identify-char-id")) {
						$targetName = ConversationCache::get($convId, "identify-char-name");
						$targetId = ConversationCache::get($convId, "identify-char-id");
					} else {
						throw new Exception("Sorry, could not find target character.");
					}

					if ($targetName == "") {
						throw new Exception("Sorry, could not find target character.");
					}

					// Query data
					if (Cache::has("quickcache-$targetName")) {
						$ret = Cache::get("quickcache-$targetName");
					} else {
						$ret = file_get_contents("https://zkillboard.com/api/stats/characterID/$targetId/");
						Cache::put("quickcache-$targetName", $ret, 30);
					}
					$ret = json_decode($ret);

					// Check most used ships
					$topShips = [];

					if (is_array($ret->topAllTime)) {
						foreach ($ret->topAllTime as $list) {
							if ($list->type == "ship") {
								for ($i = 0; $i < min(7, count($list->data)); $i++) {
									$name = $this->rlp->generalNameLookup($list->data[$i]->shipTypeID);
									if ($name == "Capsule") continue;
									$topShips[] = sprintf("%s (%d kills)", $name, $list->data[$i]->kills);
								}
							}
						}
					}

					// Location aware threat estimation
					Log::info($convId);
					$charId = ChatCharLink::getActive($convId);
					$myLocation = $this->location->getCurrentLocation($charId);

					$topSystems = [];
					$currentSystem = 0;
					if (is_array($ret->topAllTime)) {
						foreach ($ret->topAllTime as $list) {
							if ($list->type == "system") {
								for ($i = 0; $i < min(7, count($list->data)); $i++) {
									$topSystems[] = sprintf("%s (%d kills)", $this->rlp->getSystemName($list->data[$i]->solarSystemID), $list->data[$i]->kills);
								}
								foreach ($list->data as $sys) {
									if ($sys->solarSystemID == $myLocation->solar_system_id) {
										$currentSystem = $sys->kills;
									}
								}
							}
						}
					}

					$m = sprintf("🚩 Threat estimation for %s", $targetName);
					$m .= "\r\n\r\n🚀 Target killed most in the following ships: " . implode(", ", $topShips);
					$m .= "\r\n\r\n☀ Target is most active in the following systems: " . implode(", ", $topSystems);
					if ($currentSystem > 0) {
						$m .= sprintf("\r\n\r\n⚠ You are currently in %s where the target has %d kills.", $myLocation->solar_system_name, $currentSystem);
					} else {
						$m .= sprintf("\r\n\r\nℹ You are currently in %s where the target is not active.", $myLocation->solar_system_name);
					}
					$bot->reply($m);
				} catch (\Exception $e) {
					Log::error($e->getTraceAsString());
					$bot->reply("Sorry, something went wrong while analysing. 😫" . $e->getFile() . " " . $e->getLine() . " " . $e->getMessage());
				}
			};
		}
	}