<!-- Importamos la plantilla maestra -->
@extends('layouts.app')

<!-- Cargamos el bloque de contenido -->
@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <!-- POnemos el nombre y apellidos del dueño del canal: -->
                <h2>Canal de {{$user->name . ' ' . $user->surname}}</h2>
                <div class="clearfix"></div>
                @include('video.videosList')
        </div>
    </div>
    @endsection