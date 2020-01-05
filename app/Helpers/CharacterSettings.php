<?php


    namespace App\Helpers;


    use Illuminate\Support\Facades\DB;

    class CharacterSettings {

        /**
         * Gets a char setting
         * @param int    $charId EVE char ID
         * @param string $key Setting key code
         * @return string|null
         */
        public static function getSettings(int $charId, string $key):?string {

            $condition = DB::table("charsettings")
                ->where("CHAR_ID", "=", $charId)
                ->where("PARAM", "=", $key);

            if (!$condition->exists()) {
                return null;
            }
            else {
                return $condition->get()->get(0)->VAL;
            }
        }

        /**
         * Sets a char setting
         * @param int    $charId EVE char ID
         * @param string $key Setting key code
         * @param string $value
         */
        public static function setSetting(int $charId, string $key, string $value) {

            $condition = DB::table("charsettings")
                ->where("CHAR_ID", "=", $charId)
                ->where("PARAM", "=", $key);

            if ($condition->exists()) {
                $condition->delete();
            }

            DB::table("charsettings")
                ->insert([
                   "CHAR_ID" => $charId,
                   "PARAM" => $key,
                   "VAL" => $value
                ]);
        }
    }