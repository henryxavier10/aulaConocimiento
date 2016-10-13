<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Evaluacion;
use App\Taller;
use App\Pregunta;
use App\Respuesta;
use App\EvaluacionUsers;
use App\DetalleEvaluacion;
use App\User;
use PDF;

use Auth;

class EvaluacionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Evaluacion::orderBy('id','ASC')->paginate(5);
        return view('evaluacion.index',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
        ]);

        Evaluacion::create($request->all());
        return redirect()->route('evaluacion.index')
                        ->with('success','Item created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */   
    public function destroy($id)
    {
        Evaluacion::find($id)->delete();
        return redirect()->route('evaluacion.index')
                        ->with('success','Evaluacion eliminada correctamente');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
       
    }



     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'nombre' => 'required',
        ]);

        Evaluacion::find($id)->update($request->all());
        return redirect()->route('evaluacion.index')
                        ->with('success','Evaluacion actualizada correctamente');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function realizar($id)
    {   
        //$user=Auth::user()->id;

        $carbon = new \Carbon\Carbon();
        $date = $carbon->now();
        //$cal=0;
        $evaluacion=Taller::find($id)->evaluaciones;

        $evaluser=new EvaluacionUsers();

        $evaluser->evaluacion_id=$evaluacion->id;
        $evaluser->users_id=Auth::user()->id;
        $evaluser->fecha= $date;
        $evaluser->puntuacion=0;
        $evaluser->save();

        //printf("haciendo evaluacion(id eval):$evaluacion->id de(id user):$user  el dia(date):$date su calificacion es(int):$cal ");
    
        $aleatorio=$evaluacion->preguntas;
        $array=[];
        $i=0;
        foreach ($aleatorio as $pregunta) {

            $detEval=new DetalleEvaluacion();
            $detEval->pregunta_id=$pregunta->id;
            $detEval->evaluacionusers_id=$evaluser->id;
            $detEval->respuesta_seleccionada_id=null;
            $detEval->save();
            $array[$i]= $detEval->id;
            $i++;

            
        }

        $id_eval=$evaluser->id;

        //print_r($array);

        return view('evaluacion.realizar_evaluacion',compact('aleatorio','id','id_eval','array'));

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarEvaluacion(Request $request)
    {
        
        
        $i=$request->pregunta;
        $cal=0;
        foreach ($i as $item) {
            //printf("$item ");
            $pregid=strstr($item, 'nn',true);
            $itemid=substr(strstr($item, 'nn'),2);
            //printf(" $pregid ");
            $respuesta=Respuesta::find($itemid);
            $pregunta=Pregunta::find($respuesta->pregunta_id);

            if ($respuesta->es_correcta) {
                $cal=$cal+5;
            }

            $pseleccionada=DetalleEvaluacion::find($pregid);
            $pseleccionada->respuesta_seleccionada_id=$respuesta->id;
            $pseleccionada->save();

            //printf("\n la pregunta fue $pregunta->enunciado y su respuesta fue $respuesta->respuesta");
        }  
        $id=$request->id_eval;
        $evaluacion=EvaluacionUsers::find($id);

        $evaluacion->puntuacion=$cal;
        $evaluacion->save();

            $items=$evaluacion->detallesEval;
            return view('evaluacion.visualizar_prueba',compact('items','id'));

        //printf("Su calificacion es: $cal salir");
       
    }

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function resumen_evaluaciones()
    {  
        $user=User::find(Auth::user()->id);
        $items=$user->evalUsers()->paginate(10);
        //$items=EvaluacionUsers::$items->orderBy('id','DESC')->paginate(5);
        // $items = EvaluacionUsers::orderBy('id','DESC')->paginate(5);
        //$users = User::where('votes', '>', 100)->paginate(15);

        return view('evaluacion.resumen_evaluaciones',compact('items'));
        //print_r($items);
            
    }  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function ver_prueba($id)
    {  
            $evaluser=EvaluacionUsers::find($id);
            $items=$evaluser->detallesEval;
            //printf("prueba $id");
            return view('evaluacion.visualizar_prueba',compact('items','id'));
           // foreach ($items as $item) {
             //  printf($item->inPregunta->id);
            //}
            //print_r($items);
    }  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pdfview($id)
    {
       // $items = DB::table("items")->get();
       // view()->share('items',$items);

            $evaluser=EvaluacionUsers::find($id);
            $items=$evaluser->detallesEval;

            $pdf = PDF::loadView('evaluacion.visualizar_prueba',compact('items','id'))->save( 'pdfname.pdf' ); 
            //return $pdf->download('prueba.pdf');
            //->save( 'path/pdfname.pdf' ); 
        

       // return view('pdfview');
    }

}