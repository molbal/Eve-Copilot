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


    Route::match(['get', 'post'], '/botman', 'BotManController@handle');

    Route::view("/", "landing")->name("home");
    Route::get('/botman/tinker', 'BotManController@tinker');
    Route::get("/eve/auth/start", 'Auth\AuthController@redirectToProvider')->name("auth-start");
    Route::get("/eve/auth/callback", 'Auth\AuthController@handleProviderCallback');

    Route::get("/maintenance/db", function () {
        //echo "<pre>";
        echo "DB maintenance starts \n";
        echo Artisan::call('migrate', ['--force' => true]);
        echo "DB maintenance Over";
    });

    Route::get("/maintenance/cache", function () {

        Artisan::call("config:clear");
        Artisan::call("config:cache");

        Artisan::call("route:clear");
        Artisan::call("route:cache");

        Artisan::call("optimize", ["--force" => true]);
    });

    Route::view("/token/view", "token");