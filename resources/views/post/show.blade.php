@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="card mt-2">
        
            <div class="card-body">
            
                <h1 class="card-title display-4">

                    {{ $post->title }}

                </h1>
                <p> <small> {{$post->user->name}} | {{$post->created_at->format('Y-m-d')}} </small> </p>
                <p>

                    {{$post->body}}

                </p>
                
                <hr>

                @if($post->image != null)
                    <img src="/storage/imgs/{{$post->image}}" alt="img" width="100px" height="100px" class="m-2">
                @endif

                <!-- like -->
                <button class="btn btn-success {{ ($liked) ? 'unlike' : 'like' }}" id="POST-LIKE" data-post-id="{{$post->id}}" > <small>{{ $post->likes->count() }}</small> <span> {{ ($liked) ? 'unlike' : 'like' }}</span></button>
                
                <!-- Subscribe -->
                <button class="btn btn-success {{ ($subscribed) ? 'unsubscribe' : 'subscribe' }}" id="POST-SUBSCRIBE" data-post-id="{{$post->id}}">{{ ($subscribed) ? 'unsubscribe' : 'subscribe' }}</button>

                <hr>

                @auth
                    @if( auth()->id() == $post->user->id )
                        <form action="/posts/{{$post->id}}" method="post" class="d-inline"> 
                            @csrf 
                            {{ method_field('DELETE') }} 
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <a href="/posts/{{$post->id}}/edit" class="btn btn-info btn-sm text-light">Edit</a>
                    @endif
                @endauth
            </div>
        
        </div>
        
        <hr>

        <h1>Comments</h1>

        <form id="AddCommentForm">
            <input type="text" class="form-control d-inline w-75 mr-2" name="body" placeholder="Comment">
            <button type="submit" data-post-id="{{$post->id}}" class="btn btn-primary mb-2">Add</button>
        </form>

        <div class="d-block">
            @include('errors')
        </div>

        <ul class="list-group" id="COMMENTS-LIST">
            @foreach($comments as $comment)
                <li class="list-group-item">
                    {{ $comment->body }} ...
                    <small> By: {{ $comment->user->name }} </small>
                    <small> at: {{ $comment->created_at->format('Y-m-d') }} </small>
                </li>
            @endforeach
        </ul>
            
            @if($comments->lastPage() > 1)
            <a href="" id="COMMENTS-LOAD-MORE" data-comments-lastpage="{{ $comments->lastPage() }}" data-post-id="{{ $post->id }}" class="card-link">Load more</a>
            @endif
            
    </div>


@endsection
