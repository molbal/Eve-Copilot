<?php


    namespace App\Connector\EveAPI\Location;
    use App\Connector\EveAPI\EveAPICore;

    class LocationService extends EveAPICore {

        /**
         * Gets the current ship
         *
         * @param int $charId
         * @return object
         * @throws \Exception
         */
        public function getCurrentShip(int $charId) {
            $c = $this->createGet($charId);
            curl_setopt($c, CURLOPT_URL, $this->apiRoot . "characters/$charId/ship/");
            $ret = curl_exec($c);
            curl_close($c);

            return json_decode($ret);
        }


    }