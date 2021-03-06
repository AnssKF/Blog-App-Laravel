@extends('layouts.app')

@section('content')

    <div class="container">

        @auth
        <!-- subscribe -->
        <button class="btn btn-success btn-block {{ ($subscribed) ? 'unsubscribe' : 'subscribe' }}" id="CATEGORY-SUBSCRIBE" data-category-id="{{$category->id}}">{{ ($subscribed) ? 'unsubscribe from category' : 'subscribe to this category' }}</button>

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
