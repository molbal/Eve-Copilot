<?php


    namespace App\Connector\EveAPI;


    use App\Connector\ESITokenController;

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
         * @param int $charId Character ID
         * @return false|resource
         * @throws \Exception
         */
        protected function createGet(int $charId) {
            $curl = curl_init();

            $tokenController = new ESITokenController($charId);
            $accessToken = $tokenController->getAccessToken();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://testcURL.com/?item1=value&item2=value2',
                CURLOPT_USERAGENT =>  $this->userAgent,
                CURLOPT_HTTPHEADER => [
                    'authorization: Bearer ' . $accessToken,
                    'accept: application/json'
                ],
                /**
                 * Specify debug option.
                 */
                CURLOPT_VERBOSE => true,

                /**
                 * Specify log file.
                 * Make sure that the folder is writable.
                 */
                CURLOPT_STDERR => fopen('./curl.log', 'w+'),
            ]);

            return $curl;
        }

    }