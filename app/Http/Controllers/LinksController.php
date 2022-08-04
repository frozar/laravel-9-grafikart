<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Throwable;

class LinksController extends Controller
{
    public function index()
    {
        $links = Link::all();
        return view("links.index", compact("links"));
    }

    public function show($id)
    {
        try {
            $link = Link::findOrFail($id);
            return redirect($link->url, 301);
        } catch (Throwable $_) {
            $shortcut = route('link.show', ['link' => $id]);
            return back()->with("error", "Echec de la redirection : Raccourci $shortcut introuvable.");
        }
    }

    public function store()
    {
        $url = request()->get("url");
        $link = Link::firstOrCreate(["url" => $url]);

        return view("links.success", compact('link'));
    }

    public function destroy($id)
    {
        try {
            $link = Link::findOrFail($id);
            Link::destroy($link->id);
            return redirect(route("link.index"), 301)->with("info", "Raccourci de $link->url supprimé");
        } catch (Throwable $_) {
            $shortcut = route('link.show', ['link' => $id]);
            return back()->with("error", "Echec de la suppression : Raccourci $shortcut introuvable.");
        }
    }

    public function edit($id)
    {
        try {
            $link = Link::findOrFail($id);
            return view("links.edit", compact('link'));
        } catch (Throwable $_) {
            $shortcut = route('link.show', ['link' => $id]);
            return back()->with("error", "Echec de l'édition : Raccourci $shortcut introuvable.");
        }
    }

    public function update($id)
    {
        try {
            $link = Link::findOrFail($id);
            $newUrl = request()->get("url");
            $url = $link->url;

            // If update has to be done
            if (strcmp($newUrl, $url) != 0) {
                $link->update(["url" => $newUrl]);
                $shortcut = route('link.show', compact('link'));
                return to_route("link.index")->with("info", "Raccourci $shortcut à jour.");
            } else {
                return to_route("link.index");
            }
        } catch (Throwable $_) {
            $shortcut = route('link.show', ['link' => $id]);
            return to_route("link.index")->with("error", "Echec de la mis à jour : Raccourci $shortcut introuvable.");
        }
    }
}
