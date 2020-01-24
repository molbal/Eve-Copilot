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

    class LinkCharacterConversationDiscord extends Conversation {

        /**
         * Asks for the control token
         */
        public function greetAndAskCode() {

            return $this->ask("Nice to meet you. Please enter your control token. If you don't have one yet, you can get one at https://co-pilot.eve-nt.uk/eve/auth/start", function(Answer $answer) {
            	$this->askCode();
            });
        }

        /**
         * Asks for the code
         */
        public function askCode() {
            $this->ask("Please paste the code here (Add nothing else to the message) or say cancel to cancel.", function (Answer $answer) {

                /** @var string $code */
                $code = trim($answer->getText());

                if (!$code) {
                    $this->say("I don't see a code.  🤔 Please enter it and send");
                    $this->askCode();
                    return;
                }

                if (strtoupper($code) == "CANCEL") {
					$this->say("Cancelled.");
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