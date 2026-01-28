<?php

namespace App\Enums;

enum FontFamily: string

{
    case   InterSansSerif          = "'Inter', sans-serif";
    case   RobotoSansSerif         = "'Roboto', sans-serif";
    case   PoppinsSansSerif        = "'Poppins', sans-serif";
    case   OswaldSansSerif         = "'Oswald', sans-serif";
    case   PlayfairDisplaySerif    = "'Playfair Display', serif;";

    public function label(): string
    {
        return match($this) {
            self::InterSansSerif => 'Inter, sans-serif',
            self::RobotoSansSerif => 'Roboto, sans-serif',
            self::PoppinsSansSerif => 'Poppins, sans-serif',
            self::OswaldSansSerif => 'Oswald, sans-serif',
            self::PlayfairDisplaySerif => 'Playfair Display, serif',
        };
    }

}
