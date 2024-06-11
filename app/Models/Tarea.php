<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tarea';
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'prioridad',
        'meta',
        'avance',
        'id_proyecto',   
    ];
    public function proyecto(){
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id');
    }
}
