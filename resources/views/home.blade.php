@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            @if(session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                </div>
            @endif
            <!-- incluimos el conteido de la vista videosList.blade.php -->
            @include('video.videosList')
    </div>
</div>
@endsection
