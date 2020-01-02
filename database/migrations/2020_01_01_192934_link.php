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
            $table->timestamps();
            $table->primary(['CHAT_ID', 'CHAR_ID']);
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
