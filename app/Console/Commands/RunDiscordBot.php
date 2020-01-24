<?php

namespace App\Console\Commands;

use App\Conversations\LinkCharacterConversation;
use App\Conversations\SetEmergencyContactConversation;
use App\Conversations\SetHomeConversation;
use App\Conversations\SingleCommands\CharacterManagementCommands;
use App\Conversations\SingleCommands\EmergencyCommands;
use App\Conversations\SingleCommands\IntelCommands;
use App\Conversations\SingleCommands\LocationCommands;
use App\Conversations\SingleCommands\MiscCommands;
use App\Discord\DiscordBot;
use BotMan\BotMan\BotMan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RunDiscordBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecp:discord_bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the Discord server';

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
    public function handle() {
    	if (Cache::has("DISCORD_BOT_RUNNING")) {
    		Log::info("Discord bot still running, not starting it again");
			return;
		}
		Cache::put("DISCORD_BOT_RUNNING", true, 1);
		Log::info("Starting Discord bot ");
		/** @var DiscordBot $discordController */
		$discordController = resolve('App\Discord\DiscordBot');
		Log::info("Created Discord Controller");
		try {
			$discordController->handle();
		}
		catch (\Exception $e) {
			Cache::forget("DISCORD_BOT_RUNNING");
			Log::error("Discord bot stops: ".$e);
		}
		Log::info("Discord bot running over");
		Cache::forget("DISCORD_BOT_RUNNING");

    }

}
