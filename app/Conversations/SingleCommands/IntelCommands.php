<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use BotMan\BotMan\BotMan;
    use Closure;

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
    }