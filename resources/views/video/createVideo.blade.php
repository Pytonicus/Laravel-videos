<!-- Cargamos la plantilla maestra: -->
@extends('layouts.app')

<!-- Cargamos el contenido en el bloque content -->
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $errors)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row">
            <h2>Crear un nuevo video</h2>
            <!-- es importante añadir el atributo enctype para subir archivos: -->
            <form action="{{route('saveVideo')}}" method="post" enctype="multipart/form-data" class="col-log-7">
            {{ csrf_field() }}<!-- Recuerda añadir el token de seguridad -->
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Miniatura</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="form-group">
                    <label for="video">Archivo de video</label>
                    <input type="file" class="form-control" id="video" name="video">
                </div>

                <button type="submit" class="btn btn-success">Crear video</button>
            </form>
        </div>
    </div>
@endsection