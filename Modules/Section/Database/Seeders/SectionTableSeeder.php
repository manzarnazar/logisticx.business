<?php

namespace Modules\Section\Database\Seeders;

use App\Enums\Status;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;
use Modules\Section\Enums\Type;
use Modules\Section\Entities\Section;
use Illuminate\Database\Eloquent\Model;

class SectionTableSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }

    public function run()
    {
        Model::unguard();

        $this->ContactUs();
        // $this->Counter();
        // $this->socialLink();
        // $this->header();
        $this->heroSection();
        $this->AboutUs();
        $this->OurAchievement(); // our_achievement/Counter
        $this->OurAchievementTwo();
        $this->OurBestServices();
        $this->FAQ(); //
        $this->FAQStyleTwo(); //
        $this->ClientReview();  // Testimonials
        $this->Blogs();
        $this->Clients();
        $this->Signin();
        $this->Signup();
        $this->Breadcrumb();
        $this->DeliveryCalculator();
        $this->DeliveryCalculatorTwo();
        $this->ChargeList();
        $this->CoverageArea();
        $this->CTA();
        $this->THEME_APPEARANCE();
        $this->DeliverySuccess();
        $this->Gallery();
        $this->Features();
        $this->HowWeWork();

        $this->popups_content();
    }

    // public function header()
    // {
    //     Section::create([
    //         'type'  => Type::HEADER,
    //         'key'   => 'header-logo',
    //         'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/light_logo.png"),
    //     ]);

    //     Section::create([
    //         'type'  => Type::HEADER,
    //         'key'   => 'header-topbar-logo-1',
    //         'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/icons/icon-phone.png"),
    //     ]);

    //     Section::create([
    //         'type'  => Type::HEADER,
    //         'key'   => 'header-topbar-logo-2',
    //         'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/icons/icon-email.png"),
    //     ]);

    //     Section::create([
    //         'type'  => Type::HEADER,
    //         'key'   => 'phone-number',
    //         'value' => '+88 999 999'
    //     ]);

    //     Section::create([
    //         'type'  => Type::HEADER,
    //         'key'   => 'email',
    //         'value' => 'percelyfly@mail.com'
    //     ]);

    //     Section::create([
    //         'type'  => Type::HEADER,
    //         'key'   => 'header_top_bar',
    //         'value' => Status::ACTIVE
    //     ]);
    // }

    public function heroSection()
    {
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'hero_image',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/ship-1.jpg"),
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'client_image_one',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/delivery-1.jpg"),
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'client_image_two',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/delivery-1.jpg"),
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'client_image_three',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/delivery-1.jpg"),
        ]);

        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'short_title',
            'value' => '24H Delivery'
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'button_name',
            'value' => 'Get A Quote'
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'satisfied_clients_label',
            'value' => 'satisfied clients'
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'link',
            'value' => 'https://percelyflyfff.com'
        ]);
        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'total_satisfied_clients',
            'value' => '7K'
        ]);

        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => "hero_section_title",
            'value' => 'Best service and <span>fast delivery</span>, All over the Bangladesh'
        ]);

        Section::create([
            'type'  => Type::HERO_SECTION,
            'key'   => 'hero_section_short_description',
            'value' => 'Delivery your package quickly cheaply and easily only here, We prioritize the safety of your package.'
        ]);
    }

    // public function socialLink()
    // {
    //     Section::create([
    //         'type'  => Type::SOCIAL_LINK,
    //         'key'   => 'hero_image',
    //         'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/tracking-image-1.jpg"),
    //     ]);
    // }

    public function ContactUs()
    {
        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'title',
            'value' => 'Contact Us'
        ]);

        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'description',
            'value' => 'RX is a complete platform for end-to-end delivery and logistics services for any business or personal needs. The services include parcel delivery, bulk shipment, line hall, truck rental, loading-unloading, warehouse, logistics services and customized solutions as required Us'
        ]);

        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'address',
            'value' => 'Address:4th floor, Feni Center, Feni-3900, Bangladesh'
        ]);
        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'phone',
            'value' => "+8801811843300"
        ]);

        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'email',
            'value' => 'support@bugbuild.com'
        ]);
        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'Breadcrumb_image',
            'value' => $this->uploadRepo->uploadSeederByPath("frontend/assets/img/logistics-img/breadcrumb-img-4.jpg")
        ]);
        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'left_info_image',
            'value' => $this->uploadRepo->uploadSeederByPath("frontend/assets/img/logistics-img/shap-1.png")
        ]);
        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'right_info_image',
            'value' => $this->uploadRepo->uploadSeederByPath("frontend/assets/img/logistics-img/hero-2.jpg")
        ]);
        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'website',
            'value' => 'https://bugbuild.com/'
        ]);

        Section::create([
            'type'  => Type::CONTACT_US,
            'key'   => 'map',
            'value' => 'https://maps.google.com/maps?q=feni%20bangladesh&t=&z=7&ie=UTF8&iwloc=&output=embed'
        ]);
    }

    // public function Counter()
    // {
    //     $widgets = [
    //         ['title' => 'Years Experience In Our Company',          'number' => 16],
    //         ['title' => 'project complete at last 5 years',         'number' => 520000],
    //         ['title' => 'Clients Happy with metier',                'number' => 95],
    //         ['title' => 'Clients Active With Metier',               'number' => 987],
    //         ['title' => 'project complete at last 5 years',         'number' => 50],
    //     ];
    //     foreach ($widgets as $key => $widget) {
    //         $n = $key + 1;
    //         Section::create([
    //             'type'  => Type::COUNT,
    //             'key'   => 'widget_' . $n . '_title',
    //             'value' => $widget['title']
    //         ]);
    //         Section::create([
    //             'type'  => Type::COUNT,
    //             'key'   => 'widget_' . $n . '_number',
    //             'value' => $widget['number']
    //         ]);
    //     }
    // }


    public function Features()
    {
        $data = [
            ['key' => 'section_tagline',            'value' => 'OUR EASY WORKING STEPS'],
            ['key' => 'section_main_title',         'value' => 'We Aim to Contribute Well to Your Company'],
            ['key' => 'process_one',                'value' => 'Replenishment & Picking'],
            ['key' => 'process_two',                'value' => 'Safe Transit & Tracking'],
            ['key' => 'process_three',              'value' => 'On-time Delivery to Receiver'],
            ['key' => 'bg_image',              'value' => $this->uploadRepo->uploadSeederByPath("frontend/assets/img/logistics-img/img-8.jpg")]
        ];

        foreach ($data as $item) {
            $item['type'] = Type::FEATURES;
            Section::create($item);
        }
    }

    public function Gallery()
    {
        $data = [
            ['key' => 'short_title',                'value' => 'Gallery'],
            ['key' => 'title',                      'value' => 'Moments Captured'],
            ['key' => 'short_description',          'value' => 'A collection or space for displaying artworks, photographs, or other visual items.'],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::GALLERY;
            Section::create($item);
        }
    }


    public function AboutUs()
    {
        $data = [
            ['key' => 'section_tagline',             'value' => 'KNOW ABOUT OUR TRANSPORT'],
            ['key' => 'section_main_title',          'value' => 'We Guarantee Fast & Safe Transport for You'],
            ['key' => 'total_satisfied_clients',     'value' => '4.2k'],
            ['key' => 'satisfied_clients_label',     'value' => 'Satisfied Clients'],
            ['key' => 'left_service_title1',          'value' => 'Ontime Delivery Gaurentee'],
            ['key' => 'left_service_image_one',           'value' =>  $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/delivery-man.png')],
            ['key' => 'left_service_title2',          'value' => 'Real Time Tracking'],
            ['key' => 'left_service_image_two',           'value' =>  $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/time-tracking.png')],
            ['key' => 'right_service_title1',         'value' => 'Optimize Travell Cost System'],
            ['key' => 'right_service_image_one',           'value' => $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/save-money.png')],
            ['key' => 'right_service_title2',         'value' => 'Security Gaurantee'],
            ['key' => 'right_service_image_two',           'value' => $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/warranty.png')],
            ['key' => 'promotional_red_text',        'value' => 'Duis aute irure dolor in reprehenderit in velit esse cillum dolore eu nulla pariatur.'],
            ['key' => 'primary_button_text',         'value' => 'Discover More'],
            ['key' => 'primary_button_link',          'value' => 'https://bugbuild.com/'],
            ['key' => 'contact_title',               'value' => 'Call Us free'],
            ['key' => 'contact_number',              'value' => '+9993256589'],
            ['key' => 'section_description',         'value' => 'Arki features minimal and stylish design. The theme is well crafted for all the modern architect and interior design website. With Arki, it makes your website look even more attractive and impressive to'],
            ['key' => 'client_avatar_image',               'value' =>  $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/person-1.png')],
            ['key' => 'section_image_one',           'value' =>  $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/ship-1.jpg')],
            ['key' => 'section_image_two',           'value' =>  $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/service-sidebar.jpg')],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::ABOUT_US;
            Section::create($item);
        }
    }


    public function DeliverySuccess()
    {
        $data = [
            ['key' => 'short_title',                'value' => 'Case Studies'],
            ['key' => 'title',                      'value' => 'Proud to Excellence eliver Success'],
            ['key' => 'short_description',          'value' => 'Qui dolores facilis minima cupiditate ut nemo. Quia repellat fugiat qui voluptas officiis modi necessitatibus eos. Est atque et unde laudantium. Sunt sed ex omnis voluptatem omnis dolorum tempora.'],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::DELIVERY_SUCCESS;
            Section::create($item);
        }
    }

    public function OurAchievement()
    {
        $data = [
            ['key' => 'short_title',                'value' => 'Achievement'],
            ['key' => 'title',                      'value' => 'Our Achievement'],
            ['key' => 'our_achievement',            'value' => 'Successfully Managed Over 3000 Parcels in a Single Month'],
            ['key' => 'image_one',                  'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/s-7.png')],
            ['key' => 'image_two',                  'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/s-8.png')],

            ['key' => 'year_experience_title',      'value' => 'Years of Experience'],
            ['key' => 'year_experience_number',     'value' => '25+'],

            ['key' => 'style_two_big_image',        'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/style_two_1.jpg')],
            ['key' => 'style_two_small_image',      'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/style_two_2.jpg')],

            ['key' => 'card_one_title',             'value' => 'Top-Rated Insurance Firms'],
            ['key' => 'card_two_title',             'value' => 'Elite Insurance Providers'],
            ['key' => 'card_three_title',           'value' => 'Top-Rated Insurance Firms'],
            ['key' => 'card_four_title',            'value' => 'Elite Insurance Providers'],

            ['key' => 'counter_1_image',            'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/s-5.png')],
            ['key' => 'counter_1_number',           'value' => '3000'],
            ['key' => 'counter_1_title',            'value' => 'Total Parcels'],

            ['key' => 'counter_2_image',            'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/s-2.png')],
            ['key' => 'counter_2_number',           'value' => '800'],
            ['key' => 'counter_2_title',            'value' => 'Ware House'],

            ['key' => 'counter_3_image',            'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/s-1.png')],
            ['key' => 'counter_3_number',           'value' => '5320'],
            ['key' => 'counter_3_title',            'value' => 'Total Shopping'],

            ['key' => 'activity_title',             'value' => 'Support & Activity'],
            ['key' => 'activity_icon_image', 'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/service_icons/s-4.png')],
            ['key' => 'activity_number',            'value' => '24/7'],

            ['key' => 'achievement_list',           'value' => 'Best Delivery Efficiency, Fastest Delivery of the Month, Most Reliable Delivery Partner, Outstanding Customer Satisfaction, Top Delivery Driver of the Year, Best Parcel Handling Team, Most Improved Delivery Time, Highest Package Volume Delivered, Best Team Collaboration in Logistics, Excellent Service Consistency Award.']
        ];

        foreach ($data as $item) {
            $item['type'] = Type::OUR_ACHIEVEMENT;
            Section::create($item);
        }
    }


    public function OurAchievementTwo()
    {
        $data = [
            ['key' => 'section_tagline',         'value' => 'OUR ACHIEVEMENT'],
            ['key' => 'section_title',           'value' => 'Successfully Managed Over 3000 Parcels in a Single Month'],
            ['key' => 'button_text',             'value' => 'Request a Quote'],
            ['key' => 'button_url',              'value' => 'https://bugbuild.com/'],

            ['key' => 'counter_one_title',       'value' => 'Total Parcels'],
            ['key' => 'counter_one_value',       'value' => '3000'],

            ['key' => 'counter_two_title',       'value' => 'Ware House'],
            ['key' => 'counter_two_value',       'value' => '800'],

            ['key' => 'counter_three_title',     'value' => 'total Shopping'],
            ['key' => 'counter_three_value',     'value' => '5320'],

            ['key' => 'activity_title',         'value' => 'Support & Activity'],
            ['key' => 'activity_value',          'value' => '24/7'],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::OUR_ACHIEVEMENT_TWO;
            Section::create($item);
        }
    }


    public function OurBestServices()
    {
        $data = [
            ['key' => 'section_tagline',           'value' => 'OUR SERVICES'],
            ['key' => 'section_main_title',        'value' => 'Logistics Special Services'],
            ['key' => 'read_more',                 'value' => 'Read More'],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::OUR_BEST_SERVICE;
            Section::create($item);
        }
    }

    public function HowWeWork()
    {
        $data = [
            ['key' => 'section_tagline',           'value' => 'How We Works'],
            ['key' => 'section_main_title',        'value' => 'Journey of Your Shipment Our Proven Transport Process'],
            ['key' => 'HowWeWork_image',        'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/logistics-img/img-6.jpg')],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::HOW_WE_WORK;
            Section::create($item);
        }
    }

    public function FAQ()
    {
        Section::create([
            'type' => Type::FAQ,
            'key'  => 'title',
            'value' => 'Frequently Ask Question'
        ]);

        Section::create([
            'type' => Type::FAQ,
            'key'  => 'short_title',
            'value' => 'FAQ'
        ]);

        Section::create([
            'type'  => Type::FAQ,
            'key'   => 'faq_image',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/img-10.jpg"),
        ]);

        Section::create([
            'type'  => Type::FAQ,
            'key'   => 'description',
            'value' => fake()->paragraph()
        ]);
    }

    public function FAQStyleTwo()
    {
        $data = [
            ['key' => 'section_tagline',           'value' => 'How We Works'],
            ['key' => 'section_title',             'value' => 'Journey of Your Shipment Our Proven Transport Process'],
            ['key' => 'description',               'value' => fake()->paragraph()],
            ['key' => 'label_one_value',           'value' => '900'],
            ['key' => 'label_one_title',           'value' => 'Project <br>Completed'],
            ['key' => 'label_two_value',           'value' => '820'],
            ['key' => 'label_two_title',           'value' => 'Delivered <br>on Time'],
            ['key' => 'faq_image',                  'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/logistics-img/img-6.jpg')]
        ];

        foreach ($data as $item) {
            $item['type'] = Type::FAQ_STYLE_TWO;
            Section::create($item);
        }
    }

    public function ClientReview()
    {
        Section::create([
            'type'  =>  Type::CLIENT_REVIEW,
            'key'   =>  'short_title',
            'value' =>  'Reviews'
        ]);

        Section::create([
            'type'  =>  Type::CLIENT_REVIEW,
            'key'   =>  'title',
            'value' =>  'Client Reviews'
        ]);

        Section::create([
            'type'  =>  Type::CLIENT_REVIEW,
            'key'   =>  'description',
            'value' =>  'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Finibus Bonorum et Malorum'
        ]);
    }

    public function Blogs()
    {
        $data = [
            ['key' => 'short_title',            'value' => 'Blogs'],
            ['key' => 'title',                  'value' => 'Latest Blogs'],
            ['key' => 'short_description',      'value' => 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Finibus Bonorum et Malorum'],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::BLOGS;
            Section::create($item);
        }
    }

    public function Clients()
    {
        $data = [
            ['key' => 'short_title',            'value' => 'Clients'],
            ['key' => 'title',                  'value' => 'Trusted by Our Clients'],
            ['key' => 'short_description',      'value' => 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Finibus Bonorum et Malorum'],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::CLIENT_SECTION;
            Section::create($item);
        }
    }

    public function Signin()
    {
        Section::create([
            'type'  => Type::SIGNIN,
            'key'   => 'singin_image',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/tracking-image-2.jpg"),
        ]);
    }

    public function Signup()
    {
        Section::create([
            'type'  => Type::SIGNUP,
            'key'   => 'signup-image',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/tracking-image-3.jpg"),
        ]);
    }

    public function Breadcrumb()
    {
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'breadcrumb-image',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/breadcrumb.jpg"),
        ]);

        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'aboutus-title',
            'value' => 'About Us'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'blog-title',
            'value' => 'Lates Blogs'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'blog-single-title',
            'value' => 'Blogs'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'service-single-title',
            'value' => 'Services'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'contactus-title',
            'value' => 'Contact Us'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'privacy-return-title',
            'value' => 'Privacy & Return'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'terms-conditions-title',
            'value' => 'Terms & Conditions'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'signin-title',
            'value' => 'Sign In'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'signup-title',
            'value' => 'Sign Up'
        ]);
        Section::create([
            'type'  => Type::BREADCRUMB,
            'key'   => 'track-title',
            'value' => 'Tracking Parcel'
        ]);
    }

    public function DeliveryCalculator()
    {
        $data = [
            ['key' => 'section_tagline',         'value' => 'Delivery Calculator'],
            ['key' => 'section_title',           'value' => 'Calculate your parcel & easy to delivery in Bangla.'],
            ['key' => 'description',             'value' => 'Parcel Fly is a complete platform for end-to-end delivery and logistics services for any business or personal needs. The services include parcel delivery, bulk shipment, line hall, truck rental, loading-unloading, warehouse, logistics services and customized solutions as required.<ul><li>✅ 24 Hours Support</li><li>✅ Deliver in 2-3 days</li><li>✅ Customer Management</li></ul>'],
            ['key' => 'image',                   'value' => $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/delivery-man-2.png')],
            ['key' => 'progress_value',          'value' => '95%'],
            ['key' => 'progress_title',          'value' => 'Supper <br> Fast Delivery'],
            ['key' => 'button_text',             'value' => 'More Details'],
            ['key' => 'button_url',              'value' => 'https://bugbuild.com/'],
            // Calculator specific data
            ['key' => 'calculator_tagline',      'value' => 'GET FREE QUOTE'],
            ['key' => 'calculator_title',        'value' => 'Calculate Your Delivery'],
            ['key' => 'calculator_button_text',  'value' => 'Calculate Now'],

        ];

        foreach ($data as $item) {
            $item['type'] = Type::DELIVERY_CALCULATOR;
            Section::create($item);
        }
    }

    public function DeliveryCalculatorTwo()
    {
        $data = [
            ['key' => 'section_tagline',         'value' => 'Delivery Calculator'],
            ['key' => 'section_title',           'value' => 'Calculate your parcel & easy to delivery in Bangla.'],
            ['key' => 'description',             'value' => 'Parcel Fly is a complete platform for end-to-end delivery and logistics services for any business or personal needs. The services include parcel delivery, bulk shipment, line hall, truck rental, loading-unloading, warehouse, logistics services and customized solutions as required.<ul><li>✅ 24 Hours Support</li><li>✅ Deliver in 2-3 days</li><li>✅ Customer Management</li></ul>'],
            ['key' => 'image',                   'value' => $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/delivery-man-2.jpeg')],
            ['key' => 'background_image',                   'value' => $this->uploadRepo->uploadSeederByPath('frontend/assets/img/logistics-img/ship-2.jpg')],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::DELIVERY_CALCULATOR_TWO;
            Section::create($item);
        }
    }

    public function ChargeList()
    {
        $data = [
            ['key' => 'title',                      'value'   => 'Charge List'],
            ['key' => 'short_description',          'value'   => 'Charge List'],
            ['key' => 'description',                'value'   => 'A Charge List is a detailed document or table that outlines the costs or fees associated with various services or items provided by an organization.'],

        ];

        foreach ($data as $item) {
            $item['type'] = Type::CHARGE_LIST;
            Section::create($item);
        }
    }


    public function CoverageArea()
    {
        $data = [
            ['key' => 'title',                          'value' => 'We deliver your parcel all over the Bangladesh'],
            ['key' => 'short_title',                    'value' => 'Area'],
            ['key' => 'short_description',              'value' => 'Delivery your package quickly cheaply and easily only here, We prioritize the safety of your package with provides support in all 64 districts in Bangladesh.'],
            ['key' => 'bg_image',                       'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/coverage.png")],
            ['key' => 'big_bg_image',                   'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/choose.jpg")],

            ['key' => 'coverage_list_title',            'value' => 'Area List'],

            ['key' => 'card_title_one',                 'value' => '24/7 Support'],
            ['key' => 'card_one_description',           'value' => 'Pellentesque ut vulputate arcu. Sed suscipit est sit amet'],
            ['key' => 'card_one_image',                   'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/4.png")],

            ['key' => 'card_title_two',                  'value' => 'Fast Delivery'],
            ['key' => 'card_two_description',           'value' => 'Pellentesque ut vulputate arcu. Sed suscipit est sit amet'],
            ['key' => 'card_two_image',                   'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/3.png")],

            ['key' => 'card_title_three',                'value' => 'Cash On Delivery'],
            ['key' => 'card_three_description',         'value' => 'Pellentesque ut vulputate arcu. Sed suscipit est sit amet'],
            ['key' => 'card_three_image',                 'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/2.png")],

            ['key' => 'card_title_four',                 'value' => 'Dropshipping'],
            ['key' => 'card_four_description',          'value' => 'Pellentesque ut vulputate arcu. Sed suscipit est sit amet'],
            ['key' => 'card_four_image',                  'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/1.png")],
        ];

        foreach ($data as $item) {
            $item['type'] = Type::COVERAGE_AREA;
            Section::create($item);
        }
    }

    public function CTA()
    {
        Section::create([
            'type' => Type::CTA,
            'key'  => 'short_title',
            'value' => 'Sign up with ParcelFly as a merchant'
        ]);

        Section::create([
            'type' => Type::CTA,
            'key'  => 'title',
            'value' => 'Start delivering products using ParcelFly courier'
        ]);

        Section::create([
            'type' => Type::CTA,
            'key'  => 'cta-bg-image',
            'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/section/hero-on-bike.png"),
        ]);
    }
    public function THEME_APPEARANCE()
    {
        Section::create([
            'type' => Type::THEME_APPEARANCE,
            'key'  => 'font_family_heading',
            'value' => "'Poppins', sans-serif"
        ]);

        Section::create([
            'type' => Type::THEME_APPEARANCE,
            'key'  => 'font_family_body',
            'value' => "'Roboto', sans-serif"
        ]);

        Section::create([
            'type' => Type::THEME_APPEARANCE,
            'key'  => 'primary_color',
            'value' => '#FFA500'
        ]);

        Section::create([
            'type' => Type::THEME_APPEARANCE,
            'key'  => 'primary_text_color',
            'value' => '#18333b'
        ]);

        Section::create([
            'type' => Type::THEME_APPEARANCE,
            'key'  => 'secondary_text_color',
            'value' => '#67797e'
        ]);

        Section::create([
            'type' => Type::THEME_APPEARANCE,
            'key'  => 'button_input_style',
            'value' => 'square', // rounded, square
        ]);
    }



    public function popups_content()
    {
        $data = [
            ['key' => 'cookie_concent', 'value' => '<p class="text-muted my-2">We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking <strong>Accept</strong>, you consent to our use of cookies. Read our <a href="/privacy-return" class="text-decoration-underline" target="_blank" rel="noopener noreferrer">Privacy Policy</a> for more information.</p>'],

        ];

        foreach ($data as $item) {
            $item['type'] = Type::POPUP_CONTENT;

            Section::create($item);
        }
    }
}
