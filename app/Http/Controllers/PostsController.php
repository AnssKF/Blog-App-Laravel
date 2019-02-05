<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Post;
use App\Like;
use App\Subscriber;
use App\Category;
use Illuminate\Http\Request;

use App\Mail\PostAdded;

class PostsController extends Controller
{


    public function __construct(){
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        $categories = Category::all();
        return view('post.index', compact('posts','categories'));
    }


    public function showCategory(Category $category){
        $posts = $category->posts;
        $subscribed = ($category->subscribers->where('id','=',auth()->id()))->count();        
        return view('post.category',compact('posts','category','subscribed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'title' => 'required|min:3',
            'body' => 'required|min:3'
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('public/imgs');
        }

        $post = Post::create([
            'title' => $request['title'],
            'body' => $request['body'],
            'image' => ($request->hasFile('image')) ? $request->file('image')->hashName() : null,
            'user_id' => auth()->id(),
            'category_id' => $request['category_id']
        ]);

        \Mail::to($post->category->subscribers)->send( new PostAdded($post) );        

        return redirect()->route('postsPage');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->get();
        $liked = ($post->likes->where('user_id','=',auth()->id()))->count();
        $subscribed = ($post->subscribers->where('id','=',auth()->id()))->count();
        return view('post.show',compact(['post','comments','liked','subscribed']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        $this->validate(request(),[
            'title' => 'required',
            'body' => 'required'
        ]);

        $post->update([
            'title' => request('title'),
            'body' => request('body')
        ]);
        return redirect("posts/$post->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('postsPage');
    }

}
