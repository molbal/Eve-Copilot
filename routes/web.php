<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Route;

    /**
     * Botman controller
     */
    Route::match(['get', 'post'], '/botman', 'BotManController@handle');

    /**
     * Landing site
     */
    Route::view("/", "landing")->name("home");

    /**
     * Debug view
     */
    Route::get('/botman/tinker', 'BotManController@tinker');

    /**
     * EVE Authentication routes
     */
    Route::get("/eve/auth/start", 'Auth\AuthController@redirectToProvider')->name("auth-start");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');


    /**
     * Runs database migrations
     */
    Route::get("/maintenance/db/{secret}", function ($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }
        echo "DB maintenance starts \n";
        echo Artisan::call('migrate', ['--force' => true]);
        echo "DB maintenance Over";
    });

    /**
     * Caches the cache and optimizes config and cache
     */
    Route::get("/maintenance/reset-cache/{secret}", function ($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }

        Artisan::call("config:clear");
        Artisan::call("route:clear");
    });

    /**
     * Caches the cache and optimizes config and cache
     */
    Route::get("/maintenance/enable-cache/{secret}", function ($secret) {
        if ($secret != env("MAINTENANCE_TOKEN")) {
            abort(403, "Invalid maintenance token.");
        }

        Artisan::call("config:cache");
        Artisan::call("route:cache");
        Artisan::call("optimize", ["--force" => true]);
    });

    /**
     * Token view
     */
    Route::view("/token/view", "token");