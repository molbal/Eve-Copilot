<?php


    namespace App\Connector\EveAPI\Universe;


    use App\Connector\EveAPI\EveAPICore;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ResourceLookupService extends EveAPICore {

        /**
         * Gets the character name in the following order:
         *  1. Checks the registered characters table (Among the users of co-pilot)
         *  2. Checks the "Forever cache" table for known entries
         *  3. Calls the ESI for name lookup (And caches the result afterwards)
         *
         * @param int $charId
         * @return bool|mixed|string
         * @throws \Exception
         */
        public function getCharacterName(int $charId) {
             if (DB::table("characters")->where("ID", "=", $charId)->exists()) {
                 return DB::table("characters")->where("ID", "=", $charId)->get()->get(0)->NAME;
             }

            if ($this->forevercacheHas($charId)) {
                return $this->forevercacheGet($charId);
            }

            $ch = $this->createPost();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/names/");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$charId]));

            $ret = curl_exec($ch);
            curl_close($ch);

            $ret = json_decode($ret);
            if (isset($ret->error)) {
                throw new \Exception($ret->error);
            }
            else {
                $ret = $ret[0]->name;
            }
            $this->forevercachePut($charId, $ret);
            return $ret;
        }

        /**
         * Gets a station name. Makes a call to ESI unless the result is already cached.
         *
         * @param int $stationId
         * @return mixed|string
         * @throws \Exception
         */
        public function getStationName(int $stationId) {
            if ($this->forevercacheHas($stationId)) {
                return $this->forevercacheGet($stationId);
            }

            $stationName = $this->simpleGet(null, "universe/stations/{$stationId}/")->name;

            $this->forevercachePut($stationId, $stationName);
            return $stationName;

        }


        /**
         * Gets a solar system name. Makes a call to ESI unless the result is already cached.
         *
         * @param int $systemId
         * @return mixed|string
         * @throws \Exception
         */
        public function getSystemName(int $systemId) {
            if ($this->forevercacheHas($systemId)) {
                return $this->forevercacheGet($systemId);
            }

            $ch = $this->createGet();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/systems/{$systemId}/");
            $ret = curl_exec($ch);
            curl_close($ch);

            /** @var string $stationName */
            $stationName = json_decode($ret)->name;

            $this->forevercachePut($systemId, $stationName);
            return $stationName;

        }


        /**
         * Gets a structure name. Makes a call to ESI unless the result is already cached.
         *
         * @param int $structureId
         * @return mixed|string
         * @throws \Exception
         */
        public function getStructureName(int $structureId) {

            $ch = $this->createGet();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/structures/{$structureId}/");
            $ret = curl_exec($ch);
            curl_close($ch);

            /** @var string $stationName */
            $stationName = json_decode($ret)->name;

            return $stationName;
        }

    }