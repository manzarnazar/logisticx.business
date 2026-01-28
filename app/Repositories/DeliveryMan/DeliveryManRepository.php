<?php

namespace App\Repositories\DeliveryMan;

use App\Enums\ImageSize;
use App\Enums\StatementType;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\DeliverymanStatement;
use App\Models\Backend\Expense;
use App\Models\Backend\Hub;
use App\Models\Backend\Income;
use App\Models\Backend\Role;
use App\Models\Backend\Upload;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use App\Repositories\Upload\UploadInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class DeliveryManRepository implements DeliveryManInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(DeliveryMan $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }


    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query = $this->model::query();

        $query->with('user', 'uploadLicense', 'hub');

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return  $query->paginate($paginate);
        }

        return $query->get();
    }

    public function filter($request)
    {
        return $this->model::with('uploadLicense', 'user', 'hub')->where(function ($query) use ($request) {
            $query->whereHas('user', function ($queryUser) use ($request) {
                if ($request->name) {
                    $queryUser->where('name', 'like', '%' . $request->name . '%');
                }
                if ($request->email) {
                    $queryUser->where('email', 'like', '%' . $request->email . '%');
                }
                if ($request->phone) :
                    $queryUser->where('mobile', 'like', '%' . $request->phone . '%');
                endif;
            });
        })->orderByDesc('id')->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $user                       = new User();
            $user->name                 = $request->name;
            $user->mobile               = $request->mobile;
            $user->email                = $request->email;
            $user->password             = Hash::make($request->password);
            $user->address              = $request->address;
            $user->hub_id               = $request->hub_id;
            $user->status               = $request->status;
            $user->user_type            = UserType::DELIVERYMAN;

            $role                           = Role::where('slug', 'delivery-man')->first();
            if ($role && $role->permissions != null) {
                $user->permissions          = $role->permissions;
            }

            if ($request->salary !== "") :
                $user->salary               = $request->salary;
            endif;

            if ($request->file('image')) {
                $user->image_id  = $this->upload->uploadImage($request->image, 'delivery_man/', [ImageSize::BLOG_IMAGE_ONE, ImageSize::BLOG_IMAGE_TWO, ImageSize::BLOG_IMAGE_THREE], '');
            }

            $user->save();

            $deliveryMan                                 = new DeliveryMan();
            $deliveryMan->user_id                        = $user->id;

            if ($request->file('driving_license')) {
                $deliveryMan->driving_license  = $this->upload->uploadImage($request->file('driving_license'), 'driving_license/',  [], '');
            }


            $deliveryMan->coverage_id                   = $request->input('coverage');
            $deliveryMan->pickup_slot_id                = $request->input('pickup_slot');

            $deliveryMan->save();
            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            $deliveryMan                                 = $this->model::findOrFail($id);

            if ($request->file('driving_license')) {
                $deliveryMan->driving_license  = $this->upload->uploadImage($request->driving_license, 'driving_license/',  [], $deliveryMan->driving_license);
            }

            $deliveryMan->coverage_id           = $request->input('coverage');
            $deliveryMan->pickup_slot_id        = $request->input('pickup_slot');

            $deliveryMan->save();

            $user                       = User::findOrFail($deliveryMan->user_id);
            $user->status               = $request->status;
            $user->name                 = $request->name;
            $user->mobile               = $request->mobile;
            $user->email                = $request->email;
            $user->address              = $request->address;
            $user->hub_id               = $request->hub_id;
            if ($request->salary !== "") :
                $user->salary               = $request->salary;
            endif;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->file('image')) {
                $user->image_id  = $this->upload->uploadImage($request->image, 'delivery_man/', [ImageSize::BLOG_IMAGE_ONE, ImageSize::BLOG_IMAGE_TWO, ImageSize::BLOG_IMAGE_THREE], $user->image_id);
            }

            $user->save();
            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $item =   $this->model::find($id);
            $this->upload->deleteImage($item->image_id, 'delete');
            $item->delete($id);
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    // get all rows in Hub model
    public function hubs()
    {
        return Hub::orderBy('name')->get();
    }

    public function paymentLogs()
    {
        $data           = [];
        $income         = Income::where('account_head_id', 2)->where('delivery_man_id', Auth::user()->deliveryman->id)->get();
        $expense        = Expense::where('account_head_id', 5)->where('delivery_man_id', Auth::user()->deliveryman->id)->get();
        $data['income'] = $income;
        $data['expense'] = $expense;
        return $data;
    }


    public function searchHero($request)
    {
        $response = false;

        $query = $this->model::query();

        $query->with('user');
        $query->whereHas('user', fn ($query)  => $query->where('status', Status::ACTIVE));

        if ($request->id != null) {
            $query->where('id', $request->id);
            $response = true;
        }

        if ($request->user_id != null) {
            $query->where('user_id', $request->user_id);
            $response = true;
        }

        if ($request->coverage_id != null) {
            $query->where('coverage_id', $request->coverage_id);
            $response = true;
        }

        if ($request->hub_id != null) {
            $query->whereHas('user', fn ($query)  => $query->where('hub_id', $request->hub_id));
            $response = true;
        }

        if ($request->name != null || $request->search != null) {
            $search = $request->name ?? $request->search;
            $query->whereHas('user', fn ($query) => $query->where('name', 'like', "%{$search}%"));

            $response = true;
        }

        if (!$response) {
            return [];
        }

        $query->take(20);

        $response = $query->get();

        return $response;
    }
}
