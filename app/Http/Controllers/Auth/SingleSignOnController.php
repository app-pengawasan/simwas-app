<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\SingleSignOnProvider;
use JKD\SSO\Client\Provider\Keycloak as KeycloakProviderSSO;
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

    public function handleSingleSignOnCallback(Request $request)
    {
        // check if the state is valid
        if (empty($_GET['state']) || $_GET['state'] !== session('oauth2state')) {
            Auth::logout();
        // remove cache so that the user cannot go back to the previous page
        // and logout again
        $request->session()->flush();


        session()->forget('oauth2state');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'))->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);


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
        $pegawai = $this->SingleSignOnProvider->getResourceOwner($token);
        // save session
        // dd($user->toArray());
        session(['user' => $pegawai->toArray()['nip']]);
        // dd($pegawai->toArray()['nip']);
        $user = User::where('nip', $pegawai->toArray()['nip'])->first();
        if ($user) {
            auth()->login($user);
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')
                ->with('status', 'Akun belum terdaftar, silahkan hubungi admin')
                ->with('alert-type', 'danger');
        }
    }

    public function logout(Request $request)
    {
        $url_logout = $this->SingleSignOnProvider->getLogoutUrl();
        // dd($url_logout);
        return redirect($url_logout);



        Auth::logout();
        // remove cache so that the user cannot go back to the previous page
        // and logout again
        $request->session()->flush();


        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'))->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
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
