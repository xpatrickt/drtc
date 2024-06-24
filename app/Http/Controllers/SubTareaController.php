<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubTarea;

class SubTareaController extends Controller
{
    public function ver($id){
        $ver = SubTarea::findOrFail($id);
        return $ver;
    }
    
    public function llenarCombo(){
        $select = SubTarea::select('id', 'nombre')->where('estado', true)->get();
        return $select;
    }
   
    public function listar(){

        $lista = SubTarea::select()->with([
            'tarea','tarea.proyecto'
            ]);
        return $lista->get();
    }

    public function crear(Request $request){
        $nuevo = new SubTarea($request->all());       
        $nuevo->save();
        return response()->json(['message' => 'La actividad se creó correctamente', 'identificador' => $nuevo->id]);
    }

    public function modificar(Request $request, $id){
        $editado = SubTarea::findOrFail($id);        
        $editado->update($request->all()); 
        return response()->json(['message' => 'La actividad se actualizó correctamente']);
    }

    public function eliminar($id){
        $inactivado = SubTarea::findOrFail($id);
        $inactivado->estado = false;
        $inactivado->save(); 
        return response()->json(['message' => 'Se inactivó correctamente']);

    }

    public function activar($id){
        $activado = SubTarea::findOrFail($id);
        $activado->estado = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);

    }
}
