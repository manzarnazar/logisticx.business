<?php

namespace Modules\Widgets\Repositories;

use App\Enums\Status;
use App\Enums\Widget;
use App\Enums\ImageSize;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Widgets\Entities\Widgets;
use Illuminate\Support\Facades\Config;
use Modules\Widgets\Traits\WidgetTrait;
use App\Repositories\Upload\UploadInterface;
use Modules\Widgets\Repositories\WidgetsInterface;


class WidgetsRepository implements WidgetsInterface
{
    use ReturnFormatTrait;
    use WidgetTrait;

    protected $model, $upload;

    public function __construct(Widgets $model, UploadInterface $upload)
    {
        $this->model  = $model;
        $this->upload = $upload;
    }

    public function activeHeaderFooter()
    {
        $widgets  = [
            Config::get('site.widgets.header_style1'),
            Config::get('site.widgets.header_style2'),
            Config::get('site.widgets.footer_style1'),
        ];

        return $this->model::whereIn('section', $widgets)->where(['status' => Status::ACTIVE])->orderBy('position', 'asc')->get();
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(max(settings('paginate_value'), 50));
    }

    public function get(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->get();
    }

    public function getFind($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {



            $widgets              = new $this->model();
            $widgets->title       = $request->title;
            $widgets->section     = $request->section;
            $widgets->background  = $request->background;

            if ($request->background == 'bg_color') {
                $widgets->bg_color = $request->bg_color;
            }

            if ($request->background == 'bg_image') {
                $widgets->bg_image = $this->upload->uploadImage($request->bg_image, 'bg_image/', [ImageSize::IMAGE_1900x530], null);;
            }

            $widgets->section_padding      = $request->section_padding;

            $widgets->status      = $request->status ?? Status::INACTIVE;
            $widgets->position    = $request->position;
            $widgets->save();

            // Cache::forget(['footer', 'header']);
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        // try {
        $widgets               = $this->model::findOrFail($id);
        $widgets->title        = $request->title;
        $widgets->section      = $request->section;

        $widgets->background  = $request->background;

        if ($request->background == 'bg_color') {
            $widgets->bg_color = $request->bg_color;
        }

        if ($request->background == 'bg_image') {
            $widgets->bg_image = $this->upload->uploadImage($request->bg_image, 'bg_image/', [ImageSize::IMAGE_1900x530], $widgets->bg_image);;
        }

        $widgets->section_padding      = $request->section_padding;

        $widgets->status       = $request->status ?? Status::INACTIVE;
        $widgets->position     = $request->position;
        $widgets->save();

        // Cache::forget(['footer', 'header']);
        return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        // } catch (\Throwable $th) {
        //     return $this->responseWithError(___('alert.something_went_wrong'), []);
        // }
    }

    public function delete($id)
    {
        $this->model::destroy($id);

        Cache::forget(['footer', 'header']);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function statusUpdate($id)
    {
        try {
            $widgets                  = $this->model::find($id);
            if ($widgets->status == Status::ACTIVE) :
                $widgets->status  = Status::INACTIVE;
            elseif ($widgets->status == Status::INACTIVE) :
                $widgets->status  = Status::ACTIVE;
            endif;
            $widgets->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function getWidget($status = null, array $where = [], int $paginate = null, $orderBy = 'position')
    {
        $query = $this->model::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        if (!empty($where)) {
            $query->where($where);
        }

        if (config('app.app_demo')) {
            if (strstr(\Request()->url(), 'home2')) {
                $query->where('demo_style', 2);
            } elseif (strstr(\Request()->url(), 'home3')) {
                $query->where('demo_style', 3);
            } else {
                $query->where('demo_style', 1);
            }
        }

        $query->orderBy($orderBy, 'asc');

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function activeDeliveryCalculator()
    {
        $styles  = [Widget::DELIVERY_CALCULATOR_STYLE1, Widget::DELIVERY_CALCULATOR_STYLE2];
        return $this->model::whereIn('section', $styles)->where('status', Status::ACTIVE)->latest('updated_at')->first();
    }

    public function activeChargeListSection()
    {
        $styles  = [Widget::CHARGE_LIST_STYLE1];
        return $this->model::whereIn('section', $styles)->where('status', Status::ACTIVE)->first();
    }
}
