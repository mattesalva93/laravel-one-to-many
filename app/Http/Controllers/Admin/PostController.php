<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datoValidato = $request->validate([
            'title' => 'required | string',
            'content' => 'required',
            'category_id' => 'nullable',
            'image' => 'nullable | image | mimes:jpg,bmp,png,jpeg'
        ]);

        $slugTemporaneo = Str::slug($datoValidato['title']);
        $contatore  = 1;
        while(Post::where('slug', $slugTemporaneo)->first()){
            $slugTemporaneo = Str::slug($datoValidato['title'])."-".$contatore;
            $contatore++;
        }
        $datoValidato['slug'] = $slugTemporaneo;
        
        if(isset($datoValidato["image"])){
            $img_path = Storage::put('uploads', $datoValidato['image']);
            $datoValidato['image'] = $img_path;
        }


        $post = new Post();

        $post->fill($datoValidato);
        $post->save();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post )
    {
        $datoValidato = $request->validate([
            'title' => 'required | string',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable | image | mimes:jpg,bmp,png,jpeg'
        ]);

        if($post->title == $datoValidato['title']){
            $slug = $post->slug;
        }else{
            $slug = Str::slug($datoValidato['title']);
            $contatore  = 1;
            while(Post::where('slug', $slug)->where('id', '!=', $post->id)->first()){
                $slug = Str::slug($datoValidato['title'])."-".$contatore;
                $contatore++;
            }
        }
        $datoValidato['slug'] = $slug;
        
        if(isset($datoValidato["image"])){
            $img_path = Storage::put('uploads', $datoValidato['image']);
            $datoValidato['image'] = $img_path;
        }

        $post->update($datoValidato);

        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
