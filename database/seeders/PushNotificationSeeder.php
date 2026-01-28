<?php

namespace Database\Seeders;

use App\Models\Backend\PushNotification;
use App\Models\Backend\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PushNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $upload            = Upload::create([
            'original'  => 'uploads/notification/notification.jpg',
            'image_one'  => 'uploads/notification/notification.jpg',
            'type'      => 'image',
        ]);


        PushNotification::create([
            'title' => 'New Message',
            'description' => 'You have received a new message.',
            'user_id' => 1,
            'type' => 1,
            'image_id' => $upload->id,
        ]);

        PushNotification::create([
            'title' => 'Order Update',
            'description' => 'Your order has been updated.',
            'merchant_id' => 1,
            'type' => 1,
        ]);

        PushNotification::create([
            'title' => 'New Event',
            'description' => 'There is a new event near you.',
            'type' => 1,
            'image_id' => $upload->id,
        ]);

        PushNotification::create([
            'title' => 'General Notification',
            'description' => 'This is a general notification.',
            'type' => 1,
        ]);

        PushNotification::create([
            'title' => 'Special Offer',
            'description' => 'Check out our special offer!',
            'user_id' => 1,
            'merchant_id' => 1,
            'type' => 1,
            'image_id' => $upload->id,
        ]);
    }
}
