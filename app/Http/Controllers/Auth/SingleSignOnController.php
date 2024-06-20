<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JKD\SSO\Client\Provider\Keycloak as KeycloakProviderSSO;
use App\Providers\SingleSignOnProvider;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\CashFlow\Single;

class SingleSignOnController extends Controller
{

    protected $SingleSignOnProvider;

    public function __construct(KeycloakProviderSSO $keycloak)
    {
        // new instance of KeycloakProviderSSO
        $this->SingleSignOnProvider = $keycloak;
    }


    public function redirectToSingleSignOn()
    {
        // new instance of KeycloakProviderSSO
        $response = $this->SingleSignOnProvider->getAuthorizationUrl();
        // set session
        session(['oauth2state' => $this->SingleSignOnProvider->getState()]);

        return redirect($response);
    }

    public function handleSingleSignOnCallback()
    {
        // check if the state is valid
        if (empty($_GET['state']) || $_GET['state'] !== session('oauth2state')) {
            session()->forget('oauth2state');
            exit('Invalid state');
        }

        try {
            //code...
            $token = $this->SingleSignOnProvider->getAccessToken('authorization_code', [
                'code' => $_GET['code'],
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        // get user info
        $user = $this->SingleSignOnProvider->getResourceOwner($token);
        // save session
        // dd($user->toArray());
        session(['user' => $user->toArray()['nip']]);

    }

    public function logout()
    {
        $url_logout = $this->SingleSignOnProvider->getLogoutUrl();
        return redirect('/');
    }

    public function getUserInfo()
    {
        // dd(session('oauth2state'));
        try {
            //code...
            $token = $this->SingleSignOnProvider->getAccessToken('authorization_code', [
                'code' => $_GET['code'],
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }

        // get user info
        $user = $this->SingleSignOnProvider->getResourceOwner($token);
        // habis ini di redirect ke halaman dashboard
        dd($user->toArray());
    }
}
