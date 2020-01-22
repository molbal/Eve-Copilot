<?php


    namespace App\Conversations;


    use App\Connector\ChatCharLink;
    use App\Helpers\ConversationCache;
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
                Button::create("Yes, I have a token")->value("yes"),
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
            $question = Question::create("Please paste the code here (Add nothing else to the message)");
            $this->ask($question, function (Answer $answer) {

                /** @var string $code */
                $code = trim($answer->getText());

                if (!$code) {
                    $this->say("I don't see a code.  🤔 Please enter it and send");
                    $this->bot->typesAndWaits(1);
                    $this->askCode();
                    return;
                }
                DB::beginTransaction();

                $character = DB::table("characters")
                    ->where("CONTROL_TOKEN", '=', $code)
                    ->get();

                if ($character->count() != 1) {
                    DB::rollBack();
                    if (!$code) {
                        $this->say("This code was not found. 🤔 Remember, you can only use a code once.");
                        $this->bot->typesAndWaits(1);
                        $this->askCode();
                        return;
                    }
                }

                $charId = $character->get(0)->ID;
                $charName = $character->get(0)->NAME;

                // Clean control token
                DB::table("characters")
                    ->where("ID", "=", $charId)
                    ->update(["CONTROL_TOKEN" => ""]);

                // Clean DB
                DB::table("link")
                    ->where('CHAT_ID', '=', $this->bot->getUser()->getId())
                    ->where('CHAR_ID', '=', $charId)
                    ->delete();

                // Insert new link
                DB::table("link")
                    ->insert([
                        'CHAT_ID' => $this->bot->getUser()->getId(),
                        'CHAR_ID' => $charId,
                        "active" => 0
                    ]);

                // Commit
                DB::commit();

                // Respond
                $this->say("Perfect. I am now a co-pilot for ".$charName." 👨‍✈️");
                $this->say("Now you can use advanced commands such as 'Identify $charName' or others. If you haven't done it yet, now is a great time to see my features at https://co-pilot.eve-nt.uk");

                // Set current link as active
                ChatCharLink::setActive($this->bot->getUser()->getId(), $charId);
            });
        }

        /**
         * @return mixed
         */
        public function run() {
            $this->greetAndAskCode();
        }

    }