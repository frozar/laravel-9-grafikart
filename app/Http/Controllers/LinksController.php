<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;

class LinksController extends Controller
{
    protected function retry(callable $callback)
    {
        $nbRetry = 10;
        $delay = 100;
        return retry($nbRetry, $callback, $delay);
    }

    public function index(Request $request)
    {
        try {
            return $this->retry(function ($attempts) {
                $links = Link::all();
                return view("links.index", compact("links"));
            });
        } catch (Throwable $e) {
            $response = view("links.index", ["links" => []]);
            $exceptionMessage = "[" . get_class($e) . "] " . $e->getMessage();
            Session::flash("error", $exceptionMessage);
            return $response;
        }
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

    public function store(Request $request)
    {
        try {
            $this->retry(function ($attempts) use ($request) {
                $request->validate([
                    'url' => 'required|url|active_url|unique:App\Models\Link,url',
                ]);
            });

            $url = $request->get("url");
            $link = $this->retry(function ($attempts) use ($url) {
                return Link::create(["url" => $url]);
            });
            return back()->with("info", "Nouveau raccourci " . route('link.show', compact('link')));
        } catch (Throwable $e) {
            $exceptionMessage = "[" . get_class($e) . "] " . $e->getMessage();
            return back()->with("error", $exceptionMessage);
        }
    }

    public function destroy($id)
    {
        try {
            $link = $this->retry(function ($attempts) use ($id) {
                return Link::findOrFail($id);
            });

            return $this->retry(function ($attempt) use ($link) {
                Link::destroy($link->id);
                return redirect(route("link.index"), 301)->with("info", "Raccourci de $link->url supprimé");
            });
        } catch (Throwable $_) {
            Log::debug("destroy failed");
            $shortcut = route('link.show', ['link' => $id]);
            return back()->with("error", "Echec de la suppression du raccourci $shortcut.");
        }
    }

    public function edit($id)
    {
        try {
            $link = $this->retry(function ($attempts) use ($id) {
                return Link::findOrFail($id);
            });

            return view("links.edit", compact('link'));
        } catch (Throwable $_) {
            $shortcut = route('link.show', ['link' => $id]);
            return back()->with("error", "Echec de l'édition : Raccourci $shortcut introuvable.");
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->retry(function ($attempts) use ($request) {
                $request->validate([
                    'url' => 'required|url|active_url|unique:App\Models\Link,url',
                ]);
            });

            $link = $this->retry(function ($attempts) use ($id) {
                return Link::findOrFail($id);
            });
            $newUrl = request()->get("url");
            $url = $link->url;

            // If update has to be done
            if (strcmp($newUrl, $url) != 0) {
                $this->retry(function ($attempts) use ($link, $newUrl) {
                    $link->update(["url" => $newUrl]);
                });

                $shortcut = route('link.show', compact('link'));
                return to_route("link.index")->with("info", "Raccourci $shortcut à jour.");
            } else {
                return to_route("link.index");
            }
        } catch (Throwable $_) {
            $shortcut = route('link.show', ['link' => $id]);
            return to_route("link.index")->with("error", "Echec de la mis à jour du raccourci $shortcut");
        }
    }
}
