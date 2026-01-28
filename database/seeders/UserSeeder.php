<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use App\Models\Backend\Hub;
use App\Models\Backend\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hub_id = Hub::first()?->id;

        $user                        = new User();
        $user->name                  = "Super Admin";
        $user->email                 = "superadmin@bugbuild.com";
        $user->password              = Hash::make('12345678');
        $user->mobile                = "01912938002";
        $user->nid_number            = "12345678912";
        $user->user_type             = UserType::ADMIN;
        $user->joining_date          = "2022-01-01";
        $user->image_id              = $this->uploadRepo->uploadSeederByPath("uploads/seeders/user/user.png");
        $user->department_id         = 1;
        $user->hub_id                = $hub_id;
        $user->salary                = 7000;
        $user->address               = "Mirpur-10, Dhaka-1216";
        $user->role_id               = 1;

        $role                           = Role::find($user->role_id);
        if ($role && $role->permissions != null) {
            $user->permissions          = $role->permissions;
        }

        $user->save();


        if (config('app.app_demo')) :

            // General user
            $user                        = new User();
            $user->name                  = "Hub User";
            $user->email                 = "incharge@bugbuild.com";
            $user->password              = Hash::make('12345678');
            $user->mobile                = "01920202021";
            $user->nid_number            = "987654345";
            $user->designation_id        = 3;
            $user->department_id         = 3;
            $user->hub_id                = 1;
            $user->user_type             = UserType::INCHARGE;
            $user->image_id              = $this->uploadRepo->uploadSeederByPath("uploads/seeders/user/user.png");
            $user->joining_date          = "2022-05-08";
            $user->address               = "10, Old Dhaka, Dhaka-1000";
            $user->role_id               = 3;
            $role                        = Role::find($user->role_id);
            if ($role && $role->permissions != null) {
                $user->permissions       = $role->permissions;
            }
            $user->salary                = 24000;
            $user->save();

        endif;
    }
}
