<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Auth\AuthInterface;
use App\Http\Requests\Auth\SigninRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\HeroProfileResource;
use App\Http\Requests\Merchant\SignUpRequest;
use App\Repositories\Profile\ProfileInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Http\Requests\Auth\OTPVerificationRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Http\Requests\profile\PasswordUpdateRequest;
use App\Http\Resources\Merchant\MerchantProfileResource;

class AuthController extends Controller
{
    use ApiReturnFormatTrait;

    protected $repo, $profileRepo, $merchantRepo;

    public function __construct(AuthInterface $repo, ProfileInterface $profileRepo, MerchantInterface $merchantRepo)
    {
        $this->repo         = $repo;
        $this->profileRepo  = $profileRepo;
        $this->merchantRepo = $merchantRepo;
    }

    public function login(SigninRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $user        = User::where('email', $request->email)->first();
            $token       = Auth::guard('api')->attempt($credentials);

            if (!$token) {
                return $this->responseWithError(___('alert.invalid_credentials'), []);
            }

            if ($user->user_type != UserType::DELIVERYMAN) {
                Auth::logout(); // Log out the user if not a deliveryman
                return $this->responseWithError(___('alert.unauthorized'), []);
            }

            $data = [
                'token_type'    => 'Bearer',
                'access_token'  => $token,
                'user'          => new HeroProfileResource($user),
            ];

            return $this->responseWithSuccess(___('alert.login_successfully'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function profile()
    {
        $user = User::where('id', auth()->id())->first();

        $data = new HeroProfileResource($user);

        return $this->responseWithSuccess("", $data);
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $result = $this->profileRepo->update($request);

        if ($result['status']) {

            $data = new HeroProfileResource($result['data']['user']);

            return $this->responseWithSuccess($result['message'], $data);
        }

        return $this->responseWithError($result['message'], []);
    }

    public function forgotPassword(Request $request)
    {
        $data = Validator::make($request->all(), ['email' => 'required|email|exists:users,email']);

        if ($data->fails()) {
            return $this->responseWithError(___('alert.validation_error'), $data->errors(), 422);
        }

        $result =  $this->repo->PasswordResetOTP($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }

        return $this->responseWithError($result['message'], []);
    }

    public function resetPassword(Request $request)
    {
        try {
            $data = Validator::make($request->all(), [
                'email'             => 'required|email|exists:users,email',
                'otp'               => 'required|min:6',
                'password'          => 'required|min:6|max:32',
                'confirm_password'  => 'required_with:password|same:password|min:6|max:32',
            ]);

            if ($data->fails()) {
                return $this->responseWithError(___('alert.validation_error'), $data->errors(), 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->responseWithError(___('alert.user_not_found'), []);
            }

            if ($user->otp != $request->otp) {
                return $this->responseWithError(___('alert.otp_is_invalid'), []);
            }

            $user->password = Hash::make($request->password);
            $user->otp = null;
            $user->save();

            return $this->responseWithSuccess(___('alert.password_has_been_updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $result = $this->profileRepo->passwordUpdate($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message'], []);
        }

        return $this->responseWithError($result['message'], []);
    }

    public function logout()
    {
        try {
            Auth::logout();
            return $this->responseWithSuccess(___('alert.you_have_successfully_logged_out'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function merchantLogin(SignInRequest $request)
    {
        try {

            $credentials = $request->only('email', 'password'); // Only returns the email, password from all the requests
            $user        = User::where('email', $request->email)->first(); // Getting the user information
            $token       = Auth::guard('api')->attempt($credentials); // JWT , Config->auth 

            if (!$token) {
                return $this->responseWithError(___('alert.invalid_credentials'), ['status_code' => 401]);
            }

            if ($user->user_type != UserType::MERCHANT || $user->email_verified_at == null) {
                Auth::logout();
                return $this->responseWithError(___('alert.unauthorized'), ['status_code' => 400]); // Bad request
            }

            $data = [
                'token_type'    => 'Bearer',
                'access_token'  => $token,
                'user'          => new MerchantProfileResource($user)
            ];

            return $this->responseWithSuccess(___('alert.login_successfully'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function merchantSignUpStore(SignUpRequest $request)
    {
        try {
            $result = $this->merchantRepo->signUpStore($request);

            // if ($result['status']) {
            //     $data =  new MerchantProfileResource($result['data']['user']);
            //     return $this->responseWithSuccess($result['message'], $data);
            // }

            return $this->responseWithSuccess($result['message']);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function merchantEmailVerification(OTPVerificationRequest $request)
    {

        $result =  $this->merchantRepo->emailVerification($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }

        return $this->responseWithError(___('alert.something_went_wrong'));


    }

    public function updateMerchantProfile(ProfileUpdateRequest $request)
    {
        $result = $this->profileRepo->update($request);

        if ($result['status']) {

            $data = new MerchantProfileResource($result['data']['user']);

            return $this->responseWithSuccess($result['message'], $data);
        }

        return $this->responseWithError($result['message'], []);
    }
}
