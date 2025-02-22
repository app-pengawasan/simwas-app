<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, $provider); 

        // login user
        if($authUser !== NULL){
            Auth()->login($authUser, true);
        }else{
            return redirect()->route('login')
                    ->with('status', 'Akun belum terdaftar atau nonaktif <br> Silakan hubungi admin')
                    ->with('alert-type', 'danger');
        }

        // setelah login redirect ke dashboard
        return redirect()->route('dashboard');
    }
    // get avatar from socialite


    public function findOrCreateUser($socialUser, $provider)
    {
        $user = User::where('email', $socialUser->getEmail())->where('status', 1)->first();

        return $user;
        // Get Social Account
        // $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
        //     ->where('provider_name', $provider)
        //     ->first();
        // // return $socialAccount->user;


        // // Jika sudah ada
        // if ($socialAccount) {
        //     // return user
        //     return $socialAccount->user;

        //     // Jika belum ada
        // } else {

        //     // User berdasarkan email
        //     $user = User::where('email', $socialUser->getEmail())->first();

        //     // Jika Tidak ada user
        //     if (!$user) {
        //         // Create user baru
        //         $user = User::create([
        //             'name'  => $socialUser->getName(),
        //             'email' => $socialUser->getEmail()
        //         ]);
        //     }

        //     // Buat Social Account baru
        //     $user->socialAccounts()->create([
        //         'provider_id'   => $socialUser->getId(),
        //         'provider_name' => $provider
        //     ]);

        //     // return user
        //     return $user;
        // }
    }
}
