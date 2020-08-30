<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

use App\Video;

class VideoController extends Controller
{
    public function getAllVideo(){
        $video = Video::all();
        return view('admin.videoList',compact('video',$video));
    }

    public function getVideoForm(){
        return view('admin.addVideos');
    }
  

    public function store(Request $request){

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1055'],
            'image' => ['required', 'image'],
            'watermark' => ['required', 'image'],
            'video' => ['required', 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required'],
        ]);   
        if($request->hasFile('image') && $request->hasFile('watermark') && $request->hasFile('video')){

            $image= $request->image->getClientOriginalName();
            $watermark = $request->watermark->getClientOriginalName();
            $video = $request->video->getClientOriginalName();

            $request->image->storeAs('images',$image,'public');
            $request->watermark->storeAs('watermark',$watermark,'public');
            $request->video->storeAs('video',$video,'public');
            Video::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'image'=> $image,
                'watermark' => $watermark,
                'video' => $video,
            ]);
            // $request->session()->flash('status', 'Video Uploaded');
            $video = Video::all();
            return view('admin.videoList',compact('video',$video));
        }
        return redirect()->back()->with('error', 'image not uploaded');
    }

    public function deleteVideo(Request $request){
        $id = $request->id;
        Video::find($id)->delete();
        $request->session()->flash('message', 'Successfully deleted the Video!');
        $video = Video::$video = Video::all();
        return view('admin.videoList',compact('video',$video));
    }
}
