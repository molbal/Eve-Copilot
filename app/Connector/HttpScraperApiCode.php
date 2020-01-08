<?php


	namespace App\Connector;


	abstract class HttpScraperApiCode {

		/** @var string */
		protected $userAgent;

		/**
		 * HttpScraperApiCode constructor.
		 */
		public function __construct() {
			$this->userAgent = env("ESI_USERAGENT", "Eve Co-Pilot (https://co-pilot.eve-nt.uk; molbal@outlook.com)");
		}


		/**
		 * @param string $url
		 *
		 * @return string
		 */
		protected function getHtml(string $url):string {
			$ch = curl_init();

			curl_setopt_array($ch, [
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $url,
				CURLOPT_USERAGENT  => $this->userAgent
			]);

			$ret = curl_exec($ch);

			curl_close($ch);

			return $ret;
		}
	}