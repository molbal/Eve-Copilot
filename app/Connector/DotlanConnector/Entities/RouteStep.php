<?php


	namespace App\Connector\DotlanConnector\Entities;


	class RouteStep {
		public $solarSystem;
		public $securityStatus;
		public $sovereignty;
		public $kills;
		public $jumps;

        /**
         * The __toString method allows a class to decide how it will react when it is converted to a string.
         *
         * @return string
         * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
         */
        public function __toString() {
            return $this->solarSystem." (Sec status: ".$this->securityStatus.", Last 3 hours: ".$this->kills." kills, ".$this->jumps." jumps)";
        }


    }