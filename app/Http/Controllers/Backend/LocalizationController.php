<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Modules\Language\Entities\Language;

class LocalizationController extends Controller
{
    public function setLocalization($language)
    {
        // Validate if the language exists in the database
        if (!Language::where('code', $language)->exists()) {
            abort(400, 'Unsupported language');
        }

        App::setLocale($language);              // Set and persist the locale in the app

        session()->put('locale', $language);    // Store the selected language in the session for the current user

        $cookie = cookie(
            name: 'locale',
            value: $language,   // Use the language passed in
            minutes: 525600,    // 1 year
            secure: true,       // Only over HTTPS
            httpOnly: true,     // Accessible only via HTTP (not JavaScript)
            sameSite: 'Lax'     // Lax: allows same-site navigation but restricts cross-site subrequests
        );

        Cookie::queue($cookie);  // Queue the cookie for the response

        return redirect()->back(); // Return the response
    }
}
