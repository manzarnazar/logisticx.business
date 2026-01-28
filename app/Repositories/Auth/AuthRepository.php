<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Enums\Status;
use App\Mail\PasswordResetOTP;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Auth\AuthInterface;

class AuthRepository implements AuthInterface
{
    use ReturnFormatTrait;

    public function PasswordResetOTP($request)
    {
        try {

            $user       = User::where('email', $request->email)->first();
            $user->otp  = random_int(100000, 999999);
            $user->save();

            session(['email'  => $request->email]);


            setEmailConfigurations();

            $resend_otp = $request->resend_otp ?? false;

            Mail::to($user->email)->send(new PasswordResetOTP(data: $user->otp, resend_otp: $resend_otp));
            

            $message = ___('alert.password_reset_otp_mail_send_message');
            $message = str_replace("**email**",  $request->email, $message);

            session([
                'otp'               => $user->otp,
                'email'             => $request->email,
                'details_message'   => $message,
            ]);

            return $this->responseWithSuccess(___('alert.otp_mail_send'), ['status_code' => 201, 'details_message' => $message]);
        } catch (\Exception $e) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => 500,]);
        }
    }

    public function signinPost($request)
    {

        $user       = User::query()->firstWhere('email', $request->email);

        if (!$user) {
            return $this->responseWithError(___('alert.credentials_does_not_match'), []);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->responseWithError(___('alert.credentials_does_not_match'), []);
        }

        if ($user->verification_status  != Status::ACTIVE) {
            return $this->responseWithError(___('alert.verification_not_complete'), []);
        }

        if (auth()->attempt(request()->only(['email', 'password']))) {
            // Active Remember me 24 houre
            if ($request->remember != null) {
                Cookie::queue('email', $request->email, 1440);
                Cookie::queue('password', $request->password, 1440);
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
            }
            return $this->responseWithSuccess(___('alert.login_successful'), []);
        }

        return $this->responseWithError(___('alert.something_went_wrong'), []);
    }

    public function otpVerification($request)
    {
        try {

            $user     = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if ($user == null) {
                return $this->responseWithError(___('alert.invalid_otp'), []);
            }

            $user->email_verified_at    = now();
            $user->otp                  = null;
            $user->verification_status  = Status::ACTIVE;
            $user->save();

            session(['email'  => $request->email, 'otp'  => $request->otp]);
            return $this->responseWithSuccess(___('alert.verified'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function passwordReset($request)
    {
        try {
            if (session('otp') != $request->otp) {
                return $this->responseWithError(___('alert.invalid_otp'), []);
            }
            return $this->responseWithSuccess(___('alert.successfully_updated'), ['data' => session('otp')]);

            $user     = User::where('email', session('email'))->first();

            if ($user == null) {
                return $this->responseWithError(___('alert.something_went_wrong'), []);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function demoLoginRepo($request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            auth()->login($user);

            if ($request->remember) {
                Cookie::queue('email', $request->email, 1440); // Expires in 24 hours (1440 minutes)
            } else {
                Cookie::queue(Cookie::forget('email')); // Forget the email cookie if not checked
            }

            return $this->responseWithSuccess(___('alert.login_successful'), []);
        } else {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
