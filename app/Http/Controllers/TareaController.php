<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function ver($id){
        $ver = Tarea::findOrFail($id);
        return $ver;
    }
    
    public function llenarCombo($id_proyecto){
    $select = Tarea::select('id', 'nombre','estado','id_proyecto')->where('id_proyecto',$id_proyecto)->where('estado', true);
    return $select->get();
    }
   
    public function listar(){

        $lista = Tarea::select()->where('estado', true)
        ->with([
            'proyecto:id,nombre',
            ]);
        return $lista->get();
    }

    public function crear(Request $request){
        $nuevo = new Tarea($request->all());       
        $nuevo->save();
        return response()->json(['message' => 'La actividad se creó correctamente', 'identificador' => $nuevo->id]);
    }

    public function modificar(Request $request, $id){
        $editado = Tarea::findOrFail($id);        
        $editado->update($request->all()); 
        return response()->json(['message' => 'La actividad se actualizó correctamente']);
    }

    public function eliminar($id){
        $inactivado = Tarea::findOrFail($id);
        $inactivado->estado = false;
        $inactivado->save(); 
        return response()->json(['message' => 'Se inactivó correctamente', 'estado' => $inactivado->estado]);

    }

    public function activar($id){
        $activado = Tarea::findOrFail($id);
        $activado->estado = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);

    }
}
