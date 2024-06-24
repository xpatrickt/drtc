<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTarea extends Model
{
    use HasFactory;
    protected $table = 'subtarea';
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'situacion',
        'estado',
        'prioridad',
        'meta',
        'avance',
        'id_tarea',   
    ];
    public function tarea(){
        return $this->belongsTo(Tarea::class, 'id_tarea', 'id');
    }
}
