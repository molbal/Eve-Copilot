<?php


    namespace App\Conversations;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\ImageAPI;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Helpers\CharacterSettings;
    use BotMan\BotMan\Messages\Attachments\Image;
    use BotMan\BotMan\Messages\Incoming\Answer;
    use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
    use BotMan\BotMan\Messages\Outgoing\Question;
    use BotMan\BotMan\Messages\Outgoing\Actions\Button;
    use BotMan\BotMan\Messages\Conversations\Conversation;
    use Illuminate\Support\Facades\Log;

    class SetEmergencyContactConversation extends Conversation {

        /** @var ResourceLookupService */
        protected $resourceLookup;

        protected $charId;
        protected $charName;
        /**
         * @var ?int
         */
        protected $previousId;

        /**
         * @var ?string
         */
        protected $previousName;

        /**
         * @var ?int
         */
        protected $newId;


        public function confirmUser() {

            try {

                $question = ($this->previousId ? "Your previous emergency contact is  " . $this->previousName : " You don't have anyone set yet.");
                $q = Question::create(sprintf("Would you like to set a new emergency contact for %s 🏠? %s", $this->charName, $question))
                    ->callbackId("confirm_new_emergency_contact")
                    ->addButtons([
                        Button::create("Yes, set a new contact")->value("yes"),
                        Button::create("No")->value("no"),
                    ]);

                return $this->ask($q, $this->askNewContactName());

            } catch (\Exception $e) {
                $this->say($e->getMessage());
            }
        }


        /**
         * @return \Closure
         */
        private function askNewContactName(): \Closure {
            return function (Answer $answer) {
                try {

                    if ($answer->isInteractiveMessageReply()) {
                        if ($answer->getValue() === 'yes') {

                            $askNameContact = Question::create("Please tell me the full name of your new contact.");
                            $this->ask($askNameContact, $this->askForNewName());
                        } else {
                            $this->say("Sure.");
                        }
                    } else {
                        $this->say("Please select a button instead of typing");
                    }
                } catch (\Exception $e) {
                    $this->say($e->getMessage());
                }
            };
        }

        /**
         * @return \Closure
         */
        function askForNewName(): \Closure {
            return function (Answer $a) {
                $newName = trim($a->getText());

                if ($newName == "cancel") {
                    $this->say("Alright");
                    return;
                }

                try {
                    $this->newId = $this->resourceLookup->getCharacterId($newName);
                } catch (\Exception $e) {
                    $this->newId = null;
                }
                if (!$this->newId) {
                    $this->say("Sorry, I can't find a character by this name. Check for typos and try again or type cancel");
                    $this->askForNewName();
                } else {
                    CharacterSettings::setSetting($this->charId, "EMERGENCY_CONTACT_ID", $this->newId);
                    $this->say("Your new emergency contact is $newName!🛡");
                    $i = new Image(ImageAPI::getCharacterPortrait($this->newId));
                    $this->bot->reply((new OutgoingMessage(""))->withAttachment($i));
                }

            };
        }


        /**
         * @return mixed
         */
        public function run() {

            try {

                $this->resourceLookup = new ResourceLookupService();

                $this->charId = ChatCharLink::getActive($this->bot->getUser()->getId());
                $this->charName = $this->resourceLookup->getCharacterName($this->charId);

                $this->previousId = CharacterSettings::getSettings($this->charId, "EMERGENCY_CONTACT_ID");
                if ($this->previousId)
                $this->previousName = $this->resourceLookup->getCharacterName($this->previousId);

                $this->confirmUser();
            } catch (\Exception $e) {
                $this->say($e->getMessage());
            }
        }

    }