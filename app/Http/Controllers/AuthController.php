<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Repositories\Auth\AuthInterface;
use App\Http\Requests\Auth\SigninRequest;
use App\Repositories\Coverage\CoverageInterface;
use App\Http\Requests\Auth\PasswordUpdateRequest;
use App\Http\Requests\Auth\OTPVerificationRequest;
use App\Repositories\Hub\HubInterface;

class AuthController extends Controller
{

    private $repo, $hubRepo, $coverageRepo;

    public function __construct(AuthInterface $repo, HubInterface $hubRepo)
    {
        $this->repo     = $repo;
        $this->hubRepo  = $hubRepo;
        // $this->coverageRepo = $coverageRepo;
    }

    public function signin()
    {
        return view('frontend.pages.signin');
    }

    public function signinPost(SigninRequest $request)
    {
        $result =  $this->repo->signinPost($request);

        if ($result['status']) {

            if ($request->session()->has('url.intended')) {
                return redirect()->to($request->session()->pull('url.intended'));
            }

            return redirect()->route('dashboard.index')->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message'])->withInput();
    }

    public function signup()
    {
        $hubs  = $this->hubRepo->all(status: Status::ACTIVE, orderBy: 'name', sortBy: 'asc');
        return view('frontend.pages.signup', compact('hubs'));
    }

    public function emailVerificationForm()
    {
        if (session()->has('email')) {
            return view('frontend.pages.email_verification');
        }
        return redirect()->route('signin');
    }

    public function emailVerification(OTPVerificationRequest $request)
    {
        $result =  $this->repo->otpVerification($request);

        if ($result['status']) {
            if (auth()->attempt(['email' => $request->email, 'password' => session('password')])) {
                return redirect()->route('signin')->with('success', $result['message']);
            }
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function forgotPasswordForm()
    {
        return view('frontend.pages.forget_password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $result =  $this->repo->PasswordResetOTP($request);

        if ($request->expectsJson()) {
            return response()->json($result['data'], $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('password.otpVerificationForm')->with('success', $result['message']);
        }

        return redirect()->back()->with('danger', $result['message']);
    }

    public function otpVerificationForm()
    {
        if (session()->has('email')) {
            return view('frontend.pages.otp_verification');
        }
        return redirect()->route('signin');
    }

    public function otpVerification(OTPVerificationRequest $request)
    {
        $result =  $this->repo->otpVerification($request);
        // dd($result);
        if ($result['status']) {
            return redirect()->route('password.resetForm')->with('success', $result['message']);
        }

        return redirect()->back()->with('danger', $result['message']);
    }

    public function passwordResetForm()
    {
        if (session()->has('otp')) {
            return view('frontend.pages.reset_password');
        }
        return redirect()->route('signin');
    }

    public function passwordReset(PasswordUpdateRequest $request)
    {
        $result =  $this->repo->passwordReset($request);

        if ($result['status']) {
            if (auth()->attempt(['email' => session('email'), 'password' => $request->password])) {
                return redirect()->route('signin')->with('success', $result['message']);
            }
        }

        return redirect()->back()->with('danger', $result['message']);
    }

    public function demoLogin(Request $request)
    {
        $result =  $this->repo->demoLoginRepo($request);

        if ($result['status']) {
            return redirect()->route('dashboard.index')->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message'])->withInput();
    }
}
