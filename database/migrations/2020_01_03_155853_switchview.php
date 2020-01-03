<?php

    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Switchview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW switchview AS
        SELECT l.`CHAT_ID` as `CHAT_ID`, l.`CHAR_ID` as `CHAR_ID`, c.`NAME` as `NAME` FROM `link` l LEFT JOIN `characters` c ON l.`CHAR_ID`=c.`ID`;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS switchview');
    }
}
