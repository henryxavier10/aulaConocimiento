<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Pregunta extends Model
{
	public $table = "pregunta";
    public $fillable = ['enunciado','rutaImagen','tipopregunta','evaluacion_id'];
    public $timestamps = false;

    
    public function inEvaluacion()
    {
        return $this->belongsTo('App\Evaluacion');
    }

    public function respuestas() {

        return $this->hasMany('App\Respuesta');
    }

     public function detalleEval() {

        return $this->hasMany('App\DetalleEvaluacion');
    }

   
    
}