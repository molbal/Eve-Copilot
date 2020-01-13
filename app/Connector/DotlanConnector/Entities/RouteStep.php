<?php


	namespace App\Connector\DotlanConnector\Entities;


	class RouteStep {
		/** @var string */
		public $solarSystem;
		/** @var float */
		public $securityStatus;
		/** @var string */
		public $sovereignty;
		/** @var int */
		public $kills;
		/** @var int */
		public $jumps;

		/**
		 * RouteStep constructor.
		 */
		public function __construct($solarSystem = "", $securityStatus = 0)
		{
			$this->securityStatus = $securityStatus;
			$this->solarSystem = $solarSystem;
		}


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