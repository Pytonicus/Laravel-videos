<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request){
        $validate = $this->validate($request, [
            'body' => 'required'
        ]);

        $comment = new Comment();
        $user = \Auth::user();
        $comment->user_id = $user->id; 
        $comment->video_id = $request->input('video_id');
        $comment->body = $request->input('body'); 

        $comment->save();

        return redirect()->route('detailVideo', ['video_id' => $comment->video_id])->with(array(
            'message' => 'Comentario añadido correctamente.'
        ));
    }

    // Creamos un método para eliminar el comentario:
    public function delete($comment_id){
        // Identificamos al usuario que ha creado el comentario:
        $user = \Auth::user();
        // Identificamos el comentario:
        $comment = Comment::find($comment_id);
        // Preguntamos si el usuario que va a borrar el comentario es el mismo que lo creo o es el dueño del video:
        if($user && ($comment->user_id == $user->id || $comment->video->user_id == $user->id)){
            // Borramos el comentario:
            $comment->delete();
        }
        // regresamos al video:
        return redirect()->route('detailVideo', ['video_id' => $comment->video_id])->with(array(
            'message' => 'Comentario eliminado correctamente.'
        ));

    }
}
