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
	use function GuzzleHttp\Psr7\str;

	class SetHomeConversationDiscord extends Conversation {

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

        /** @var int */
        protected $attempts;


        public function confirmUser() {

            try {

                $question = ($this->previousHomeId ? "Your previous home set here is " . $this->previousHomeName : "You don't have a home set here yet.");
                $q = sprintf("Would you like to set a new home for %s 🏠? %s\r\nPlease respond *yes* or *no*.", $this->charName, $question);
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
                        if ($answer->getText() === 'yes') {
                            $stationType = "Is the new home a Station or an Upwell Structure?\r\nPlease respond with `station` or `structure`";
                            $this->ask($stationType, $this->handleStationResponse());
                        } else {
                            $this->say("Sure. You replied ".$answer->getText());
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
			$this->attempts++;

            return function (Answer $answer2) {
                try {
					$this->newHomeType = $answer2->getText();
					if (in_array(strtoupper($this->newHomeType), ["STATION","STRUCTURE"])) {
						$this->say(sprintf("Sure. %s selected", ucfirst($answer2->getText())));
						$this->askForStationName();
					}
					else {
						$this->say("Please say `station` or `structure`, I don't understand what you said. ");
						if ($this->attempts > 5) {
							$this->say("Please start from the beginning, we could not get set a home in 5 tries.");
							return;
						}
						$this->askCitadelOrStation();
					}
                } catch (\Exception $e) {
                    $this->say($e->getMessage());
                }
            };
        }

        private function askForStationName() {
			$this->attempts++;

			if ($this->attempts > 5) {
				$this->say("Please ask something else.");
				return;
			}
            try {
                $getFullName = "Please paste  the full name of your home, for example `Jita IV - Moon 4 - Caldari Navy Assembly Plant`";
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
                            $this->say(sprintf("⚠ Could not find this station (_%s_). Please write `cancel` to cancel or try again and watch for typos", $homeName));
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
                            $this->say(sprintf("⚠ Could not find this structure (_%s_). Please write cancel to cancel or try again and watch for typos", $homeName));
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
		$this->attempts = 0;
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