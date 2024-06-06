<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table = 'proyecto';
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
    ];
}


