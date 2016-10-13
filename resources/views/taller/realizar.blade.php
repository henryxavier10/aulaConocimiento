@extends('layouts.app')

@section('contentheader_title')
     Tutoria: {{ $item->titulo }}
@endsection


@section('main-content')

   

    <div class="row" style="width : 80%; margin : 0 auto;">
           
        <?php $i = '1'; ?>
<script src="../lightbox/lightbox.min.js"></script>
        @foreach ($item->recursos as $recurso)

        <div class="row">
        <strong>Actividad {{$i++}}: </strong>
        {{ $recurso->descripcion }}<br/>    
            
            

        @if($recurso->extension===".mp4")
         <a class="afterglow btn btn-success" href="#myvideo{{ $recurso->id }}">Ver video </a>
        <video  id="myvideo{{ $recurso->id }}" width="960" height="540">
            <source type="video/mp4" src="../Recursos/{{ $recurso->nombre_archivo }}.mp4" />
        </video>
        @endif

        @if($recurso->extension===".pdf")
        <a class="btn btn-success" data-toggle="modal" data-target="#pdf{{ $recurso->id }}"> Ver PDF</a>
        <!-- Modal -->
            <div class="modal fade" id="pdf{{ $recurso->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-body">

                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">{{ $recurso->archivo }}</h4>
                        </div>
                        <div class="panel-body">
                            <iframe src="../ViewerJS/index.html#../Recursos/{{ $recurso->nombre_archivo }}.pdf" width='800' height='600' allowfullscreen webkitallowfullscreen></iframe>
                        </div>
                    </div> 

                    
                   </div>
                  
                </div>
              </div>
            </div>  
       
        @endif
       
        @if($recurso->extension===".jpg" || $recurso->extension===".png" || $recurso->extension===".gif")
        <a class="btn btn-success" href="../Recursos/{{ $recurso->archivo }}" data-lightbox="image{{$recurso->id}}" >Ver Imagen  </a>
        @endif
        </div><br/>

        @endforeach

  
<script src="https://code.jquery.com/jquery-3.1.1.js" ></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <a class="btn btn-info" href="{{ URL('realizar_evaluacion',$item->id) }}">Realizar evaluacion  </a>



    </div>

@endsection