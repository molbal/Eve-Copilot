<?php


    namespace App\Connector;


    use App\Helpers\ConversationCache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use InvalidArgumentException as InvalidArgumentExceptionAlias;

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

            if (!DB::table("link")
                ->where("CHAT_ID", '=', $chatId)
                ->where("active", '=', 1)
                ->exists()) {
                throw new \RuntimeException("No active characters for this chat!");
            }

            $ret = DB::table("link")
                ->where("CHAT_ID", '=', $chatId)
                ->where("active", '=', 1)
                ->get(['CHAR_ID']);

            $charId = $ret->get(0)->CHAR_ID;

            ConversationCache::put($chatId, "ActiveCharacterId", $charId, 30);
            return $charId;
        }

        /**
         * Lists all characters for a chat
         *
         * @param string $chatId
         * @return \Illuminate\Support\Collection
         */
        public static function listMyChars(string $chatId) {
            return DB::table("switchview")
                ->select(["CHAR_ID", "NAME"])
                ->where("CHAT_ID", '=', $chatId)
                ->get();
        }

        /**
         * Gets a switched character from
         *
         * @param string $chatId
         * @param string $charName
         * @return int
         */
        public static function getSwitchedChar(string $chatId, string $charName): int {
            Log::debug("Looking up $chatId $charName");
            if (!DB::table("switchview")
                ->where("CHAT_ID", '=', $chatId)
                ->where('NAME', 'LIKE', $charName."%")
            ->exists()) {

                throw new \InvalidArgumentException("No linked characters for this character.".print_r(DB::table("switchview")->get(), 1));
            }


            $db = DB::table("switchview")
                ->where("CHAT_ID", '=', $chatId)
                ->where('NAME', 'LIKE', $charName."%")
                ->get(['CHAR_ID']);

            return $db->get(0)->CHAR_ID;
        }
    }