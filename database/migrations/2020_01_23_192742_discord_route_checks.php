<?php

    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DiscordRouteChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `route_checks` CHANGE `CHAT_TYPE` `CHAT_TYPE` ENUM('fb-messenger','telegram','discord') CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL COMMENT 'Chat type. Needed for where to contact the capsuleer.';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `route_checks` CHANGE `CHAT_TYPE` `CHAT_TYPE` ENUM('fb-messenger','telegram') CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL COMMENT 'Chat type. Needed for where to contact the capsuleer.';");
    }
}
