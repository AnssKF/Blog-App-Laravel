@extends('layouts.app')

@section('content')

    <div class="container">

        @auth
        @include('errors')
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <h6>New Post</h6>
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Title">
            </div>
            <div class="form-group">
                <textarea name="body" class="form-control" placeholder="Post body"></textarea>
            </div>

            <div class="form-group">
                <label>upload image</label>
                <input type="file" name="image" class="form-control-file">
            </div>

            <div class="form-group">
                <label>Select Category</label>
                <select name="category_id" class="form-control">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Post" class="btn btn-block btn-info text-light">
            </div>


        </form>

        <hr>
        @endauth

        @foreach($posts as $post)

        <div class="card mt-2">
        
            <div class="card-body">
            
                <a href="/posts/{{$post->id}}" class="card-title text-dark display-4">

                    {{ $post->title }}

                </a>
                <p> <small> {{$post->user->name}} | {{$post->created_at->format('Y-m-d')}} | {{$post->category->name}} </small> </p>
                <p>

                    {{$post->body}}

                </p>

                @if($post->image != null)
                    <img src="/storage/imgs/{{$post->image}}" alt="img" width="100px" height="100px" class="m-2">
                @endif 

            </div>
        
        </div>
        
        @endforeach

    </div>

@endsection
