@extends('layouts.app')
@section('content')
    <div class="col-md-12">
        <h2>{{$video->title}}</h2>
        <hr>
        <div class="col-md-8">
            <video controls id="video-player">
                <source src="{{url('/video-file/' . $video->video_path)}}">
                tu navegador no es compatible con HTML5
            </video>
            <div class="panel panel-default video-data">
                <div class="panel-heading">
                    <div class="panel-title"> <!-- Le pasamos la url del canal: -->                                                                            <!-- Llamamos al helper para formatear la fecha: -->
                        Subido por <strong><a href="{{route('channel', ['user_id' => $video->user->id])}}">{{$video->user->name . ' ' . $video->user->surname}}</a></strong> {{\FormatTime::LongTimeFilter($video->created_at)}}
                    </div>
                </div>
                <div class="panel-body">
                    {{$video->description}}
                </div>
            </div>
                @include('video.comments')
        </div>
    </div>
@endsection