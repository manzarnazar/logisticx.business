<?php

namespace App\Enums;

enum SectionPadding: string

{
    // case   NONE         = 'none';
    // case   PADDING_50   = "padding-50";
    // case   PADDING_80   = "padding-80";
    // case   PADDING_100  = "padding-100";
    // case   PADDING_120  = "padding-120";
    // case   PADDING_150  = "padding-150";
    
    // case   PADDING_TOP_50   = "padding-top-50";


    case   NONE                 = 'py-0';
    case   PADDING_50           = 'py-50';
    case   PADDING_80           = 'py-80';
    case   PADDING_100          = 'py-100';
    case   PADDING_120          = 'py-120';
    case   PADDING_150          = 'py-150';

    case   PADDING_TOP_NONE     = 'pt-0';
    case   PADDING_TOP_50       = 'pt-50';
    case   PADDING_TOP_80       = 'pt-80';
    case   PADDING_TOP_100      = 'pt-100';
    case   PADDING_TOP_120      = 'pt-120';
    case   PADDING_TOP_150      = 'pt-150';
 
    case   PADDING_BOTTOM_NONE  = 'pb-0';
    case   PADDING_BOTTOM_50    = 'pb-50';
    case   PADDING_BOTTOM_80    = 'pb-80';
    case   PADDING_BOTTOM_100   = 'pb-100';
    case   PADDING_BOTTOM_120   = 'pb-120';
    case   PADDING_BOTTOM_150   = 'pb-150';



    public function label(): string
    {
        return match($this) {
            self::NONE => 'No Padding',
            self::PADDING_50 => '50px Padding',
            self::PADDING_80 => '80px Padding',
            self::PADDING_100 => '100px Padding',
            self::PADDING_120 => '120px Padding',
            self::PADDING_150 => '150px Padding',
            self::PADDING_TOP_NONE => '0px Top Padding',
            self::PADDING_TOP_50 => '50px Top Padding',
            self::PADDING_TOP_80 => '80px Top Padding',
            self::PADDING_TOP_100 => '100px Top Padding',
            self::PADDING_TOP_120 => '120px Top Padding',
            self::PADDING_TOP_150 => '150px Top Padding',
            self::PADDING_BOTTOM_NONE => '0px Bottom Padding',
            self::PADDING_BOTTOM_50 => '50px Bottom Padding',
            self::PADDING_BOTTOM_80 => '80px Bottom Padding',
            self::PADDING_BOTTOM_100 => '100px Bottom Padding',
            self::PADDING_BOTTOM_120 => '120px Bottom Padding',
            self::PADDING_BOTTOM_150 => '150px Bottom Padding',
            // Uncomment the following lines if you want to use the old labels
            
            // self::NONE => 'No Padding',
            // self::PADDING_50 => '50px Padding',
            // self::PADDING_80 => '80px Padding',
            // self::PADDING_100 => '100px Padding',
            // self::PADDING_120 => '120px Padding',
            // self::PADDING_150 => '150px Padding',

            // self::PADDING_TOP_50 => '50px Top Padding',
        };
    }

}
