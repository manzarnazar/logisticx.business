<?php

namespace App\Repositories\Support;

use App\Enums\UserType;
use App\Models\User;
use App\Models\Backend\Upload;
use App\Models\Backend\Support;
use App\Traits\ReturnFormatTrait;
use App\Models\Backend\Department;
use App\Models\Backend\SupportChat;
use App\Notifications\SupportNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Repositories\Upload\UploadInterface;
use App\Repositories\Support\SupportInterface;
use Illuminate\Support\Facades\DB;

class SupportRepository implements SupportInterface
{
    use ReturnFormatTrait;

    private array $notificationData;

    protected $model, $upload;

    public function __construct(Support $model, UploadInterface $upload)
    {
        $this->model  = $model;
        $this->upload = $upload;
    }


    // get all rows in Department model
    public function departments()
    {
        return Department::active()->orderBy('title')->get();
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        if (auth()->user()->user_type == UserType::MERCHANT) {
            $query->where('user_id', Auth::user()->id);
        }

        $query->orderBy($orderBy, $sortBy);

        return   $query->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function chats($id)
    {
        return  SupportChat::where('support_id', $id)->orderByDesc('id')->get();
    }

    public function store($request)
    {
        // try {
            DB::beginTransaction();

            $support                    = new $this->model;
            $support->user_id           = Auth::User()->id;
            $support->department_id     = $request->department_id;
            $support->service           = $request->service;
            $support->priority          = $request->priority;
            $support->subject           = $request->subject;
            $support->description       = $request->description;
            $support->date              = $request->date;
            if ($request->hasFile('attached_file')) {
                $support->attached_file     = $this->upload->uploadImage($request->attached_file, 'support/', [], '');
            }

            $support->save();

            $this->notificationData['message'] = 'Create a support';
            $this->notificationData['url'] =  route('support.view', $support->id);

            if (auth()->user()->user_type == UserType::MERCHANT) {
                $user = User::where('user_type', UserType::ADMIN)->get();
                $user->each->notify(new SupportNotification($this->notificationData));
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $this->responseWithError(___('alert.something_went_wrong'), []);
        // }
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();

            $support                    = $this->model::find($id);
            $support->user_id           = Auth::User()->id;
            $support->department_id     = $request->department_id;
            $support->service           = $request->service;
            $support->priority          = $request->priority;
            $support->subject           = $request->subject;
            $support->description       = $request->description;
            $support->date              = $request->date;
            if ($request->hasFile('attached_file')) {
                $support->attached_file     = $this->upload->uploadImage($request->attached_file, 'support/', [], $support->attached_file);
            }

            $support->save();

            $this->notificationData['message'] = 'Update a support';
            $this->notificationData['url'] =  route('support.view', $support->id);

            if (auth()->user()->user_type == UserType::MERCHANT) {
                $user = User::where('user_type', UserType::ADMIN)->get();
                $user->each->notify(new SupportNotification($this->notificationData));
            }

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function reply($request)
    {
        try {

            $support = $this->get($request->support_id);

            if (auth()->user()->user_type != UserType::ADMIN && auth()->user()->id != $support->user_id) {
                return $this->responseWithError(___('alert.unauthorized'), []);
            }

            DB::beginTransaction();
            $reply                = new SupportChat();
            $reply->support_id    = $request->support_id;
            $reply->user_id       = Auth::user()->id;
            $reply->message       = $request->message;
            $reply->attached_file = $this->upload->uploadImage($request->attached_file, 'support/', [], null);
            $reply->save();

            $this->notificationData['message'] = 'Reply to a support';
            $this->notificationData['url'] =  route('support.view',  $reply->support_id);

            if (auth()->user()->user_type == UserType::MERCHANT) {
                $user = User::where('user_type', UserType::ADMIN)->get();
                $user->each->notify(new SupportNotification($this->notificationData));
            }

            if (auth()->user()->id !==  $reply->support->user_id) {
                $reply->support->user->notify(new SupportNotification($this->notificationData));
            }

            DB::commit();

            return $this->responseWithSuccess(___('alert.reply_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $item  = $this->model::findOrFail($id);
            $this->upload->deleteImage($item->attached_file, 'delete');

            foreach ($item->supportChats as $chat) {
                $this->upload->deleteImage($chat->attached_file, 'delete');
            }

            $item->delete();

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
