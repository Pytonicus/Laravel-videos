<!-- heredamos de la plantilla maestra: -->
@extends('layouts.app')

<!-- Cargamos la seccion de contenido: -->
@section('content')
    <div class="container">
        <div class="row">
        <!-- Establecemos el titulo del video: -->
        <h2>Editar {{$video->title}}</h2>
            <!-- es importante añadir el atributo enctype para subir archivos: -->
            <form action="{{route('updateVideo', ['video_id' => $video->id]) }}" method="post" enctype="multipart/form-data" class="col-log-7">
            {{ csrf_field() }}<!-- Recuerda añadir el token de seguridad -->
                <div class="form-group">
                    <label for="title">Titulo</label>           <!-- cargamos el titulo del video en el value: -->
                    <input type="text" class="form-control" id="title" name="title" value="{{$video->title}}">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label> <!-- cargamos la descripción en el value: -->
                    <textarea class="form-control" id="description" name="description">{{$video->description}}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Miniatura</label>
                    <!-- Creamos una previsualización de la imagen: -->
                    @if(Storage::disk('imagenes')->has($video->image))
                        <div class="video-image-thumb">
                            <div class="video-image-mask">
                                <img src="{{url('/miniatura/' . $video->image)}}" class="video-image">
                            </div>
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="form-group">
                    <label for="video">Archivo de video</label><br>
                    <!-- Cargamos el video: -->
                    <video controls id="video-player">
                        <source src="{{route('fileVideo', ['filename' => $video->video_path])}}">
                    </video>

                    <input type="file" class="form-control" id="video" name="video">
                </div>

                <button type="submit" class="btn btn-success">Modificar video</button>
            </form>
        </div>
    </div>
@endsection