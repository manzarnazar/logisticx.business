<?php

namespace Modules\SocialLink\Repositories;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\SocialLink\Entities\SocialLink;
use App\Repositories\Upload\UploadInterface;
use Modules\SocialLink\Repositories\SocialLinkInterface;

class SocialLinkRepository implements SocialLinkInterface
{
    use ReturnFormatTrait;
    protected $socialLinkModel;
    public function __construct(SocialLink $socialLinkModel)
    {
        $this->socialLinkModel = $socialLinkModel;
    }

    public function get(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->socialLinkModel::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function getActiveAll()
    {
        return $this->socialLinkModel::where('status', Status::ACTIVE)->orderBy('position', 'desc')->get();
    }

    public function getFind($id)
    {
        return $this->socialLinkModel::find($id);
    }

    public function store($request)
    {
        try {
            $socialLink           = new $this->socialLinkModel();
            $socialLink->name     = $request->name;
            $socialLink->icon     = $request->link;
            $socialLink->link     = $request->link;
            $socialLink->position = $request->position;
            $socialLink->status   = $request->status;
            $socialLink->save();

            Cache::forget('socialLinks');
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {
            $socialLink           = $this->socialLinkModel::find($id);
            $socialLink->name     = $request->name;
            $socialLink->link     = $request->link;
            $socialLink->icon     = $request->icon;
            $socialLink->position = $request->position;
            $socialLink->status   = $request->status;
            $socialLink->save();

            Cache::forget('socialLinks');
            return $this->responseWithSuccess(__('SocialLink.social_link_updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {

            $socialLink = $this->getFind($id);
            $socialLink->delete();

            Cache::forget('socialLinks');
            return $this->responseWithSuccess(__('SocialLink.social_link_deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function statusUpdate($id)
    {

        try {
            $socialLink                 = $this->socialLinkModel::find($id);
            if ($socialLink->status     == Status::ACTIVE) :
                $socialLink->status     = Status::INACTIVE;
            elseif ($socialLink->status == Status::INACTIVE) :
                $socialLink->status     = Status::ACTIVE;
            endif;
            $socialLink->save();
            return $this->responseWithSuccess(__('SocialLink.social_link_status_updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
