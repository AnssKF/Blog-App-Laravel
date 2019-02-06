<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Category;

class SubscriptionController extends Controller
{
    public function postSubscribe(Post $post){
        $post->subscribers()->attach(auth()->id());
        return ['status'=>true];
    }
    
    public function postUnSubscribe(Post $post){
        $post->subscribers()->detach(auth()->id());
        return ['status'=>true];
    }

    public function categorySubscribe(Category $category){
        $category->subscribers()->attach(auth()->id());
        return ['status'=>true];
    }


    public function categoryUnSubscribe(Category $category){
        $category->subscribers()->detach(auth()->id());
        return ['status'=>true];
    }
}
