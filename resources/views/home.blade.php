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
            @if(isset($winResult))
                @include($winResult->getViewName(), $winResult->getData())
            @else
                @include('casino._play')
            @endif
        </div>

    </div>
@stop