<?php

namespace Modules\Client\Repositories\Client;

use App\Enums\Status;
use App\Enums\ImageSize;
use App\Traits\ReturnFormatTrait;
use Modules\Client\Entities\Client;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Upload\UploadInterface;
use Modules\Client\Repositories\Client\ClientInterface;

class ClientRepository implements ClientInterface
{
    use ReturnFormatTrait;

    protected $model;
    protected $upload;

    public function __construct(Client $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function getActive(string $orderBy = 'position', string $sortBy = 'asc')
    {
        return $this->model::where('status', Status::ACTIVE)->orderBy($orderBy, $sortBy)->get(10);
    }

    public function getFind($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {

        try {
            $client              = new $this->model;
            $client->name        = $request->name;
            $client->title        = $request->title;
            $client->linkedIn_id        = $request->linkedIn_id;
            $client->twitter_id        = $request->twitter_id;
            $client->facebook_id        = $request->facebook_id;
            $client->status      = $request->status ?? Status::INACTIVE;
            $client->position    = $request->position;
            $client->logo        = $this->upload->uploadImage($request->logo, 'clientlogo/', [ImageSize::CLIENT_LOGO, ImageSize::CLIENT_IMAGE_TWO], '');
            $client->save();

            Cache::forget('clients');


            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {
            $client              = $this->model::findOrFail($id);
            $client->name        = $request->name;
            $client->title        = $request->title;
            $client->linkedIn_id        = $request->linkedIn_id;
            $client->twitter_id        = $request->twitter_id;
            $client->facebook_id        = $request->facebook_id;
            $client->position    = $request->position;
            $client->status      = $request->status ?? Status::INACTIVE;
            $client->logo        = $this->upload->uploadImage($request->logo, 'clientlogo/', [ImageSize::CLIENT_LOGO, ImageSize::CLIENT_IMAGE_TWO], $client->logo);
            $client->save();

            Cache::forget('clients');

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {

            $client = $this->getFind($id);
            $this->upload->deleteImage($client->logo, 'delete');
            $client->delete();

            Cache::forget('clients');

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function statusUpdate($id)
    {
        try {
            $Client                 = $this->model::find($id);
            if ($Client->status     == Status::ACTIVE) :
                $Client->status     = Status::INACTIVE;
            elseif ($Client->status == Status::INACTIVE) :
                $Client->status     = Status::ACTIVE;
            endif;
            $Client->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
