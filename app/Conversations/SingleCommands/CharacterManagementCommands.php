<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;

    class CharacterManagementCommands {

        private $resourceLookupService;

        /**
         * CharacterManagementCommands constructor.
         *
         * @param $resourceLookupService ResourceLookupService
         */
        public function __construct(ResourceLookupService $resourceLookupService) {
            $this->resourceLookupService = $resourceLookupService;
        }


        /**
         * Switches to another character
         * @return \Closure
         */
        public function switchToCharacter(): \Closure {
            return function (BotMan $bot, string $charName) {

                try {
                    $chatId = $bot->getUser()->getId();
                    $switchedChar = ChatCharLink::getSwitchedChar($chatId, $charName);
                    ChatCharLink::setActive($chatId, $switchedChar);

                    $bot->reply("My Captain is now " . $this->resourceLookupService->getCharacterName($switchedChar) . " 👨‍✈️");
                } catch (\Exception $e) {
                    $bot->reply("Cannot find this character. To check which characters you have linked, say 'My characters'");
                }

            };
        }

        /**
         * Lists characters
         * @return \Closure
         */
        public function listMyCharacters(): \Closure {
            return function (BotMan $bot) {
                try {
                    $chatId = $bot->getUser()->getId();
                    $switchedChar = ChatCharLink::listMyChars($chatId);

                    $active = 0;
                    try {
                        $active = ChatCharLink::getActive($chatId);
                    } catch (\Exception $e) {
                    }
                    switch ($switchedChar->count()) {
                        case 0:
                            $firstline = "You don't have a character linked yet.";
                            break;
                        case 1:
                            $firstline = "You have " . $switchedChar->count() . " character linked:";
                            break;
                        default:
                            $firstline = "You have " . $switchedChar->count() . " characters linked:";
                            break;
                    }
                    $chars = [];
                    for ($i = 0; $i < $switchedChar->count(); $i++) {
                        $me = $active == $switchedChar->get($i)->CHAR_ID ? " (Active 👨‍✈️)" : "";
                        $chars [] = $switchedChar->get($i)->NAME . $me;
                    }
                    $bot->reply($firstline."\n".implode(", ", $chars) ."\n"."To add ".($switchedChar->count() > 0 ? "another" : "your first")." character, say 'Add char'");
                } catch (\Exception $e) {
                    $bot->reply("No characters for this chat. Add a new one with saying 'Link character'");
                }

            };
        }
    }