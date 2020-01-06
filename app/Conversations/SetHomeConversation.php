<?php


    namespace App\Conversations;


    use App\Connector\ChatCharLink;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Helpers\CharacterSettings;
    use Illuminate\Foundation\Inspiring;
    use BotMan\BotMan\Messages\Incoming\Answer;
    use BotMan\BotMan\Messages\Outgoing\Question;
    use BotMan\BotMan\Messages\Outgoing\Actions\Button;
    use BotMan\BotMan\Messages\Conversations\Conversation;
    use Illuminate\Support\Facades\Log;
    use PHPUnit\Exception;

    class SetHomeConversation extends Conversation {

        /** @var ResourceLookupService */
        protected $resourceLookup;

        protected $charId;
        protected $charName;
        /**
         * @var ?int
         */
        protected $previousHomeId;
        /**
         * @var ?string
         */
        protected $previousHomeName;
        /**
         * @var ?string
         */
        protected $previousHomeType;
        /**
         * @var ?string
         */
        protected $newHomeType;
        /**
         * @var ?int
         */
        protected $newHomeId;


        public function confirmUser() {

            try {

                $question = ($this->previousHomeId ? "Your previous home set here is " . $this->previousHomeName : "You don't have a home set here yet.");
                $q = Question::create(sprintf("Would you like to set a new home for %s 🏠? %s", $this->charName, $question))
                    ->callbackId("confirm_new_home")
                    ->addButtons([
                        Button::create("Yes, set a new home")->value("yes"),
                        Button::create("No")->value("no"),
                    ]);

                return $this->ask($q, $this->askCitadelOrStation());

            } catch (\Exception $e) {
                $this->say($e->getMessage());
            }
        }


        /**
         * @return \Closure
         */
        private function askCitadelOrStation(): \Closure {
            return function (Answer $answer) {
                try {

                    if ($answer->isInteractiveMessageReply()) {
                        if ($answer->getValue() === 'yes') {

                            $stationType = Question::create("Is the new home a Station or an Upwell Structure?")
                                ->callbackId("new_home_upwell_or_structure")
                                ->addButtons([
                                    Button::create("Station")->value("station"),
                                    Button::create("Structure (Citadel)")->value("structure")
                                ]);
                            $this->ask($stationType, $this->handleStationResponse());
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
        function handleStationResponse(): \Closure {

            return function (Answer $answer2) {
                try {
                    if ($answer2->isInteractiveMessageReply()) {
                        $this->newHomeType = $answer2->getText();
                        $this->say(sprintf("Sure. %s selected", ucfirst($answer2->getText())));
                        $this->askForStationName();
                    } else {
                        $this->say("Please select a button instead of typing");
                    }
                } catch (\Exception $e) {
                    $this->say($e->getMessage());
                }
            };
        }

        private function askForStationName() {
            try {
                $getFullName = Question::create("Please paste  the full name of your home, for example 'Jita IV - Moon 4 - Caldari Navy Assembly Plant'");
                $this->ask($getFullName, function (Answer $answer3) {
                    if ($answer3->getText() == "cancel") {
                        $this->say("Alright, cancelled.");
                        return;
                    }

                    $this->newHomeId = null;
                    $homeName = trim($answer3->getText());
                    if (strtolower($this->newHomeType) == "station") {
                        try {
                            $this->newHomeId = $this->resourceLookup->getStationId($homeName);
                        } catch (\Exception $e) {
                            $this->say("❌ Error: " . $e->getMessage());
                            Log::info($e->getMessage());
                        }
                        if ($this->newHomeType == null) {
                            $this->say("⚠ Could not find this station ($homeName). Please write cancel to cancel or try again and watch for typos");
                            $this->askForStationName();
                        } else {
                            CharacterSettings::setSetting($this->charId, "HOME_ID", $this->newHomeId);
                            CharacterSettings::setSetting($this->charId, "HOME_TYPE", "station");

                            $this->say("Saved! ✔");
                        }
                    } else {
                        try {
                            $this->newHomeId = $this->resourceLookup->getStructureId($homeName);
                        } catch (\Exception $e) {
                            $this->say("❌ Error: " . $e->getMessage());
                            Log::info($e->getMessage());
                        }
                        if ($this->newHomeType == null) {
                            $this->say("⚠ Could not find this structure ($homeName). Please write cancel to cancel or try again and watch for typos");
                            $this->askForStationName();
                        } else {
                            CharacterSettings::setSetting($this->charId, "HOME_ID", $this->newHomeId);
                            CharacterSettings::setSetting($this->charId, "HOME_TYPE", "structure");

                            $this->say("Saved! ✔");
                        }
                    }
                });
            } catch (\Exception $e) {
                $this->say($e->getMessage());
            }
        }

        /**
         * @return mixed
         */
        public function run() {

            try {

                $this->resourceLookup = new ResourceLookupService();

                $this->charId = ChatCharLink::getActive($this->bot->getUser()->getId());
                $this->charName = $this->resourceLookup->getCharacterName($this->charId);

                $this->previousHomeId = CharacterSettings::getSettings($this->charId, "HOME_ID");
                $this->previousHomeType = CharacterSettings::getSettings($this->charId, "HOME_TYPE");

                switch ($this->previousHomeType) {
                    case "station":
                        $this->previousHomeName = $this->resourceLookup->getStationName($this->previousHomeId);
                        break;
                    case "structure":
                        $this->previousHomeName = $this->resourceLookup->getStructureName($this->previousHomeId);
                        break;
                }

                $this->confirmUser();
            } catch (\Exception $e) {
                $this->say($e->getMessage());
            }
        }

    }