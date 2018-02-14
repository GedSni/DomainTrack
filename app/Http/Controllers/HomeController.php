<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function privacy() {
        return view('privacy');
    }

    public function support() {
        return view('support');
    }

    public function terms() {
        return view('terms');
    }
}
