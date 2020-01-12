<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Characters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('characters', function (Blueprint $table) {

			$table->engine = 'InnoDB';

            $table->bigInteger('ID')->primary()->comment("EVE character ID");
            $table->string("NAME", 256)->comment("EVE character name");
            $table->string("REFRESH_TOKEN",1000)->comment("Eve OAuth2 Refresh Token");
            $table->string("CONTROL_TOKEN", 64)->index()->comment("this token must be provided in the chat to allow access to this character");
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("characters");
    }
}
