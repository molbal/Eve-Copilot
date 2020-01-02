<?php


    namespace App\Connector;


    use App\Helpers\ConversationCache;
    use Illuminate\Support\Facades\DB;

    class ChatCharLink {

        /**
         * Sets the active character for a conversation
         * @param $chatId string Botman Chat ID
         * @param $charId int EVE Char ID
         */
        public static function setActive(string $chatId, int $charId): void {
            DB::beginTransaction();
                DB::table("link")
                    ->where("CHAT_ID", '=', $chatId)
                    ->update(["active" => 0]);

                DB::table("link")
                    ->where("CHAT_ID", '=', $chatId)
                    ->where("CHAR_ID", '=', $charId)
                    ->update(["active" => 1]);
            DB::commit();

            ConversationCache::forget($chatId, "ActiveCharacterId");
            ConversationCache::put($chatId, "ActiveCharacterId", $charId, 30);
        }

        /**
         * Returns the currently active EVE Character for a conversation
         * @param string $chatId
         * @return int
         */
        public static function getActive(string $chatId): int {
            $cacheValue = ConversationCache::get($chatId, "ActiveCharacterId");
            if ($cacheValue) {
                return intval($cacheValue);
            }

            $ret = DB::table("link")
                ->where("CHAT_ID", '=', $chatId)
                ->where("active", '=', 1)
                ->get('CHAR_ID');

            $charId = $ret->get(0)->CHAR_ID;

            ConversationCache::put($chatId, "ActiveCharacterId", $charId, 30);
            return $charId;
        }
    }