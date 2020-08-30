<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Video;

class UserController extends Controller
{
    
    public function index(){

        $video = Video::all();
        return view('users.index',compact('video',$video));
    }


}
