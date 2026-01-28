<?php

namespace App\Repositories\Profile;

use App\Enums\ImageSize;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Profile\ProfileInterface;
use App\Repositories\Upload\UploadInterface;
use App\Traits\ReturnFormatTrait;

class ProfileRepository implements ProfileInterface
{
    use ReturnFormatTrait;

    private $model, $upload;

    public function __construct(User $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function get($id)
    {
        return User::with('upload')->find($id);
    }

    public function update($request)
    {
        try {
            $user                   = $this->model::find(auth()->user()->id);
            $user->name             = $request->name;
            $user->email            = $request->email;
            $user->mobile           = $request->mobile;
            $user->address          = $request->address;
            $user->image_id         = $this->upload->uploadImage($request->image, 'users/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_100x100], $user->image_id);
            $user->save();
            return $this->responseWithSuccess(___('alert.successfully_updated'), ['user' => $user]);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function passwordUpdate($request)
    {
        try {
            $user   = $this->model::find(auth()->user()->id);
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return $this->responseWithSuccess(___('alert.password_updated'), ['status_code' => 200]);
            }
            return $this->responseWithError(___('alert.old_password_not_match'), ['status_code' => 400]); // 400 for bad request
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => 500]);
        }
    }
}
