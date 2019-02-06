@extends('layouts.app')

@section('content')

    <div class="container">

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

            </div>
        
        </div>
        
        @endforeach

        {{ $posts->links() }}

    </div>

@endsection
