<?php

namespace App\Repositories\Auth;


interface AuthInterface
{
    public function signinPost($request);

    public function demoLoginRepo($request);

    public function PasswordResetOTP($request);

    public function otpVerification($request);

    public function passwordReset($request);
}
