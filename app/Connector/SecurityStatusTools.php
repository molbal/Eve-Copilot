<?php


    namespace App\Connector;


    class SecurityStatusTools {

        /**
         * Returns false if faction police will shoot you in that system
         * @param float $secStatus Char sec status
         * @param float $systemSecStatus System sec status
         * @return bool
         */
        public static function isItSafe(float $secStatus, float $systemSecStatus): bool {
            if ($secStatus >= -2.0) {
                return true;
            }
            else if ($secStatus >= -2.5) {
                return $systemSecStatus >= 0.9;
            }
            else if ($secStatus >= -3.0) {
                return $systemSecStatus >= 0.8;
            }
            else if ($secStatus >= -3.5) {
                return $systemSecStatus >= 0.7;
            }
            else if ($secStatus >= 4.0) {
                return $systemSecStatus >= 0.6;
            }
            else if ($secStatus >= -4.5) {
                return $systemSecStatus >= 0.5;
            }

        }
    }