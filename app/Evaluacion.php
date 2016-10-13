<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
	public $table = "evaluacion";
    public $fillable = ['nombre','fecha', 'tiempo', 'taller_id'];
    public $timestamps = false;

    public function entaller()
    {
        return $this->belongsTo('App\Taller');
    }

    public function preguntas() {

        return $this->hasMany('App\Pregunta')->orderByRaw("RAND()")->take(3);
    }

    public function evalUsers() {

        return $this->hasMany('App\EvaluacionUsers');
    }


}