@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="card mt-2">
        
            <div class="card-body">
            
                <form action="/posts/{{$post->id}}/update" method="POST">
                    @csrf 
                    {{ method_field('PATCH') }}
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" value="{{$post->title}}">
                    </div>

                    <div class="form-group">
                        <input type="text" name="body" class="form-control" value="{{$post->body}}">
                    </div>

                    <div class="form-group">
                        <input type="submit" value="update" class="btn btn-info">
                    </div>
                </form>

                @include('errors')
            </div>
        
        </div>

    </div>

@endsection
