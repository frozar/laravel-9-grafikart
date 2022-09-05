<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Throwable;

class PostsController extends Controller
{
    protected function retry(callable $callback)
    {
        $nbRetry = 10;
        $delay = 100;
        return retry($nbRetry, $callback, $delay);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return $this->retry(function ($attempts) {
                $posts = Post::all();
                return view("posts.index", compact("posts"));
            });
        } catch (Throwable $e) {
            $response = view("posts.index", ["posts" => []]);
            $exceptionMessage = "[" . get_class($e) . "] " . $e->getMessage();
            Session::flash("error", $exceptionMessage);
            return $response;
        }
        // $posts = Post::get();

        // return view("posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $post = $this->retry(function ($attempts) use ($request) {
                return Post::create($request->all());
            });
            return redirect(route("news.edit", $post));
        } catch (Throwable $_) {
            // $article = route('post.show', $post);
            // dd($e->message);
            return back()->with("error", "Echec de création : Article non créé.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $post = $this->retry(function ($attempts) use ($id) {
                return Post::findOrFail($id);
            });

            return view("posts.edit", compact('post'));
        } catch (Throwable $_) {
            $article = route('post.show', $post);
            return back()->with("error", "Echec de l'édition : Article $article introuvable.");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $post = $this->retry(function ($attempts) use ($id) {
                return Post::findOrFail($id);
            });
            $this->retry(function ($attempts) use ($post, $request) {
                $post->update($request->all());
            });
            return redirect(route("news.edit", $id));
        } catch (Throwable $_) {
            $article = route('news.show', ['id' => $id]);
            return to_route("news.index")->with("error", "Echec de la mis à jour de l'article $article");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
