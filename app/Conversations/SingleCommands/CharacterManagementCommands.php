<?php


    namespace App\Conversations\SingleCommands;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use Closure;

    class CharacterManagementCommands {

        /**
         * Lists characters
         * @return Closure
         */
        public static function listMyCharacters(): Closure {
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
                            $bot->reply("You don't have a character linked yet.");
                            break;
                        case 1:
                            $bot->reply("You have " . $switchedChar->count() . " character linked:");
                            break;
                        default:
                            $bot->reply("You have " . $switchedChar->count() . " characters linked:");
                            break;
                    }
                    for ($i = 0; $i < $switchedChar->count(); $i++) {


                        $me = $active == $switchedChar->get($i)->CHAR_ID ? " (Active)" : "";
                        $profile = new Image(ImageAPI::getCharacterPortrait($switchedChar->get($i)->CHAR_ID));
                        $message = OutgoingMessage::create($switchedChar->get($i)->NAME . $me)
                            ->withAttachment($profile);

                        // Reply message object
                        $bot->reply($message);
                    }
                    $bot->reply("To add another character, say 'Link char'");
                } catch (Exception $e) {
                    $bot->reply("No characters for this chat. Add a new one with saying 'Link character'");
                }

            };
        }
    }