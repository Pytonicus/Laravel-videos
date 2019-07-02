<hr>
    <h4>Comentarios</h4>
<hr>
@if(session('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
@endif
@if(Auth::check())
    <form class="col-md-4" method="POST" action="{{url('/comment')}}">
        {!! csrf_field() !!}
        <input type="hidden" name="video_id" value="{{$video->id}}" required>
        <p>
            <textarea class="form-control" name="body" required></textarea>
        </p>
        <input type="submit" value="comentar" class="btn bton-success">
    </form>
    <div class="clearfix"></div>
    <hr>
@endif
@if(isset($video->comments))

    <div id="comment-list">
        @foreach($video->comments as $comment)
            <div class="comment-item col-md-12 pull-left">
                <div class="panel panel-default comment-data">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>{{$comment->user->name . ' ' . $comment->user->surname}}</strong> {{ \FormatTime::LongTimeFilter($video->created_at)}}
                        </div>
                    </div>
                    <div class="panel-body">
                        {{$comment->body}}

                        @if(Auth::check() && (Auth::user()->id == $comment->user_id || Auth::user()->id == $video->user_id))
                            <div class="pull-right">
                                <a href="#victorModal{{$comment->id}}" role="button" class="btn btn-sm btn-primary" data-toggle="modal">Eliminar comentario</a>
                                
                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div id="victorModal{{$comment->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">¿Estás seguro?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Seguro que quieres borrar el comentario?</p>
                                                <p class="text-warning"><small>{{$comment->body}}</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                <!-- modificamos este botón por un enlace y le pasamos la url del controlador que elimina las entradas: -->
                                                <a href="{{url('/delete-comment/' . $comment->id)}}" type="button" class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif