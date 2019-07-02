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
            <div class="col-md-4">
                <h2> Busqueda: {{$search}}</h2>
                <br>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-8">
                <form class="col-md-3 pull-right" action="{{url('/buscar/' . $search)}}" method="get">
                    <label for="filter">Ordenar</label>
                    <select name="filter" class="form-control">
                        <option value="new">Mas nuevos primero</option>
                        <option value="old">Mas antiguos primero</option>
                        <option value="alfa">De la A a la Z</option>
                    </select>
                    <input type="submit" value="Ordenar" class="btn btn-sm btn-primary">
                </form>
            </div>
            @include('video.videosList')
    </div>
</div>
@endsection
