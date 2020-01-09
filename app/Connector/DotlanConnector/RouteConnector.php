<?php


    namespace App\Connector\DotlanConnector;


    use App\Connector\DotlanConnector\Entities\RouteStep;
    use App\Connector\HttpScraperApiCode;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;
    use pQuery\DomNode;
    use pQuery\IQuery;

    class RouteConnector extends HttpScraperApiCode {

        /**
         * @param string $from
         * @param string $to
         * @param int    $routeType 0: fastest, 2: prefer hisec, 3: prefer lowsec
         * @return RouteStep[]|array
         */
        public function checkRouteSafety(string $from, string $to, int $routeType) {
            $cacheKey = sprintf("Dotlan-%s-%s-%d", $from, $to, $routeType);
            if (Cache::has($cacheKey)) {
                $html = Cache::get($cacheKey);
            }
            else {
                $html = $this->getHtml(sprintf("http://evemaps.dotlan.net/route/%d:%s:%s",
                    $routeType, $from, $to));
                Cache::put($cacheKey, $html, 20);
            }

           /** @var DomNode $dom */
            $dom = \pQuery::parseStr($html);

            /** @var IQuery $r */
            $r = $dom->query("#navtools > table > tr");

            /** @var RouteStep[] $jumps */
            $jumps = [];
            for($i=1; $i<$r->count(); $i++) {
                /** @var DomNode $node */
                $node = $r[$i];
                /** @var DomNode[] $cells */
                $cells = $node->query("td");
                $step = new RouteStep();
                $step->solarSystem = $cells[2]->text();
                $step->securityStatus = $cells[3]->text();
                $step->sovereignty = $cells[4]->text();
                $step->kills = $cells[5]->text();
                $step->jumps = $cells[6]->text();

                $jumps[] = $step;
            }

            return $jumps;


        }

    }