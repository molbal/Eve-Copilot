<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use BotMan\BotMan\BotMan;
    use Closure;
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

                    $stats = json_decode(file_get_contents("https://zkillboard.com/api/stats/characterID/$targetId/"));
                    Log::info(print_r($stats, 1));
                    $bot->reply(print_r($stats->allTimeSum, 1));
                } catch (\Exception $e) {
                    $bot->reply("Cannot identify: " . $e->getMessage());
                }
            };
        }
    }