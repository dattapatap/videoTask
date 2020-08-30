<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){        
        $users = User::where('role', 2)->orderBy('id','DESC')->get();
        return view('admin.index',compact('users',$users));
    }

    public function getUserForm(){
        return view('admin.addUser');
    }

    public function store(Request $request){
         $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);   
    
        User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role'=> 2,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $users = User::where('role', 2)->orderBy('id','DESC')->get();
        return view('admin.index',compact('users',$users));
    }


    public function deleteUser(Request $request){
        $id = $request->id;
        User::find($id)->delete();
        $request->session()->flash('message', 'Successfully deleted the user!');
        $users = User::where('role', 2)->orderBy('id','DESC')->get();
        return view('admin.index',compact('users',$users));
    }


}
