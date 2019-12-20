<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Eve Online authentication page.
     *
     * @return Response
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
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('eveonline')->user();

        dd($user);
    }
}