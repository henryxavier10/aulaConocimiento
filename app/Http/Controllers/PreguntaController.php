<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Pregunta;
use App\Respuesta;
use App\Taller;
use App\Evaluacion;
use App\DetalleEvaluacion;

class PreguntaController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Pregunta::orderBy('id','ASC')->paginate(5);
        return view('pregunta.index',compact('items'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       
        return view('pregunta.crear_pregunta');
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
            'enunciado' => 'required',
        ]);

        Pregunta::find($id)->update($request->all());
        return redirect()->route('pregunta.index')
                        ->with('success','Pregunta editada correctamente');
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
            'enunciado' => 'required',
        ]);

        Pregunta::create($request->all());
        return redirect()->route('pregunta.index')
                        ->with('success','Pregunta guardada exitosamente');
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function guardarEvaluacion(Request $request)
    {
        
        $eval=new Evaluacion;
        $eval->taller_id=$request->id;
        $eval->save();
        
        $i=$request->pregunta;
        $cal=0;
        foreach ($i as $item) {
            printf("$item ");
            $respuesta=Respuesta::find($item);
            $pregunta=Pregunta::find($respuesta->pregunta_id);

            $detEval=new DetalleEvaluacion();
            $detEval->evaluacion_id=$eval->id;
            $detEval->pregunta_id=$respuesta->pregunta_id;
            $detEval->respuesta_id=$respuesta->id;
            $detEval->save();
            if ($respuesta->es_correcta) {
                $cal=$cal+5;
            }

            printf("\n la pregunta fue $pregunta->enunciado y su respuesta fue $respuesta->respuesta");
        }  

        printf("Su calificacion es: $cal salir");
        $eval->calificacion=$cal;
        $eval->save();

    }


    
    public function realizarEvaluacion($id)
    {

        $items = Taller::find($id);
        $aleatorio=Taller::find($id)->preguntas_get;
        return view('evaluaciones.realizar_evaluacion',compact('aleatorio','id'));
            
    }

    */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
    */   
    public function destroy($id)
    {
        Pregunta::find($id)->delete();
        return redirect()->route('pregunta.index')
                        ->with('success','Pregunta eliminada correctamente');
    }


}