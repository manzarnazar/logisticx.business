<?php

namespace Modules\Section\Traits;

use Modules\Section\Enums\Type;

trait SectionTrait
{
    public function SectionType($type = null)
    {
        switch ($type) {
            // case Type::SOCIAL_LINK:
            //     $type = ___('label.social_link');
            //     break;
            // case Type::HEADER:
            //     $type = ___('label.Header');
            //     break;

            // case Type::COUNT:
            //     $type = ___('label.Counter');
            //     break;

            case Type::CONTACT_US:
                $type = ___('label.Contact Us');
                break;
            case Type::HERO_SECTION:
                $type = ___('label.Hero Section');
                break;
            case Type::ABOUT_US:
                $type = ___('label.About Us');
                break;
            case Type::OUR_ACHIEVEMENT:
                $type = ___('label.Our Achievement');
                break;
            case Type::OUR_ACHIEVEMENT_TWO:
                $type = ___('label.Our Achievement Two');
                break;
            case Type::OUR_BEST_SERVICE:
                $type = ___('label.Our Best Service');
                break;
            case Type::FAQ:
                $type = ___('label.FAQs');
                break;
            case Type::FAQ_STYLE_TWO:
                $type = ___('label.FAQs Style Two');
                break;
            case Type::CLIENT_REVIEW:
                $type = ___('label.Client Review/Testimonials');
                break;
            case Type::BLOGS:
                $type = ___('label.Blogs');
                break;
            case Type::CLIENT_SECTION:
                $type = ___('label.Client Section');
                break;
            case Type::SIGNIN:
                $type = ___('label.Signin');
                break;
            case Type::SIGNUP:
                $type = ___('label.Signup');
                break;
            case Type::BREADCRUMB:
                $type = ___('label.Breadcrumb');
                break;

            case Type::DELIVERY_CALCULATOR:
                $type = ___('label.Delivery Calculator');
                break;

            case Type::DELIVERY_CALCULATOR_TWO:
                $type = ___('label.Delivery Calculator Style Two');
                break;

            case Type::CHARGE_LIST:
                $type = ___('label.Charge List');
                break;

            case Type::COVERAGE_AREA:
                $type = ___('label.Coverage Area');
                break;
            case Type::CTA:
                $type = ___('label.CTA');
                break;

            case Type::POPUP_CONTENT:
                $type = ___('label.popups_content');
                break;
            case Type::HOW_WE_WORK:
                $type = ___('label.how_we_works');
                break;
        }
        return $type;
    }
}
