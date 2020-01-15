<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Helpers\ConversationCache;
    use BotMan\BotMan\BotMan;
    use Closure;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;

    class IntelCommands {

        private $rlp;

        /**
         * LocationCommands constructor.
         *
         * @param ResourceLookupService $rlp
         */
        public function __construct(ResourceLookupService $rlp) {
            $this->rlp = $rlp;
        }


        /**
         * @return Closure
         */
        public function simpleWhois(): Closure {
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
         * Identifies a character
         *
         * @return Closure
         */
        public function identify(): Closure {
            return function (BotMan $bot, string $targetName) {
                try {
                    $targetId = $this->rlp->getCharacterId($targetName);

                    if (Cache::has("quickcache-$targetName")) {
                        $ret = Cache::get("quickcache-$targetName");
                    }
                    else {
                        $ret = file_get_contents("https://zkillboard.com/api/stats/characterID/$targetId/");
                        Cache::put("quickcache-$targetName", $ret, 30);
                    }
                    $stats = json_decode($ret);
                    $targetName = $stats->info->name;

                    $m = sprintf("🕵️‍♂️ Target pilot is %s (%1.1f security status).\r\n\r\nTarget has %d confirmed kills, %d%% dangerous, wins %2.1f%% of its fights and %d%% likely to call and receive reinforcements.",
                        $targetName,
                        $stats->info->secStatus,
                        $stats->allTimeSum,
                        $stats->dangerRatio,
                        $stats->shipsDestroyed/($stats->shipsLost+$stats->shipsDestroyed)*100,
                        $stats->gangRatio
                    );

                    ConversationCache::put($bot->getUser()->getId(), "identify-char-id", $targetId, 15);
                    Log::info(print_r($stats, 1));
                    $bot->reply($m);
                } catch (\Exception $e) {
                    $bot->reply("Sorry, I can't find this pilot. 😫");
                }
            };
        }
    }