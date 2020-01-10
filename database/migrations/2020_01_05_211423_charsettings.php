<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Charsettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("charsettings", function (Blueprint $table) {
            $table->bigInteger("CHAR_ID");
            $table->string("PARAM", 32);
            $table->string("VAL", 512);
            $table->timestamp("CREATED_AT")->useCurrent();

            $table->primary(["CHAR_ID", "PARAM"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("charsettings");
    }
}
