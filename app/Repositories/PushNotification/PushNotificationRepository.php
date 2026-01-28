<?php

namespace App\Repositories\PushNotification;

use App\Http\Services\PushNotificationService;
use App\Models\Backend\PushNotification;
use App\Models\Backend\Upload;
use App\Traits\ReturnFormatTrait;
use App\Repositories\PushNotification\PushNotificationInterface;
use Illuminate\Support\Facades\Auth;

class PushNotificationRepository implements PushNotificationInterface
{

    use ReturnFormatTrait;
    private $model;

    public function __construct(PushNotification $model)
    {
        $this->model = $model;
    }

    // get all PushNotification
    public function all()
    {
        return $this->model::with('upload')->orderByDesc('id')->paginate(settings('paginate_value'));
    }
    // get single row in PushNotification
    public function get($id)
    {
        return $this->model::with('upload')->find($id);
    }
    // All request data store in PushNotification.
    public function store($request)
    {
        try {
            $pushNotification                   = new $this->model;
            $pushNotification->title            = strip_tags($request->title);
            $pushNotification->description      = strip_tags($request->description);
            $pushNotification->user_id          = $request->user_id;
            $pushNotification->merchant_id      = $request->merchant_id;
            $pushNotification->type             = $request->type;

            if (isset($request->image) && $request->image != null) {
                $pushNotification->image_id = $this->file('', $request->image);
            }
            $pushNotification->save();
            $topicName = 'admin@wemaxit.com';

            try {

                app(PushNotificationService::class)->sendPushNotification($pushNotification, $topicName);
                app(PushNotificationService::class)->sendWebNotification($pushNotification, false);
            } catch (\Exception $exception) {
            }
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
    // All request data update in PushNotification.
    public function update($id, $request)
    {
        try {

            $pushNotification                   = $this->model::find($id);
            $pushNotification->title            = strip_tags($request->title);
            $pushNotification->description      = strip_tags($request->description);
            $pushNotification->user_id          = $request->user_id;
            $pushNotification->merchant_id      = $request->merchant_id;
            $pushNotification->type             = $request->type;

            if (isset($request->image) && $request->image != null) {
                $pushNotification->image_id = $this->file($pushNotification->image_id, $request->image);
            }
            $pushNotification->save();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    // Delete single row in PushNotification Model
    public function delete($id)
    {
        try {
            $pushNotification = $this->model::with('upload')->find($id);
            Upload::destroy($pushNotification->upload->id);
            if (file_exists($pushNotification->upload->original))
                unlink($pushNotification->upload->original);
            $pushNotification->delete();
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Exception $e) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    // Image Store in Upload Model
    public function file($file_id = '', $file)
    {
        try {
            $file_name = '';
            if (!blank($file)) {
                $destinationPath       = public_path('uploads/pushNotification');
                $profileImage          = date('YmdHis') . "." . $file->getClientOriginalExtension();
                $file->move($destinationPath, $profileImage);
                $file_name            = 'uploads/pushNotification/' . $profileImage;
            }
            if (blank($file_id)) {
                $upload           = new Upload();
            } else {
                $upload           = Upload::find($file_id);
                if (file_exists($upload->original)) {
                    unlink($upload->original);
                }
            }
            $upload->original     = $file_name;
            $upload->save();
            return $upload->id;
        } catch (\Exception $e) {
            return false;
        }
    }
}
