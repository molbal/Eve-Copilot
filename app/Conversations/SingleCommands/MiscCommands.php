<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use BotMan\BotMan\BotMan;
    use Closure;

    class MiscCommands {

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
        public function sayHi(): Closure {
            return function (BotMan $bot) {
                $bot->reply("Hi, nice to meet you. 🙋‍ \n".
                "I am a chatbot based virtual assistant to aid your character in EVE Online. \n".
                "I cam assist you with day to day navigation, intelligence, messaging and intelligence tasks. \n".
                "You can find all my capabilities on my homepage: https://co-pilot.eve-nt.uk/ \n".
                "To get started, write me 'Add char' \n".
                "Fly safe 🖖");
            };
        }

        /**
         * Fallback function
         *
         * @return Closure
         */
        public function fallback(): Closure {
            return function (BotMan $bot) {
                $bot->reply("🤷‍♂️ Sorry, I did not understand what you said. \r\nYou can find everything I understand here: https://co-pilot.eve-nt.uk#features");
            };
        }
    }