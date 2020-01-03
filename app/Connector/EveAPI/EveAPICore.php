<?php


    namespace App\Connector\EveAPI;


    use App\Connector\ESITokenController;
    use Illuminate\Support\Facades\DB;

    abstract class EveAPICore {

        /** @var string */
        protected $apiRoot;

        protected $userAgent;

        /**
         * EveAPICore constructor.
         */
        public function __construct() {
            $this->apiRoot = env("ESI_ROOT", "https://esi.evetech.net/latest/");
            $this->userAgent = env("ESI_USERAGENT", "Eve Co-Pilot (https://co-pilot.eve-nt.uk; molbal@outlook.com)");
        }

        /**
         * Creates a get CURL request with ESI authentication
         *
         * @param int $charId Character ID
         * @return false|resource
         * @throws \Exception
         */
        protected function createGet(int $charId = null) {
            $curl = curl_init();

            if ($charId) {
                $tokenController = new ESITokenController($charId);
                $accessToken = $tokenController->getAccessToken();
            }
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT =>  $this->userAgent,
                CURLOPT_HTTPHEADER => [
                    isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b',
                    'accept: application/json'
                ],

                CURLOPT_VERBOSE => true,
                CURLOPT_STDERR => fopen('./curl.log', 'a+'),

            ]);

            return $curl;
        }

        /**
         * Makes a call to the ESI with authentication
         * @param int    $charId
         * @param string $fullPath
         * @return mixed
         * @throws \Exception
         */
        protected function simpleGet(?int $charId, string $fullPath) {

            $curl = curl_init();

            if ($charId) {
                $tokenController = new ESITokenController($charId);
                $accessToken = $tokenController->getAccessToken();
            }
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT =>  $this->userAgent,
                CURLOPT_URL => $this->apiRoot.$fullPath,
                CURLOPT_HTTPHEADER => [
                    isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b',
                    'accept: application/json'
                ],

                CURLOPT_VERBOSE => true,
                CURLOPT_STDERR => fopen('./curl.log', 'a+'),

            ]);
            $ret = curl_exec($curl);
            curl_close($curl);

            return json_decode($ret);
        }

        /**
         * Creates a post CURL request with ESI authentication
         * @param int|null $charId
         * @return false|resource
         * @throws \Exception
         */
        protected function createPost(?int $charId = null) {
            $curl = curl_init();

            if ($charId) {
                $tokenController = new ESITokenController($charId);
                $accessToken = $tokenController->getAccessToken();
            }
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_USERAGENT =>  $this->userAgent,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    isset($accessToken) ? 'authorization: Bearer ' . $accessToken : 'X-a: b',
                    'accept: application/json'
                ],

                CURLOPT_VERBOSE => true,
                CURLOPT_STDERR => fopen('./curl.log', 'a+'),

            ]);

            return $curl;

        }


        /**
         * @param int    $stationId
         * @param string $stationName
         */
        protected function forevercachePut(int $stationId, string $stationName): void {
            DB::table("forevercache")->insert([
                "ID" => $stationId,
                "Name" => $stationName
            ]);
        }

        /**
         * @param int $itemId
         * @return bool
         */
        protected function forevercacheHas(int $itemId): bool {
            return DB::table("forevercache")->where("ID", "=", $itemId)->exists();
        }

        /**
         * @param int $itemId
         * @return mixed
         */
        protected function forevercacheGet(int $itemId): string {
            $results = DB::table("forevercache")->select("Name")->where("ID", "=", $itemId)->get();
//            dd($results);
            return $results->get(0)->Name;
        }
    }