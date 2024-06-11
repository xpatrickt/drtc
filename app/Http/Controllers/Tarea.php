<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Tarea extends Controller
{
    public function ver($id){
        $ver = Tarea::findOrFail($id);
        return $ver;
    }
    
    public function llenarCombo(){
        $select = Tarea::select('id', 'nombre')->get();
        return $select;
    }
   
    public function listar(){
        $lista = Tarea::select();
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
        return response()->json(['message' => 'Se inactivó correctamente']);

    }

    public function activar($id){
        $activado = Tarea::findOrFail($id);
        $activado->estado = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);

    }
}
