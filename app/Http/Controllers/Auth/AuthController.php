<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    /**
     * Redirect the user to the Eve Online authentication page.
     *
     * @return mixed
     */
    public function redirectToProvider()
    {
        return Socialite::driver('eveonline')
            ->setScopes(explode(' ', env('EVEONLINE_CLIENT_SCOPES')))
            ->redirect();
    }

    /**
     * Obtain the user information from Eve Online.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('eveonline')->user();

        // TODO: Save to table, cache access key, show view
        return view('welcome');
//        dd($user);
    }
}