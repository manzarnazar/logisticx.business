<?php

namespace Modules\Client\Database\Seeders;

use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\Model;

class ClientTableSeeder extends Seeder
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
        Model::unguard();

        $users = [
            'David Bowie',
            'Michel Aoun',
            'Steve Rhodes',
            'Ribin Richard',
            'Ashok Mitra',
            'John Smith',
            'Emily Davis',
            'Daniel Jackson',
            'Sarah Adams',
        ];

        foreach ($users as $key => $user) {
            $clients            = new Client();
            $clients->name      = $user;
            $clients->logo      = $this->uploadRepo->uploadSeederByPath("uploads/seeders/client_logo/client-" . ($key + 1) . '.png');
            $clients->position  = $key;
            // new fields
            $clients->title = 'Client Title ' . ($key + 1);
            $clients->facebook_id = 'fb_' . strtolower(str_replace(' ', '_', $user));
            $clients->twitter_id = 'tw_' . strtolower(str_replace(' ', '_', $user));
            $clients->linkedIn_id = 'li_' . strtolower(str_replace(' ', '_', $user));
            $clients->save();
        }
    }
}
