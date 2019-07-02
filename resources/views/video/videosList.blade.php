<div id="videos-list">
                @if(count($videos) >= 1)
                    @foreach($videos as $video)
                        <div class="video-item col-md-10 pull-left panel panel-default">
                            <div class="panel-body">
                                @if(Storage::disk('imagenes')->has($video->image))
                                    <div class="video-image-thumb col-md-4 pull-left">
                                        <div class="video-image-mask">
                                            <img src="{{url('/miniatura/' . $video->image)}}" class="video-image">
                                        </div>
                                    </div>
                                @endif
                                <div class="data">
                                    <h3><a href="{{url('/video/' . $video->id)}}">{{$video->title}}</a></h3>
                                    <!-- agregamos el enlace al canal de videos: -->
                                    <p><a href="{{route('channel', ['user_id' => $video->user_id])}}">{{$video->user->name . " " . $video->user->surname}}</a></p>
                                </div>
                                <a href="{{url('/video/' . $video->id)}}" class="btn btn-success">Ver</a>
                                @if(Auth::check() && Auth::user()->id == $video->user->id )
                                    <a href="{{url('/editar-video/' . $video->id)}}" class="btn btn-warning">Editar</a>
                                    <a href="#victorModal{{$video->id}}" role="button" class="btn btn-sm btn-primary" data-toggle="modal">Eliminar</a>
                                    
                                    <div id="victorModal{{$video->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">¿Estás seguro?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Seguro que quieres borrar el video?</p>
                                                    <p class="text-warning"><small>{{$video->title}}</small></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    <a href="{{url('/delete-video/' . $video->id)}}" type="button" class="btn btn-danger">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div> 
                    @endforeach
                @else
                    <!-- en caso de no haber videos lo notificamos: -->
                    <div class="alert alert-warning">No hay videos actualmente</div>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
        {{$videos->links()}}