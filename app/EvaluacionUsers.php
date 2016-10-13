<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionUsers extends Model
{
	public $table = "evaluacion_users";
    public $fillable = ['fecha', 'puntuacion', 'users_id', 'evaluacion_id'];
    public $timestamps = false;

    public function inEvaluacion()
    {
        return $this->belongsTo('App\Evaluacion');
    }

    public function detallesEval() {

        return $this->hasMany('App\DetalleEvaluacion','evaluacionusers_id');
    }

    public function inUsers()
    {
        return $this->belongsTo('App\User');
    }


}