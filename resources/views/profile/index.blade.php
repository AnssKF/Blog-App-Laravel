@extends('layouts.app')

@section('content')

    <div class="container">

        @auth


        <div class="card mt-2">
        
            <div class="card-body">
            
                @if(\Session::has('updated-successfully'))
                    <div class="alert alert-success">
                        {{ \Session::get('updated-successfully') }}
                    </div>
                @endif

                @include('errors')
                <form action="/profile" method="POST">
                    @csrf

                    <div class="form-group">
                    <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" value="{{ auth()->user()->email }}">
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password confirmation">
                    </div>
                
                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-info text-light" value="update">
                    </div>


                </form>

            </div>
        
        </div>


        @endauth

    </div>

@endsection
