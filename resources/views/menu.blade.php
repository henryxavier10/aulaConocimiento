@extends('layouts.app')

@section('contentheader_title')
	
@endsection


@section('main-content')
	<div class="container spark-screen">
		<div class="row">
			
			<div class="col-md-1"></div>
  			<div class="col-md-9">
  				@foreach ($menul as $m)
  				@if($m->activo==1)
				<div class="col-md-4">
					<div class="info-box">
			  <!-- Apply any bg-* class to to the icon to color it -->
					@if($m->activo==1)
					  	@if($m->esHoja==0)
						  <span class="info-box-icon bg-yellow"><i class="fa fa-folder-o"></i></span>
						  <div class="info-box-content">
						    <?php echo "<span class='info-box-text'><a style='color:black' href='".url('menu/'.$m->id)."'>".$m->titulo."</a></span>";?>
						  </div><!-- /.info-box-content -->
						@else
						  <span class="info-box-icon bg-red"><i class="fa fa-files-o"></i></span>
						  <div class="info-box-content">
						    <?php echo "<span class='info-box-text'><a style='color:black' href='".url('ev3/'.$m->titulo)."'>".$m->titulo."</a></span>";?>
						  </div><!-- /.info-box-content -->

						@endif
					@endif
					</div><!-- /.info-box -->
				</div>
				@endif
				@endforeach
  			</div>
  			<div class="col-md-2"></div>
			
		</div>

		
	</div>
@endsection
