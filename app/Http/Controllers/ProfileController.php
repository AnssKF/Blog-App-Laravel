<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('profile.index');
    }

    public function store(){
        $this->validate(request(),[
            "name" => "required|min:2|max:191",
            "email" => "required|email|min:2|max:191|unique:Users,email,".auth()->id(),
            "password" => "confirmed"
        ]);

        $user = auth()->user();

        $user->update([
            "name" => request('name'),
            "email" => request('email')
        ]);

        if(request('password') != null){
            $user->password = bcrypt(request('password'));
            $user->save();
        }

        return back()->with('updated-successfully',
        'Profile Updated');
    }

}
