<?php


    namespace App\Conversations;


    use BotMan\BotMan\Messages\Conversations\Conversation;
    use BotMan\BotMan\Messages\Incoming\Answer;
    use BotMan\BotMan\Messages\Outgoing\Actions\Button;
    use BotMan\BotMan\Messages\Outgoing\Question;
    use Illuminate\Support\Facades\DB;
    use function foo\func;
    use function Psy\debug;

    class LinkCharacterConversation extends Conversation {

        /**
         * Asks for the control token
         */
        public function greetAndAskCode() {

            $q = Question::create("Nice to meet you. Do you have the control token?")
            ->addButtons([
                Button::create("Yes, I have a control token")->value("yes"),
                Button::create("No, not yet")->value("no"),
            ]);

            return $this->ask($q, function(Answer $answer) {
                if ($answer->isInteractiveMessageReply() || in_array($answer->getValue(), ["yes", "no"])) {
                    switch ($answer->getValue()) {
                        case 'yes':
                            $this->say("Great 👍");
                            $this->askCode();
                            break;
                        case  'no':
                            $this->say("No worries. Click the link in the next message to get a token.");
                            $this->say(route("auth-start"));
                            $this->bot->typesAndWaits(2);
                            $this->say("Once you have a code, please paste it here.");
                            $this->askCode();
                            break;
                        default:
                            $this->say("Please click the buttons or respond with 'yes' or 'no'.");
                            $this->greetAndAskCode();
                            break;
                    }
                } else {
                    $this->say("Please click the buttons or respond with 'yes' or 'no'.");
                    $this->greetAndAskCode();
                }
            });
        }

        /**
         * Asks for the code
         */
        public function askCode() {
            $this->bot->typesAndWaits(1);
            $question = Question::create("Please paste the code here (Add nothing else to the message");
            $this->ask($question, function (Answer $answer) {

                /** @var string $code */
                $code = trim($answer->getValue());

                if (!$code) {
                    $this->say("Please enter a code");
                    $this->bot->typesAndWaits(1);
                    $this->askCode();
                    return;
                }

                $character = DB::table("characters")
                    ->where("CONTROL_TOKEN", '=', $code)
                    ->get();

                if ($character->count() != 1) {
                    if (!$code) {
                        $this->say("This code was not found. Remember, you can only use a code once. ");
                        $this->bot->typesAndWaits(1);
                        $this->askCode();
                        return;
                    }
                }

                $charId = $character->get(0)->ID;
                $charName = $character->get(0)->NAME;

                DB::table("characters")
                    ->where("ID", "=", $charId)
                    ->update(["CONTROL_TOKEN" => null]);

                dd($character);
            });
        }

        /**
         * @return mixed
         */
        public function run() {
            $this->greetAndAskCode();
        }

    }