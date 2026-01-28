<?php
namespace Modules\Widgets\Traits;

use App\Models\Upload;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Support\Facades\Config;

trait WidgetTrait
{
    //validation
    private function onlyInputValidation($request){

        switch ((int)$request->type) {
            case Config::get('site.widgets.hero_section1') :
                $validator = [
                    'type'         => ['required'],
                    'title'        => ['required'],
                    'position'     => ['required'],
                    'status'       => ['required']
                ];
            break;
            case Config::get('beauty_spa.widgets.our_speciality') :
                $validator = [
                    'type'         => ['required'],
                    'title'        => ['required'],
                    'position'     => ['required'],
                    'status'       => ['required']
                ];
            break;
            case Config::get('beauty_spa.widgets.here_is_my_full_resume') :
                $validator = [
                    'type'         => ['required'],
                    'title'        =>['required'],
                    'description'  =>['required'],
                    'position'     => ['required'],
                    'status'       =>['required']
                ];
            break;
            case Config::get('beauty_spa.widgets.portfolio') :
                $validator = [
                    'type'         => ['required'],
                    'title'        => ['required'],
                    'position'     => ['required'],
                    'status'       => ['required']
                ];
            break;
            case Config::get('beauty_spa.widgets.our_service') :
                $validator = [
                    'type'         => ['required'],
                    'title'        =>['required'],
                    'description'  =>['required'],
                    'position'     => ['required'],
                    'status'       =>['required']
                ];
            break;

            case Config::get('beauty_spa.widgets.what_clients_say') :
                $validator = [
                    'type'         => ['required'],
                    'title'        =>['required'],
                    'position'     => ['required'],
                    'status'       =>['required']
                ];
            break;
            case Config::get('beauty_spa.widgets.i_am_expert') :
                $validator = [
                    'type'         => ['required'],
                    'title'        =>['required'],
                    'description'  =>['required'],
                    'position'     => ['required'],
                    'status'       =>['required']
                ];
            break;
            case Config::get('beauty_spa.widgets.contact_us') :
                $validator = [
                    'type'         => ['required'],
                    'title'        => ['required'],
                    'position'     => ['required'],
                    'status'       => ['required']
                ];
            break;
            default:
                $validator = [];
            break;
        }

        return $validator;
    }


    //catch only spacific input
    private function onlyInput($request){

        switch ($request->type) {
            case Config::get('beauty_spa.widgets.about_us') :
                $requestData = $request->only('id','type','title','position','status');
            break;
            case Config::get('beauty_spa.widgets.our_speciality') :
                $requestData = $request->only('id','type','title','position','status');
            break;
            case Config::get('beauty_spa.widgets.here_is_my_full_resume') :
                $requestData = $request->only('id','type','title','description','position','status');
            break;
            case Config::get('beauty_spa.widgets.i_am_expert') :
                $requestData = $request->only('id','type','title','description','image_id','position','status');
            break;
            case Config::get('beauty_spa.widgets.portfolio') :
                $requestData = $request->only('id','type','title','position','status');
            break;
            case Config::get('beauty_spa.widgets.our_service') :
                $requestData = $request->only('id','type','title','description','position','status');
            break;
            case Config::get('beauty_spa.widgets.what_clients_say') :
                $requestData = $request->only('id','type','title','position','status');
            break;
            case Config::get('beauty_spa.widgets.contact_us') :
                $requestData = $request->only('id','type','title','position','status');
            break;
            default:
                $requestData=null;
            break;
        }
        return $requestData;
    }

    private function pageName ($request){
        $page = 'blank';
        switch ((int) $request->type) {

            case Config::get('beauty_spa.widgets.about_us') :
                $page = 'about_us';
            break;
            case Config::get('beauty_spa.widgets.our_speciality') :
                $page = 'our_speciality';
            break;
            case Config::get('beauty_spa.widgets.here_is_my_full_resume') :
                $page = 'here_is_my_full_resume';
            break;
            case  Config::get('beauty_spa.widgets.i_am_expert') :
                $page = 'i_am_expert';
            break;
            case Config::get('beauty_spa.widgets.our_service') :
                $page = 'our_service';
            break;
            case  Config::get('beauty_spa.widgets.portfolio') :
                $page = 'portfolio';
            break;
            case Config::get('beauty_spa.widgets.what_clients_say'):
                $page = 'what_clients_say';
            break;
            case Config::get('beauty_spa.widgets.contact_us'):
                $page = 'contact_us';
            break;
        }
        return $page;
    }

}
