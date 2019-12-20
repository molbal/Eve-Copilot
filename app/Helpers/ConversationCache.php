<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Cache;

class ConversationCache
{


    /**
     * Gets a cache key
     * @param $id
     * @param string $key
     * @return string
     */
    public static function getKey($id, string $key): string
    {
        return implode("-", ["UID", $id, $key]);
    }

    /**
     * The get method  is used to retrieve items from the cache. If the item does not exist in the cache,
     * null will be returned. If you wish, you may pass a second argument to the get method specifying
     * the default value you wish to be returned if the item doesn't exist
     * @param $id
     * @param string $key Cache key
     * @param null $default Default value (returned if key does not exist)
     * @return mixed
     */
    public static function get($id, string $key, $default = null) {
        return Cache::get(self::getKey($id, $key), $default);
    }

    /**
     * You may use the put method to store items in the cache.
     * @param $id
     * @param string $key Cache key
     * @param string $value value to be put into cache
     * @param int $expiresInMinutes When does this cache entry expire?
     */
    public static function put($id, string $key, string $value, int $expiresInMinutes = 60) {
        Cache::put(self::getKey($id, $key), $value, $expiresInMinutes);
    }
}