<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Comment;
use App\Like;
use App\Category;

class Post extends Model
{
    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function subscribers(){
        return $this->belongsToMany(User::class, 'subscribers');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
