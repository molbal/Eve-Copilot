<?php


    namespace App\Discord;

    use App\Conversations\LinkCharacterConversation;
    use App\Conversations\SetEmergencyContactConversation;
    use App\Conversations\SetHomeConversation;
    use App\Conversations\SingleCommands\CharacterManagementCommands;
    use App\Conversations\SingleCommands\EmergencyCommands;
    use App\Conversations\SingleCommands\IntelCommands;
    use App\Conversations\SingleCommands\LocationCommands;
    use App\Conversations\SingleCommands\MiscCommands;
    use BotMan\BotMan\BotMan;
    use BotMan\BotMan\BotManFactory;
    use BotMan\BotMan\Drivers\DriverManager;
    use React\EventLoop\Factory;

    class DiscordBot {

        /** @var \BotMan\BotMan\BotMan  */
        protected $botman;

        /** @var \React\EventLoop\LoopInterface  */
        protected $loop;

        /**
         * DiscordBot constructor.
         *
         * @param $botman
         */
        public function __construct() {

            $config = [
                'discord' =>[
                    'token' => env('DISCORD_TOKEN'),
                    'options' => [
                        'disableClones' => true,
                        'disableEveryone' => true,
                        'fetchAllMembers' => false,
                        'messageCache' => true,
                        'messageCacheLifetime' => 600,
                        'messageSweepInterval' => 600,
                        'presenceCache' => false,
                        'userSweepInterval' => 600,
                        'ws.disabledEvents' => ['TYPING_START'],
                    ],
                ],
            ];


            // Load the driver(s) you want to use
            DriverManager::loadDriver(\JABirchall\BotMan\Drivers\Discord\DiscordDriver::class);
            $this->loop = Factory::create();

            $discordBotmanFactory = new \JABirchall\BotMan\Drivers\Discord\Factory();
            $this->botman = $discordBotmanFactory->createForDiscord($config, $this->loop);
        }


        public function handle() {


            $this->addCommands();

            // Start listening
            $this->botman->listen();
            $this->loop->run();
        }


        private function addCommands() {


            /**
             * Character management commands
             */
            /** @var CharacterManagementCommands $charManagement */
            $charManagement = resolve('App\Conversations\SingleCommands\CharacterManagementCommands');
            $this->botman->hears("Switch to {charName}", $charManagement->switchToCharacter());
            $this->botman->hears("My chars|My characters", $charManagement->listMyCharacters());
            $this->botman->hears('Link char|Link character|Add character|Add char', function (BotMan $bot) {
                $bot->startConversation(new LinkCharacterConversation);
            });
            $this->botman->hears('Set home|New home', function (BotMan $bot) {
                $bot->startConversation(new SetHomeConversation);
            });
            $this->botman->hears('New emergency contact|Set emergency contact', function (BotMan $bot) {
                $bot->startConversation(new SetEmergencyContactConversation);
            });


            /**
             * Location Service commands
             */
            /** @var LocationCommands $locationCommands */
            $locationCommands = resolve('App\Conversations\SingleCommands\LocationCommands');
            $this->botman->hears("Status", $locationCommands->statusCommand());
            $this->botman->hears("Navigate {target}", $locationCommands->navigateTo());
            $this->botman->hears("Navigate to {target}", $locationCommands->navigateTo());
            $this->botman->hears("Go to {target}", $locationCommands->navigateTo());
            $this->botman->hears("Set route to {target}", $locationCommands->navigateTo());
            $this->botman->hears("Scout route from {a} to {b} {c}", $locationCommands->autoScout());
            $this->botman->hears("Check route from {a} to {b} {c}", $locationCommands->autoScout());
            $this->botman->hears("Check between {a} and {b} {c}", $locationCommands->autoScout());
            $this->botman->hears("Scout between {a} and {b} {c}", $locationCommands->autoScout());
            $this->botman->hears("Route check {a} {b} {c}", $locationCommands->autoScout());
            $this->botman->hears("Autoscout {a} {b} {c}", $locationCommands->autoScout());
            $this->botman->hears("Scout route from {a} to {b}", $locationCommands->autoScout());
            $this->botman->hears("Check route from {a} to {b}", $locationCommands->autoScout());
            $this->botman->hears("Check between {a} and {b}", $locationCommands->autoScout());
            $this->botman->hears("Scout between {a} and {b}", $locationCommands->autoScout());
            $this->botman->hears("Route check {a} {b}", $locationCommands->autoScout());
            $this->botman->hears("Autoscout {a} {b}", $locationCommands->autoScout());
            $this->botman->hears("When do we get to {target}", $locationCommands->notifyWhenArrived());
            $this->botman->hears("Tell me when we reach {target}", $locationCommands->notifyWhenArrived());
            $this->botman->hears("Tell me when we get to {target}", $locationCommands->notifyWhenArrived());
            $this->botman->hears("Are we in {target} yet", $locationCommands->notifyWhenArrived());
            $this->botman->hears("Autoscout", function (BotMan $bot) {
                $info = "This command checks whether it is for your to travel this route. For the start system and end system give solar system names, and for the route type parameter give either: quickest, fast, quick, shortest, short for the shortest route, safe, safest, safer, highest for the safe route, and unsafe, unsafest, shadiest, lowest for the unsafe route.\r\nThe bot will check the security statuses of systems and compare it to your own, checking if faction police will shoot you. At the same time it checks kill numbers in system and notify you when the kill number is more than 10 for the last 3 hours. ";
                $bot->reply($info);
                $bot->reply("To use it send me 'Scout route from {Start system} to {End system} {Route type}' (You don't have to write the { characters } around the parameters)");
            });

            /**
             * Emergency contacts
             */
            /** @var EmergencyCommands $emergencyCommands */
            $emergencyCommands = resolve('App\Conversations\SingleCommands\EmergencyCommands');
            $this->botman->hears("mayday|call reinforcements|send help", $emergencyCommands->mayday());


            /**
             * Intelligence service
             */
            /** @var IntelCommands $intelService */
            $intelService = resolve('App\Conversations\SingleCommands\IntelCommands');
            $this->botman->hears("whois {charId}", $intelService->simpleWhois());
            $this->botman->hears("identify {targetName}", $intelService->identify());
            $this->botman->hears("ID {targetName}", $intelService->identify());
            $this->botman->hears("deep scan {targetName}", $intelService->thoroughScan());
            $this->botman->hears("thorough scan {targetName}", $intelService->thoroughScan());
            $this->botman->hears("threat estimation {targetName}", $intelService->thoroughScan());
            $this->botman->hears("deep scan", $intelService->thoroughScan());
            $this->botman->hears("thorough scan", $intelService->thoroughScan());
            $this->botman->hears("threat estimation", $intelService->thoroughScan());


            /**
             * Introduction & fallback command
             */
            /** @var MiscCommands $miscCommands */
            $miscCommands = resolve('App\Conversations\SingleCommands\MiscCommands');
            $this->botman->hears("Hi|Hello|Yo|Sup|Hey|o7|o/|Oi", $miscCommands->sayHi());
        }
    }