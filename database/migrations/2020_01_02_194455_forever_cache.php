<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeverCache extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("forevercache", function (Blueprint $table) {
           $table->unsignedBigInteger("ID")->primary();
           $table->timestamp("created_at")->useCurrent();
           $table->string("Name", 256)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("forevercache");
    }
}
