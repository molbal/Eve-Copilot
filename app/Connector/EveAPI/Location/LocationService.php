<?php


    namespace App\Connector\EveAPI\Location;
    use App\Connector\EveAPI\EveAPICore;
    use App\Connector\EveAPI\Universe\ResourceLookupService;

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

            $ret = json_decode($ret);
            if (isset($ret->error)) {
            	throw new \Exception($ret->error);
			}
            $rlp = new ResourceLookupService();
            $ret->ship_type_name = $rlp->generalNameLookup($ret->ship_type_id);

            return $ret;
        }


        /**
         * Gets the current ship
         * @param int $charId
         * @return \stdClass
         * @throws \Exception
         */
        public function getCurrentLocation(int $charId): \stdClass {
            $c = $this->createGet($charId);
            curl_setopt($c, CURLOPT_URL, $this->apiRoot . "characters/$charId/location/");
            $ret = curl_exec($c);
            curl_close($c);

            $val = json_decode($ret);
            $res = new ResourceLookupService();
            $val->solar_system_name = $res->getSystemName($val->solar_system_id);
            if (isset($val->station_id))
                $val->station_name = $res->getStationName($val->station_id);
            if (isset($val->structure_id))
                $val->structure_name = $res->getStructureName($val->structure_id);

            return $val;
        }


        /**
         * Set a solar system, station or structure as autopilot waypoint
         * @param int $charId
         * @param int $destinationId
         * @throws \Exception
         */
        public function setWaypoint(int $charId, int $destinationId):void {
            $fullPath = sprintf("ui/autopilot/waypoint/?add_to_beginning=true&clear_other_waypoints=true&datasource=tranquility&destination_id=%d", $destinationId);
            $resp = $this->simplePost($charId, $fullPath, "");
            if (isset($resp->error)) {
                throw new \Exception("The EVE api returned an error: " . $resp->error);
            }
        }

    }