<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    // Creamos una relación entre los videos y los comentarios de uno a muchos:
    public function video(){
        return $this->belongsTo('App\User', 'video_id');
    }
}
