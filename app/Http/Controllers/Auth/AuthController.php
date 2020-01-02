<?php


namespace App\Http\Controllers\Auth;

use App\Helpers\ConversationCache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;

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
        /** @var User $user */
        $user = Socialite::driver('eveonline')->user();


        DB::table("characters")->where("ID",'=',$user->getId())->delete();
        $controlToken = $this->getControlToken();
        DB::table("characters")->insert([
            "ID" => $user->getId(),
            "NAME" => $user->getName(),
            "REFRESH_TOKEN" => $user->refreshToken,
            "CONTROL_TOKEN" => $controlToken
        ]);
        $expiresInMinutes = floor($user->expiresIn/60);
        Cache::put("AccessToken-".$user->getId(), $user->token, $expiresInMinutes);
        Session::put("char-name", $user->getName());
        return view('token', ["name" => $user->getName(), "token" => $controlToken, "avatar" => $user->getAvatar()]);
//        dd($user);
    }

    /**
     * Gets a control token
     * @return bool|string
     */
    private function getControlToken():string {
        try {
            $tok = bin2hex(random_bytes(64));
        } catch (\Exception $e) {
            $tok = bin2hex(openssl_random_pseudo_bytes(64));
        }
        return substr($tok, 0, min(strlen($tok),  64));
    }
}