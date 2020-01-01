<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Link extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link', function (Blueprint $table) {
            $table->string("CHAT_ID", 64)->comment("Chat ID");
            $table->bigInteger('CHAR_ID')->comment("EVE character ID");
            $table->string("LINK_TOKEN", 32)->comment(" 	This token must be provided in the chat to allow access to this character");
            $table->timestamps();
            $table->primary(['CHAT_ID', 'CHAR_ID']);
            $table->foreign("CHAR_ID")->references('ID')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("link");
    }
}
