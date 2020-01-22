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
        /** @var DiscordBot $discordController */
        $discordController = resolve('App\Discord\DiscordBot');
        Log::info("Created Discord Controller");
        $discordController->handle();

    }

}
