<?php

    namespace App\Console\Commands;

    use App\Connector\EveAPI\Location\LocationService;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use BotMan\BotMan\BotMan;
    use BotMan\Drivers\Facebook\FacebookDriver;
    use BotMan\Drivers\Telegram\TelegramDriver;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use JABirchall\BotMan\Drivers\Discord\DiscordDriver;
    use mysql_xdevapi\Exception;

    class RouteChecks extends Command {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'ecp:routecheck';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Checks locations';

        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct() {
            parent::__construct();
        }

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle() {

            // All routes
            if (DB::table("route_checks")->count() == 0) {
                $this->info("No route checks");
                return;
            }

            // Clean expired
            DB::table("route_checks")->whereRaw('expires_at < NOW()')->delete();

            $checks = DB::table("route_checks")
                ->select(['CHAR_ID', 'CHAT_ID', 'TARGET_SYS_ID', 'CHAT_TYPE'])
                ->selectRaw('TIME_TO_SEC(TIMEDIFF(NOW(), created_at)) diff')
                ->get();
            foreach ($checks as $check) {
                $this->checkRoute($check);
            }
        }

        private function checkRoute($entry) {
            /** @var ResourceLookupService $rlp */
            $rlp = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

            /** @var LocationService $ls */
            $ls = resolve('App\Connector\EveAPI\Location\LocationService');
            try {
                $loc = $ls->getCurrentLocation($entry->CHAR_ID);
                if ($loc->solar_system_id == $entry->TARGET_SYS_ID) {
                    /** @var BotMan $bot */
                    $bot = resolve("botman");
                    $driver = $this->getDriver($entry);
                    $hours = floor($entry->diff / 3600);
                    $mins = floor($entry->diff / 60 % 60);
                    $secs = floor($entry->diff % 60);
                    $bot->say(
                        sprintf(
                            "🎇 We have just reached %s (in about %02d:%02d:%02d)",
                            $rlp->getSystemName($entry->TARGET_SYS_ID),
                            $hours,
                            $mins,
                            $secs),
                        $entry->CHAT_ID,
                        $driver
                    );
                    DB::table('route_checks')->where('CHAR_ID', '=', $entry->CHAR_ID)->delete();
                }
            } catch (\Exception $e) {
                Log::error($e . " " . $e->getTraceAsString());
            }
        }

        /**
         * @param $entry
         * @return string
         */
        private function getDriver($entry): string {
            switch ($entry->CHAT_TYPE) {
                case 'telegram':
                    return TelegramDriver::class;
                case 'fb-messenger':
                    return FacebookDriver::class;
                case 'discord':
                    return DiscordDriver::class;
            }
        }
    }
