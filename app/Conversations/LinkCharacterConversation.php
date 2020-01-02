<?php


    namespace App\Conversations;


    use BotMan\BotMan\Messages\Conversations\Conversation;
    use BotMan\BotMan\Messages\Incoming\Answer;
    use BotMan\BotMan\Messages\Outgoing\Actions\Button;
    use BotMan\BotMan\Messages\Outgoing\Question;
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

            $this->ask($q, $this->handleUserHasControlCodeResponse);
        }

        /**
         * @return mixed
         */
        public function run() {
            $this->greetAndAskCode();
        }

        /**
         * @return \Closure
         */
        private function handleUserHasControlCodeResponse(): \Closure {
            return function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    switch ($answer->getValue()) {
                        case 'yes':
                            $this->say("Great. 👍 Please paste and send it without anything else in the message.");
                            break;
                        case  'no':
                            $this->say("No worries. Click the link in the next message to get a token.");
                            $this->say(route("auth-start"));
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
            };
        }
    }