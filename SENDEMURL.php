<?php

    namespace SENDEM;

    /**
     * URL class
     * @author SENDEM DEV TEAM
     * @license TESTLICENCE 1.0 (:D)
     */

    class URL
    {
        private static $ch;

        /**
         * Initialization method
         * @param string | request type
         * @param string | target path
         * @param array  | request datas for post
         * @return void
         */
        private static function init($type, $route, $datas=[], $params=[])
        {
            // parse datas
            $stringed = self::parseData( preg_match("#application/json#", ($params['headers']['Content-Type'] ?? '')) ? 'json' : '', $datas );

            // exit($stringed);

            // start curl actions
            self::$ch = curl_init();

            curl_setopt(self::$ch, CURLOPT_URL, $route . ($type=='get' && strlen(trim($stringed)) ? '?' . $stringed : ''));
            curl_setopt(self::$ch, CURLOPT_RETURNTRANSFER, 1);

            // for post request
            if (strtolower($type) == 'post')
            {
                curl_setopt(self::$ch, CURLOPT_POST, 1);
                curl_setopt(self::$ch, CURLOPT_POSTFIELDS, $stringed);
            }

            // apply params
            if (isset($params['headers']))
            {
                $headers = [];

                foreach ($params['headers'] as $k => $val)
                {
                    $headers[] = "$k: $val";
                }

                curl_setopt(self::$ch, CURLOPT_HTTPHEADER, $headers);
            }
        }

        /**
         * Execute the request
         * @return string | http answer
         */
        private static function execute()
        {
            $response = curl_exec(self::$ch);
                        curl_close(self::$ch);

            return $response;
        }

        /**
         * Post method to send POST datas
         * @param string  | target path
         * @param array   | datas to send
         * @return string | http response
         */
        public function post($route, $datas, $params=[])
        {
            self::init('post', $route, $datas, $params);
            return self::execute();
        }

        /**
         * Get method to send GET datas
         * @param string  | target path
         * @param array   | datas to send
         * @return string | http response
         */
        public function get($route, $datas=[], $params=[])
        {
            self::init('get', $route, $datas, $params);
            return self::execute();
        }

        /**
         * Get method to send GET datas
         * @param string  | target path
         * @param array   | datas to send
         * @return string | http response
         */
        public function do($type, $route, $datas=[], $params=[])
        {
            self::init($type, $route, $datas, $params);
            return self::execute();
        }

        /**
         * parses datas
         * @param array  | datas
         * @return string | datas to be sent
         */
        private static function parseData($type='', $datas=[])
        {
            $values = [];

            switch ($type) {
                case 'json':
                    $values = json_encode($datas);
                    break;

                default:
                    $values = http_build_query($datas);
                    break;
            }

            return $values;
        }
    }
