<?php

namespace Modules\Language\Repositories\Language;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Language\Entities\FlagIcon;
use Modules\Language\Entities\Language;
use Modules\Language\Repositories\Language\LanguageInterface;

class LanguageRepository implements LanguageInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function flags()
    {
        $flags =  FlagIcon::all();
        return $flags;
    }

    public function all(int $status = null,   int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return  $query->paginate($paginate);
        }

        return $query->get();
    }

    public function activeLang()
    {
        return $this->model::where('status', Status::ACTIVE)->get();
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $language                   = new $this->model();
            $language->name             = $request->name;
            $language->code             = $request->code;
            $language->icon_class       = $request->icon_class;
            $language->text_direction   = $request->text_direction;
            $language->status           = $request->status;
            $language->save();

            $path     = base_path('lang/' . $request->code);

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
                File::copyDirectory(base_path('lang/en'), $path); // Updated this line
            }
            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $language             = $this->model::find($request->id);
            if ($language->code  != $request->code) : //if not match old code and new code


                $old_directory    = base_path('lang/' . $language->code);

                if (File::isDirectory($old_directory)) :
                    File::deleteDirectory($old_directory);
                endif;

                $path             = base_path('lang/' . $request->code);

                if (!File::isDirectory($path)) :
                    File::makeDirectory($path, 0777, true, true);
                    File::copyDirectory(base_path('lang/en'), base_path('lang/' . $request->code));
                endif;
            elseif ($language->code  == $request->code) :
                $path             = base_path('lang/' . $request->code);

                if (!File::isDirectory($path)) :
                    File::makeDirectory($path, 0777, true, true);
                    File::copyDirectory(base_path('lang/en'), base_path('lang/' . $request->code));
                endif;

            endif;

            $language->name             = $request->name;
            $language->code             = $request->code;
            $language->icon_class       = $request->icon_class;
            $language->text_direction   = $request->text_direction;
            $language->status           = $request->status;
            $language->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    //edit phrase data
    public function editPhrase($id)
    {
        try {
            $lang           = $this->model::find($id);

            $jsonString          = file_get_contents(base_path("lang/" . $lang->code . "/account.json"));
            $data['terms']       = json_decode($jsonString, true);
            return $this->responseWithSuccess('', $data);
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    //update phrase data
    public function updatePhrase($request, $code)
    {
        try {

            $jsonString     = file_get_contents(base_path("lang/$code/$request->lang_module.json"));
            $data           = json_decode($jsonString, true);

            foreach ($data as $key => $value) :
                $data[$key]        = $request->$key;
            endforeach;

            $newJsonString = json_encode($data, JSON_UNESCAPED_UNICODE);
            file_put_contents(base_path("lang/$code/$request->lang_module.json"), stripslashes($newJsonString));

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    //language delete
    public function delete($id)
    {
        try {
            $lang         = $this->model::find($id);

            if ($lang->code == 'en' || $lang->code == 'bn') {
                return $this->responseWithError(___('alert.delete_not_allowed'), []);
            }

            $path         = base_path('/lang/' . $lang->code);
            if (File::exists($path)) :
                File::deleteDirectory($path);
            endif;
            $jsonPath     = base_path('/lang/' . $lang->code . '.json');
            if (File::exists($jsonPath)) :
                unlink($jsonPath);
            endif;

            $lang->delete();

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
