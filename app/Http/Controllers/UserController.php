<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Video;
use App\Comment;


class UserController extends Controller
{
    public function channel($user_id){
        $user = User::find($user_id);
        // Preguntamos si user es un objeto o no:
        if(!is_object($user)){
            return redirect('/');
        }

        $videos = Video::where('user_id', $user_id)->paginate(5);
        return view('user.channel', array(
            'user' => $user,
            'videos' => $videos
        ));
    }
}
