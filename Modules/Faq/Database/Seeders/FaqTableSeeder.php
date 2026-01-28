<?php

namespace Modules\Faq\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Faq\Entities\Faq;

class FaqTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'position' => '01',
                'icon' => 'icofont-macbook',
                'title' => 'Reques & Booking',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis molestias qui asperiores omnis deleniti illo natus ipsam, nesciunt alias vero.',
                'status' => 1,
            ],
            [
                'position' => '02',
                'icon' => 'icofont-calendar',
                'title' => 'Dispatch & Scheduling',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis molestias qui asperiores omnis deleniti illo natus ipsam, nesciunt alias vero.',
                'status' => 1,
            ],
            [
                'position' => '03',
                'icon' => 'icofont-location-arrow',
                'title' => 'Transit & Monitoring',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis molestias qui asperiores omnis deleniti illo natus ipsam, nesciunt alias vero.',
                'status' => 1,
            ],
            [
                'position' => '04',
                'icon' => 'icofont-bank',
                'title' => 'Delivery & Payment',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis molestias qui asperiores omnis deleniti illo natus ipsam, nesciunt alias vero.',
                'status' => 1,
            ],
            [
                'position' => '05',
                'icon' => 'icofont-ui-settings',
                'title' => 'Feedback & Support',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet repellendus quibusdam voluptatibus, corporis placeat consequatur exercitationem architecto deserunt odit.',
                'status' => 1,
            ],
             [
                'position' => '05',
                'icon' => 'icofont-ui-settings',
                'title' => 'Feedback & Support',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet repellendus quibusdam voluptatibus, corporis placeat consequatur exercitationem architecto deserunt odit.',
                'status' => 1,
            ],
            // Additional 6 items
            [
                'position' => '06',
                'icon' => 'icofont-ambulance',
                'title' => 'Emergency Services',
                'description' => 'Our emergency ambulance services are available 24/7 to provide immediate medical assistance and transportation to the nearest healthcare facility.',
                'status' => 1,
            ],
            [
                'position' => '07',
                'icon' => 'icofont-doctor',
                'title' => 'Medical Equipment',
                'description' => 'All our ambulances are equipped with essential medical equipment and trained paramedics to ensure patient safety during transportation.',
                'status' => 1,
            ],
            [
                'position' => '08',
                'icon' => 'icofont-credit-card',
                'title' => 'Payment Methods',
                'description' => 'We accept various payment methods including cash, credit cards, mobile banking, and insurance coverage for ambulance services.',
                'status' => 1,
            ],
            [
                'position' => '09',
                'icon' => 'icofont-clock-time',
                'title' => 'Response Time',
                'description' => 'Our average response time is 15-20 minutes in urban areas and 25-30 minutes in suburban locations depending on traffic conditions.',
                'status' => 1,
            ],
            [
                'position' => '10',
                'icon' => 'icofont-users',
                'title' => 'Trained Staff',
                'description' => 'Our team consists of certified paramedics, emergency medical technicians, and trained drivers with extensive experience in emergency medical services.',
                'status' => 1,
            ],
            [
                'position' => '11',
                'icon' => 'icofont-hospital',
                'title' => 'Hospital Coordination',
                'description' => 'We coordinate with hospitals in advance to ensure seamless patient transfer and immediate medical attention upon arrival.',
                'status' => 1,
            ],
        ];

        foreach ($data as $item) {
            Faq::create($item);
        }
    }
}
