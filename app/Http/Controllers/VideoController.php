<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo(){
        return view('video.createVideo');
    }

    public function saveVideo(Request $request){
        $validatedData = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);

        $video = new Video();
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        
        $image = $request->file('image');
        if($image){
            $image_path = time() . $image->getClientOriginalName();
            \Storage::disk('imagenes')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        $video_file = $request->file('video');
        if($video_file){
            $video_path = time() . $video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;

        }

        $video->save();

        return redirect('/')->with(array(
            'message' => 'El video se ha subido correctamente'
        ));
        
    }

    public function getImage($filename){
        $file = \Storage::disk('imagenes')->get($filename);
        return new Response($file, 200);
    }

    public function getVideoPage($video_id){ 
        $video = Video::find($video_id);
        return view('video.detail', array(
            'video' => $video
        ));
    }

    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function delete($video_id){ 
        $user = \Auth::user();
        $video = Video::find($video_id); 
        $comments = Comment::where('video_id', $video_id)->get(); 

        if($user && $video->user_id == $user->id){
            if($comments && count($comments) >= 1){ 
                foreach($comments as $comment){
                    $comment->delete();
                }
                
            }

            Storage::disk('imagenes')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            $video->delete();
            
            $message = array('message' => 'Video eliminado correctamente');
        }else{
            $message = array('message' => 'NO SE HA PODIDO ELIMINAR');
        }

        return redirect('/')->with($message);
    }

    public function edit($video_id){
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        
        if($user && $video->user_id == $user->id){
            return view('video.edit', array('video' => $video));
        }else{
            return redirect('/');
        }
        
    }

    public function update($video_id, Request $request){
        $validate = $this->validate($request, array(
            'title' => 'required',
            'description' => 'required',
            /*'video' => 'mimes:mp4' */
        ));

        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        $image = $request->file('image');
        if($image){
            $image_path = time() . $image->getClientOriginalName();
            \Storage::disk('imagenes')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        $video_file = $request->file('video');
        if($video_file){
            $video_path = time() . $video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;

        }

        $video->update();
        return redirect('/')->with(array('message' => 'El video se ha actualizado correctamente'));
    }
    public function search($search = null, $filter = null){
        if(is_null($search)){
            $search = \Request::get('search');
            // Hacemos una redirección si la busqueda no tiene nada:
            if(is_null($search)){
                return redirect()->route('videoSearch', array('search' => $search));
            }

            return redirect()->route('videoSearch', array('search' => $search));
        }

        if(is_null($filter) && \Request::get('filter') && !is_null($search)){
            $filter = \Request::get('filter');
            return redirect()->route('videoSearch', array('search' => $search, 'filter' => $filter));
        }

        $column = 'id';
        $order = 'desc';

         if(!is_null($filter)){
            switch($filter){
                case 'new':
                    $column = 'id';
                    $order = 'desc';
                    break;
                case 'old':
                    $column = 'id';
                    $order = 'asc';
                    break;
                case 'alfa':
                    $column = 'title';
                    $order = 'asc';
                    break;
            }
            
        }

        $videos = Video::where('title', 'LIKE', '%' . $search . '%')->orderBy($column, $order)->paginate(5);

        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));
    }
}
