<?php


    namespace App\Connector;


    use Exception;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ESITokenController {

        /** @var int EVE Character ID */
        private $charId;

        /**
         * ESITokenController constructor.
         *
         * @param int $charId
         */
        public function __construct(int $charId) {
            $this->charId = $charId;
        }


        /**
         * Gets a usable, not expired access token
         * @return string Access token
         * @throws Exception
         */
        public function getAccessToken():string {
            $token = Cache::get("AccessToken-".$this->charId);
            if ($token) return $token;

            return $this->getAndCacheNewAccessToken();
        }

        /**
         * Gets a new, refreshed access token and places it in the cache + returns it.
         * @throws Exception
         */
        public function getAndCacheNewAccessToken(): string {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://login.eveonline.com/oauth/token");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'grant_type' => "refresh_token",
                'refresh_token' => $this->getRefreshToken()
            ]));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $esiResponse = curl_exec($ch);
            Log::debug("Received message for new access token request (CharID: ".$this->charId."): ". $esiResponse);
            /**
             {
                "access_token":"MXP...tg2",
                "token_type":"Bearer",
                "expires_in":1200,
                "refresh_token":"gEy...fM0"
            }
            */
            curl_close($ch);

            /** @var array $esiResponseDecoded */
            $esiResponseDecoded = json_decode($esiResponse, true);
            /** @var int $expiresInMinutes */
            $expiresInMinutes = floor($esiResponseDecoded["expires_in"]/60);
            /** @var string $newAccessToken */
            $newAccessToken = $esiResponseDecoded["access_token"];

            Log::info("Stored new access token ($newAccessToken) for $expiresInMinutes minutes in cache.");
            Cache::put("AccessToken-".$this->charId, $newAccessToken, $expiresInMinutes);

            return $newAccessToken;
        }


        /**
         * Gets the stored refresh token from the database
         * @return string Refresh token
         * @throws Exception Throws exception if the character ID has no refresh token stored
         */
        public function getRefreshToken() {
            /** @var string $refreshToken */
            $refreshToken = DB::table('characters')
                ->select('REFRESH_TOKEN')
                ->where('ID', '=', $this->charId)
                ->first()->REFRESH_TOKEN;

            if (!$refreshToken) {
                throw new Exception("The user ID " . $this->charId. " has no refresh token stored");
            }

            return $refreshToken;
        }

    }