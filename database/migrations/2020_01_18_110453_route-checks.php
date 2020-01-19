<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RouteChecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_checks', function (Blueprint $table) {
            $table->enum('CHAT_TYPE', ['fb-messenger', 'telegram'])->comment("Chat type. Needed for where to contact the capsuleer.");
            $table->string('CHAT_ID', 64)->comment("Unique CHAT ID");
            $table->bigInteger('CHAR_ID')->primary()->comment("EVE Character ID");
            $table->bigInteger('TARGET_SYS_ID')->comment("Eve ID of the target solar system");
            $table->timestamp('created_at')->useCurrent()->comment('Time where the request was recorded');
            $table->timestamp('expires_at')->nullable()->comment('Time when the co-pilot stops checking the location. ');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_checks');
    }
}
