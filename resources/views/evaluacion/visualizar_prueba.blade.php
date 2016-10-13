@extends('layouts.app')

@section('contentheader_title')
     Resultados de la evaluacion
@endsection 

@section('main-content')

    

    

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {{--*/ $i = 0 /*--}}
    @foreach($items as $detalle)
        <div>
            <strong>{{++$i}}: {{$detalle->inPregunta->enunciado}}</strong>
        </div>
        @foreach($detalle->inPregunta->respuestas as $resp)
        @if(($resp->es_correcta)&& ($resp->id == $detalle->respuesta_seleccionada_id))
        <div style="background:#00ff00;">
        @elseif($resp->id == $detalle->respuesta_seleccionada_id)
        <div style="background:#ff3300;">
        @else
        <div>
        @endif
       
            <p>{{$resp->respuesta}}</p>
        </div>
        @endforeach
    @endforeach

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <a class="btn btn-info" href="{{ URL('resumen') }}">Ver mis evaluaciones  </a>
    </div>


@endsection