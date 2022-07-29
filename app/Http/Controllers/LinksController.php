<?php

namespace App\Http\Controllers;

use App\Models\Link;

// use Illuminate\Http\RedirectResponse;

class LinksController extends Controller
{
    // public function show($id)
    // {
    //     $link = Link::findOrFail($id);
    //     // return new RedirectResponse($link->url, 301);
    //     return redirect($link->url, 301);
    // }

    public function show($id)
    {
        $link = Link::findOrFail($id);
        // return new RedirectResponse($link->url, 301);
        return redirect($link->url, 301);
    }

    public function create()
    {
        return view("links.create");
    }

    public function store()
    {
        // dd(request()->get("url"));
        $url = request()->get("url");

        // $link = Link::where("url", $url)->first();
        // if (!$link) {
        //     $link = Link::create(compact('url'));
        // }

        $link = Link::firstOrCreate(["url" => $url]);

        // dd($link);
        return view("links.success", compact('link'));
    }
}
