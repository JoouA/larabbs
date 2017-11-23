<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root()
    {
//        dd('hello world');
        return view('pages.root');
    }
}
