<?php

namespace App\Console\Commands;

use App\Connector\EveAPI\Location\LocationService;
use App\Connector\EveAPI\Universe\ResourceLookupService;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RouteChecks extends Command
{
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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $table = DB::table("route_checks");


        // All routes
        if ($table->count() == 0) {
            $this->info("No routes to check");
            return;
        }

        // Clean expired
        $table->whereRaw('expired_at < NOW()')->delete();


        $checks = $table->get();
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
                $bot = resolve("BotMan");
                $driver = $entry->CHAT_TYPE == 'telegram' ? TelegramDriver::class : FacebookDriver::class;
                $bot->say(sprintf("🎇 Attention: We have reached %s", $rlp->getSystemName($entry->TARGET_SYS_ID)), $entry->CHAT_ID, $driver);
                DB::table('route_checks')->where('CHAR_ID', '=', $entry->CHAR_ID);
                $this->info(sprintf("%d got to %d", $entry->CHAR_ID, $entry->TARGET_SYS_ID));
            }
            else {
                $this->info(sprintf("%d is at %d not %d", $entry->CHAR_ID, $entry->TARGET_SYS_ID, $loc->solar_system_id));
            }
        }
        catch (\Exception $e) {
            $this->error($e);
        }
    }
}
