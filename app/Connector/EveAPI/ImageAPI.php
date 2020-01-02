<?php


    namespace App\Connector\EveAPI;


    class ImageAPI {


        /**
         * Returns a portrait link
         * @param int $charId
         * @param int $size
         * @return string
         */
        public static function getCharacterPortrait(int $charId, int $size = 512): string {
            return "https://images.evetech.net/characters/$charId/portrait?size=$size";
        }

        /**
         * Gets a rendered link
         * @param int $itemId
         * @param int $size
         * @return string
         */
        public static function getRenderLink(int $itemId, int $size = 256): string {
            return "https://images.evetech.net/types/$itemId/render?size=$size";
        }

        /**
         * Gets an item image
         * @param int $itemId
         * @param int $size
         * @return string
         */
        public static function getItemImage(int $itemId, int $size = 32): string {
            return "https://images.evetech.net/types/$itemId/render?size=$size";
        }
    }