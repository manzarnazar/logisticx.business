<?php

namespace App\Repositories\Merchant;

use App\Enums\ImageSize;
use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Hub;
use Illuminate\Support\Str;
use App\Models\MerchantShops;
use App\Models\Backend\Upload;
use App\Models\Backend\Merchant;
use App\Http\Services\SmsService;
use App\Mail\MerchantRegistration;
use App\Mail\MerchantSignup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Backend\Role;
use App\Models\MerchantPayment;
use App\Repositories\Upload\UploadInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Traits\ReturnFormatTrait;

class MerchantRepository implements MerchantInterface
{
    use ReturnFormatTrait;

    private $model;
    private $upload;

    public function __construct(Merchant $model, UploadInterface $upload)
    {
        $this->model  = $model;
        $this->upload = $upload;
    }

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query = $this->model::query();

        $query->with('user', 'user.upload');

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return  $query->paginate($paginate);
        }

        return $query->get();
    }

    public function merchantIdList()
    {
        return $this->model::orderByDesc('id')->select('id', 'business_name')->get();
    }


    public function all_hubs()
    {
        return Hub::all();
    }

    public function active_hubs()
    {
        return  Hub::where('status', Status::ACTIVE)->get();
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }


    //merchant shop get
    public function merchant_shops_get($id)
    {
        return MerchantShops::where('merchant_id', $id)->get();
    }

    //Store merchant data
    public function store($request)
    {
        try {
            DB::beginTransaction();

            $user                           = new User();
            $user->name                     = $request->name;
            $user->mobile                   = $request->mobile;
            $user->email                    = $request->email;
            $user->password                 = Hash::make($request->password);
            $user->address                  = $request->address;
            $user->hub_id                   = $request->hub;
            $user->status                   = $request->status;
            $user->user_type                = UserType::MERCHANT;
            $user->image_id                 = $this->upload->uploadImage($request->image, 'merchant/', [ImageSize::MERCHANT_IMAGE_ONE, ImageSize::MERCHANT_IMAGE_TWO], null);
            $user->nid_number               = $request->input('nid_number');
            $user->joining_date             = $request->input('joining_date', date('Y-m-d'));
            $user->status                   = $request->status;

            $role                           = Role::where('slug', 'merchant')->first();
            if ($role && $role->permissions != null) {
                $user->permissions          = $role->permissions;
            }

            $user->save();

            $merchant                       = $this->model;
            $merchant->user_id              = $user->id;
            $merchant->business_name        = $request->business_name;
            $merchant->merchant_unique_id   = $this->generateUniqueID();
            $merchant->address              = $request->address;
            $merchant->coverage_id          = Hub::find($user->hub_id)->coverage_id;
            $merchant->pickup_slot_id       = $request->input('pickup_slot');
            $merchant->nid_id               = $this->upload->uploadImage($request->nid, 'nid/', [], null);
            $merchant->trade_license        = $this->upload->uploadImage($request->trade_license, 'trade_license/', [], null);
            $merchant->reference_name       = $request->reference_name;
            $merchant->reference_phone      = $request->reference_phone;
            $merchant->save();

            $shop                           = new MerchantShops();
            $shop->merchant_id              = $merchant->id;
            $shop->name                     = $merchant->business_name;
            $shop->contact_no               = $request->mobile;
            $shop->address                  = $request->address;
            $shop->hub_id                   = $user->hub_id;
            $shop->coverage_id              = $merchant->coverage_id;
            $shop->status                   = $request->status;
            $shop->default_shop             = Status::ACTIVE;
            $shop->save();

            $paymentAccount                 = new MerchantPayment();
            $paymentAccount->merchant_id    = $merchant->id;
            $paymentAccount->payment_method = config('merchantpayment.payment_method.cash');
            $paymentAccount->save();

            DB::commit();

            if ($user && $merchant) :
                $data = [
                    'merchant'      => $merchant,
                    'merchant_user' => $user
                ];

                if (settings('mail_driver') == 'sendmail') :
                    \config([
                        'mail.mailers.sendmail.path' => settings('sendmail_path'),
                    ]);
                endif;

                \config([
                    'mail.default'                 => settings('mail_driver'),
                    'mail.mailers.smtp.host'       => settings('mail_host'),
                    'mail.mailers.smtp.port'       => settings('mail_port'),
                    'mail.mailers.smtp.encryption' => settings('mail_encryption'),
                    'mail.mailers.smtp.username'   => settings('mail_username'),
                    'mail.mailers.smtp.password'   => decrypt(settings('mail_password')),
                    'mail.from.address'            => settings('mail_address'),
                    'mail.from.name'               => settings('mail_name')
                ]);

                Mail::to($user->email)->send(new MerchantSignup($data));
            endif;

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    //update merchant data
    public function update($request)
    {
        try {

            DB::beginTransaction();

            $merchant                   = Merchant::find($request->id);

            $user                       = User::find($merchant->user_id);
            $user->name                 = $request->name;
            $user->mobile               = $request->mobile;
            $user->email                = $request->email;

            if ($request->password != null) {
                $user->password         = Hash::make($request->password);
            }

            $user->address              = $request->address;
            $user->user_type            = UserType::MERCHANT;
            $user->hub_id               = $request->hub;
            $user->status               = $request->status;
            $user->image_id             = $this->upload->uploadImage($request->image, 'merchant/', [ImageSize::MERCHANT_IMAGE_ONE, ImageSize::MERCHANT_IMAGE_TWO], $user->image_id);
            $user->save();

            // Merchant row
            $merchant->business_name    = $request->business_name;
            $merchant->address          = $request->address;
            $merchant->coverage_id      = Hub::find($user->hub_id)->coverage_id;
            $merchant->pickup_slot_id   = $request->input('pickup_slot');
            $merchant->nid_id           = $this->upload->uploadImage($request->nid, 'nid/', [], $merchant->nid_id);
            $merchant->trade_license    = $this->upload->uploadImage($request->trade_license, 'trade_license/', [], $merchant->trade_license);

            if ($request->reference_name) :
                $merchant->reference_name   = $request->reference_name;
            endif;

            if ($request->reference_phone) :
                $merchant->reference_phone  = $request->reference_phone;
            endif;

            $merchant->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    //Sign up store merchant data
    public function signUpStore($request)
    {
        try {

            DB::beginTransaction();

            $user                           = new User();
            $user->name                     = $request->full_name;
            $user->mobile                   = $request->mobile;
            $user->email                    = $request->email;
            $user->password                 = Hash::make($request->password);
            $user->user_type                = UserType::MERCHANT;
            $user->address                  = $request->address;
            $user->verification_status      = Status::ACTIVE;
            $user->email_verified_at        = now();
            $user->otp                      = null;
            $user->hub_id                   = $request->input('hub');

            $user->permissions              = [];
            $role                           = Role::where('slug', 'merchant')->first();
            if ($role && $role->permissions != null) {
                $user->permissions          = $role->permissions;
            }

            $user->save();

            $merchant                       = new Merchant();
            $merchant->user_id              = $user->id;
            $merchant->business_name        = $request->business_name;
            $merchant->merchant_unique_id   = $this->generateUniqueID();
            $merchant->address              = $user->address;
            $merchant->coverage_id          = Hub::find($user->hub_id)->coverage_id;
            $merchant->pickup_slot_id       = $request->input('pickup_slot');
            $merchant->save();

            $shop                           = new MerchantShops();
            $shop->merchant_id              = $merchant->id;
            $shop->name                     = $merchant->business_name;
            $shop->contact_no               = $request->mobile;
            $shop->address                  = $merchant->address;
            $shop->hub_id                   = $user->hub_id;
            $shop->coverage_id              = $merchant->coverage_id;
            $shop->status                   = $request->status ? $request->status : Status::ACTIVE;
            $shop->default_shop             = true;
            $shop->save();

            DB::commit();

            $message = ___('alert.successfully_added');

            $data = [
                'status_code'       => 201,
                'details_message'   => $message,
                'user'              => $user,
            ];

            return $this->responseWithSuccess($message, $data, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'),  ['status_code' => 500]);
        }
    }

    // Resend OTP
    public function resendOTP($request)
    {
        try {
            $otp                    = 123456;
            // $otp                    = random_int(100000, 999999);
            $merchantUser           = User::where('email', $request->email)->first();
            $merchantUser->otp      = $otp;
            $merchantUser->save();

            $response =  app(SmsService::class)->sendOtp($merchantUser->mobile, $merchantUser->otp);

            // setEmailConfigurations();

            // Mail::to($merchantUser->email)->send(new MerchantRegistration(data: $merchantUser,  resend_otp: true));

            $message = ___('alert.resend_otp_mail_send_message');
            $message = str_replace("**email**",  $request->email, $message);

            session([
                'otp'               => $merchantUser->otp,
                'email'             => $request->email,
                'details_message'   => $message
            ]);

            return $this->responseWithSuccess(___('alert.otp_mail_send'), ['status_code' => 201, 'details_message' => $message]);
        } catch (\Exception $e) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => 500]);
        }
    }

    // OTP verification
    public function emailVerification($request)
    {
        try {
            $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

            if (is_null($user)) {
                return $this->responseWithError(___('alert.invalid_otp'));
            }

            $user->email_verified_at    = now();
            $user->otp                  = null;
            $user->verification_status = Status::ACTIVE;
            $user->save();

            return $this->responseWithSuccess(___('alert.verification_successful'));
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    // OTP verification
    public function otpVerification($request)
    {
        try {

            $merchantUser     = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
            if ($merchantUser != null) {
                $merchantUser->verification_status = Status::ACTIVE;
                $merchantUser->save();
                return $merchantUser;
            } else
                return 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    // for unique id generate
    public function generateUniqueID()
    {
        do {
            $merchant_unique_id = random_int(100000, 999999);
        } while (Merchant::where("merchant_unique_id", "=", $merchant_unique_id)->first());

        return $merchant_unique_id;
    }

    public function delete($id)
    {
        try {
            $merchant = $this->model::find($id);
            $user     = User::find($merchant->user_id);

            $this->upload->deleteImage($user->image_id, 'delete');
            $this->upload->deleteImage($user->merchant->nid_id, 'delete');
            $this->upload->deleteImage($user->merchant->trade_license, 'delete');

            $user->delete();
            $merchant->delete();

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    //social login merchant signup

    public function socialSignupStore($request, $social)
    {
        try {
            DB::beginTransaction();

            $user                       = new User();
            $user->name                 = $request->name;
            $user->email                = $request->email;

            if ($social == 'google') :
                $user->google_id        = $request->id;
            elseif ($social == 'facebook') :
                $user->facebook_id      = $request->id;
            endif;

            $user->image_id             = $this->linkToAvatarUpload($request, $request->avatar_original);

            $user->password             = Hash::make(Str::random(32));
            $user->user_type            = UserType::MERCHANT;
            $user->hub_id               = 1;
            $user->role_id              = null;

            $role                           = Role::where('slug', 'merchant')->first();
            if ($role && $role->permissions != null) {
                $user->permissions          = $role->permissions;
            }

            $user->save();

            $merchant                           = new Merchant();
            $merchant->user_id                  = $user->id;
            $merchant->business_name            = $request->name;
            $merchant->merchant_unique_id       = $this->generateUniqueID();
            $merchant->coverage_id              = Hub::find($user->hub_id)->coverage_id;
            $merchant->save();

            $shop                               = new MerchantShops();
            $shop->merchant_id                  = $merchant->id;
            $shop->name                         = $merchant->business_name;
            $shop->hub_id                       = $user->hub_id;
            $shop->coverage_id                  = $merchant->coverage_id;
            $shop->default_shop                 = Status::ACTIVE;
            $shop->save();

            DB::commit();
            return $user;
        } catch (\Exception $e) {

            DB::rollBack();
            return false;
        }
    }

    protected function linkToAvatarUpload($user = null, $avatar_original)
    {
        try {
            //profile upload
            $file             = file_get_contents($avatar_original);
            $file_name        = date('YmdHisA') . $user->id . '.jpg';
            if (!File::isDirectory(public_path('uploads/profile'))) :
                File::makeDirectory(public_path('uploads/profile'));
            endif;
            File::put(public_path('uploads/profile/') . $file_name, $file);
            $file_full_path   = 'uploads/profile/' . $file_name;
            $upload           = new Upload();
            $upload->original = $file_full_path;
            $upload->save();
            return $upload->id;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
