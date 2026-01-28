<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\SocialLoginSettings\SocialLoginSettingsInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    protected $merchantRepo;
    protected $repo;

    public function __construct(MerchantInterface $merchantRepo, SocialLoginSettingsInterface $repo)
    {
        $this->merchantRepo = $merchantRepo;
        $this->repo         = $repo;
    }
    public function socialRedirect($social)
    {

        if ($social == 'google') :
            if (settings('google_status') != Status::ACTIVE) :
                toast('Google login is not enabled.', 'error');
                return redirect()->back();
            endif;
            \Config([
                'services.google.client_id'        => settings('google_client_id'),
                'services.google.client_secret'    => settings('google_client_secret'),
                'services.google.redirect'         => url('google/login')
            ]);

            return Socialite::driver('google')->redirect();

        elseif ($social == 'facebook') :

            if (settings('facebook_status') != Status::ACTIVE) :
                toast('Facebook login is not enabled.', 'error');
                return redirect()->back();
            endif;
            \Config([
                'services.facebook.client_id'        => settings('facebook_client_id'),
                'services.facebook.client_secret'    => settings('facebook_client_secret'),
                'services.facebook.redirect'         => url('facebook/login')
            ]);

            return Socialite::driver('facebook')->redirect();
        endif;

        toast(___('alert.something_went_wrong'), 'error');
        return redirect()->back();
    }
    public function authGoogleLogin(Request $request)
    {
        try {

            \Config([
                'services.google.client_id'        => settings('google_client_id'),
                'services.google.client_secret'    => settings('google_client_secret'),
                'services.google.redirect'         => url('google/login')
            ]);

            $user      = Socialite::driver('google')->user();
            $existUser = User::where('google_id', $user->id)->first();
            if ($existUser) :
                Auth::login($existUser);
                return redirect('/');
            else :
                $merchantUser = $this->merchantRepo->socialSignupStore($user, 'google');
                if ($merchantUser) :
                    Auth::login($merchantUser);
                    return redirect('/');
                else :
                    toast(___('alert.something_went_wrong'), 'error');
                    return redirect()->back();
                endif;
            endif;
        } catch (\Throwable $th) {
            toast(___('alert.something_went_wrong'), 'error');
            return redirect()->back();
        }
    }
    public function authFacebookLogin()
    {
        try {

            \Config([
                'services.facebook.client_id'        => settings('facebook_client_id'),
                'services.facebook.client_secret'    => settings('facebook_client_secret'),
                'services.facebook.redirect'         => url('facebook/login')
            ]);
            $user        = Socialite::driver('facebook')->user();

            $existUser   = User::where('facebook_id', $user->id)->first();
            if ($existUser) :
                Auth::login($existUser);
                return redirect('/');
            else :
                $merchantUser = $this->merchantRepo->socialSignupStore($user, 'facebook');
                if ($merchantUser) :
                    Auth::login($merchantUser);
                    return redirect('/');
                else :
                    toast(___('alert.something_went_wrong'), 'error');
                    return redirect()->back();
                endif;
            endif;
        } catch (\Throwable $th) {

            toast(___('alert.something_went_wrong'), 'error');
            return redirect()->back();
        }
    }

    public function socialLoginSettingsIndex()
    {
        return view('backend.setting.social_login_settings.index');
    }

    public function socialLoginSettingsUpdate(Request $request, $social)
    { 
        $result = $this->repo->update($request, $social);
        if ($result['status']) {
            return redirect()->route('social.login.settings.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
