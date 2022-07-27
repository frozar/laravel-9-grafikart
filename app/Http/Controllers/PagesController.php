<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function about()
    {
        // return "A propos de moi";
        $title = "A propos";
        // $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        $numbers = [];
        return view("pages/about", compact("title", "numbers"));
    }
}
