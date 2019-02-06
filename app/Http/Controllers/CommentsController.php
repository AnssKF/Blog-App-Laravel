<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

use App\Post;
use App\Mail\CommentAdded;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post)
    {
        $this->validate(request(),[
            'body' => 'required'
        ]);

        $comment = $post->comments()->create([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        
        \Mail::to($post->subscribers)->send( new CommentAdded($post) );

        return [ 
            'user_name' => $comment->user->name,
            'created_at' => $comment->created_at->format('Y-m-d')
        ];
    }

    public function getMoreComments(Post $post){
        // $comments = $post->comments()->latest()->with('user')->paginate(3);
        $page = request('page');
        $skip = request('skip');
        $comments = $post->comments()->latest()->with('user')->skip(($page*5)-5+$skip)->take(5)->get();
        return $comments;
        return $comments;
    }
}
