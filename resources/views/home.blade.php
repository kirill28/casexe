@extends('adminlte::page')

@section('title', 'Casexe')

@section('content_header')
    <h1>Good luck!</h1>
@stop

@section('content')
    <div class="box box-default">
        <div class="box-header with-border">
            <i class="fa fa-money"></i>

            <h3 class="box-title">Casino</h3>
        </div>

        <div class="box-body">
            @if ($gameIsAvailable)
                <a class="btn btn-app" href="{{ route('play') }}">
                    <i class="fa fa-play"></i>
                    Play
                </a>
            @else
                <div class="callout callout-danger">
                    <h4>Sorry the game is not available now</h4>
                    <p>We are working on it</p>
                </div>
            @endif
        </div>
    </div>
@stop