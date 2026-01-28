<?php

namespace Modules\Pages\Database\Seeders;

use DB;
use App\Enums\Status;
use Faker\Factory as Faker;
use App\Models\Backend\Upload;
use Illuminate\Database\Seeder;
use Modules\Pages\Entities\Page;
use Illuminate\Database\Eloquent\Model;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();



        $row                = new Page();
        $row->page          = 'about_us';
        $row->title         = 'About us';
        $row->description   = $this->about_us();
        $row->status        = Status::ACTIVE;
        $row->save();

        $row                = new Page();
        $row->page          = 'privacy_policy';
        $row->title         = 'Privacy Policy';
        $row->description   = $this->privacy_return();
        $row->status        = Status::ACTIVE;
        $row->save();

        $row                = new Page();
        $row->page          = 'terms_conditions';
        $row->title         = 'Terms Conditions';
        $row->description   = $this->terms_conditions();
        $row->status        = Status::ACTIVE;
        $row->save();
    }

    private function terms_conditions()
    {
        return  "
        <div>
            <h1>Terms and Conditions</h1>
            <p>
                Welcome to Parcel Fly! These terms and conditions outline the rules and regulations for the use of Parcel Fly's Website, located at www.parcelfly.com.
            </p>
            <p>
                By accessing this website we assume you accept these terms and conditions. Do not continue to use Parcel Fly if you do not agree to take all of the terms and conditions stated on this page.
            </p>
            <p>
                The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: 'Client', 'You' and 'Your' refers to you, the person log on this website and compliant to the Company’s terms and conditions. 'The Company', 'Ourselves', 'We', 'Our' and 'Us', refers to our Company. 'Party', 'Parties', or 'Us', refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.
            </p>
            <h2>Cookies</h2>
            <p>
                We employ the use of cookies. By accessing Parcel Fly, you agreed to use cookies in agreement with the Parcel Fly's Privacy Policy.
            </p>
            <p>
                Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.
            </p>
            <h2>License</h2>
            <p>
                Unless otherwise stated, Parcel Fly and/or its licensors own the intellectual property rights for all material on Parcel Fly. All intellectual property rights are reserved. You may access this from Parcel Fly for your own personal use subjected to restrictions set in these terms and conditions.
            </p>
            <p>
                You must not:
                <ul>
                    <li>Republish material from Parcel Fly</li>
                    <li>Sell, rent or sub-license material from Parcel Fly</li>
                    <li>Reproduce, duplicate or copy material from Parcel Fly</li>
                    <li>Redistribute content from Parcel Fly</li>
                </ul>
            </p>
            <p>
                This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the Terms And Conditions Generator and the Privacy Policy Generator.
            </p>
        </div>    ";
    }

    private function privacy_return()
    {
        return   "
        <div>
            <h1>Privacy Policy</h1>
            <p>
                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
            </p>
            <p>
                If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour.
            </p>
        </div>
        <div>
            <h1>Return Policy</h1>
            <p>
                There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
            </p>
            <p>
                If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour.
            </p>
        </div>    ";
    }

    private function about_us()
    {
        return " <div>
        <h1>About Parcel Fly</h1>
        <p>
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
        </p>
        <h2>Our Success</h2>
        <p>
            If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
        </p>
        <p>
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc. you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
        </p>
        <p>
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful. Lorem Ipsum is therefore always free from repetition
        </p>
        <h2>Our Service</h2>
        <p>
            There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.
        </p>
        </div>";
    }
}
