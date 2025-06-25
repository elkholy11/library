<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function setLang(Request $request, $locale)
    {
        if (in_array($locale, ['ar', 'en'])) {
            Session::put('locale', $locale);
        }
        return redirect()->back();
    }
}
