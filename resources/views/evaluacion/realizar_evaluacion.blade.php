@extends('layouts.app')

@section('contentheader_title')
    Evaluacion
@endsection 

@section('main-content')


<h2>EVALUACION DE LA TUTORIA: {{$id}}</h2>

<div>
    {!! Form::open(array('action' => 'EvaluacionController@guardarEvaluacion','method'=>'POST')) !!}

    {{ Form::hidden('id', $id) }}

    {{ Form::hidden('id_eval', $id_eval) }}

    {{--*/ $i = 0 /*--}}

	@foreach ($aleatorio as $pregunta)

	<div>
		<strong>{{$pregunta->enunciado}}</strong>


		@foreach ($pregunta->respuestas as $respuesta)
		<div>{{$respuesta->respuesta}}   {{ Form::checkbox('pregunta[]', $array[$i].'nn'.$respuesta->id) }}</div>
		
		@endforeach

		{{--*/ $i++ /*--}}

	</div>
	@endforeach

		<div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
	{!! Form::close() !!}
</div>
@endsection