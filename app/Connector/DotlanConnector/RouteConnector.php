<?php


	namespace App\Connector\DotlanConnector;


	use App\Connector\HttpScraperApiCode;
	use PHPHtmlParser\Dom;

	class RouteConnector extends HttpScraperApiCode {

		/**
		 * @param string $from
		 * @param string $to
		 * @param int    $routeType 0: fastest, 2: prefer hisec, 3: prefer lowsec
		 */
		public function checkRouteSafety(string $from, string $to, int $routeType) {
			$html = $this->getHtml(sprintf("http://evemaps.dotlan.net/route/%d:%s:%s",
			$routeType, $from, $to));

			$dom = new Dom();
			$dom->loadFromFile($html);
			$rows = $dom->find("html body div#outer div#body div#main.clearfix div#col_main div#inner div#navtools table.tablelist.table-tooltip tbody tr");

			$m = "";
			foreach ($rows as $i => $row) {
				// Skip header
				if ($i == 0) continue;

				$m .= print_r($row, 1) ;
			}

		return $m;



		}

	}