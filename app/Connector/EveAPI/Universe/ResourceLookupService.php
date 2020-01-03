<?php


    namespace App\Connector\EveAPI\Universe;


    use App\Connector\EveAPI\EveAPICore;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ResourceLookupService extends EveAPICore {

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
            //$this->forevercachePut($charId, $ret);
            return $ret;
        }

        /**
         * @param mixed $userAgent
         * @return mixed|string
         * @throws \Exception
         */
        public function getStationName(int $stationId) {
            if ($this->forevercacheHas($stationId)) {
                return $this->forevercacheGet($stationId);
            }

            $ch = $this->createGet();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/stations/{$stationId}/");
            $ret = curl_exec($ch);
            curl_close($ch);

            /** @var string $stationName */
            $stationName = json_decode($ret)->name;

            $this->forevercachePut($stationId, $stationName);
            return $stationName;

        }


        /**
         * @param mixed $userAgent
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
         * @param mixed $userAgent
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