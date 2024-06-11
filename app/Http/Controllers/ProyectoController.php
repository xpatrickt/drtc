<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
     public function ver($id){
        $ver = Proyecto::findOrFail($id);
        return $ver;
    }
    
    public function llenarCombo(){
        $select = Proyecto::select('id', 'nombre')->get();
        return $select;
    }
   
    public function listar(){
        $lista = Proyecto::select();
        return $lista->get();
    }

    public function crear(Request $request){
        $nuevo = new Proyecto($request->all());       
        $nuevo->save();
        return response()->json(['message' => 'El proyecto se creó correctamente', 'identificador' => $nuevo->id]);
    }

    public function modificar(Request $request, $id){
        $editado = Proyecto::findOrFail($id);        
        $editado->update($request->all()); 
        return response()->json(['message' => 'El proyecto se actualizó correctamente']);
    }

    public function eliminar($id){
        $inactivado = Proyecto::findOrFail($id);
        $inactivado->estado = false;
        $inactivado->save(); 
        return response()->json(['message' => 'Se inactivó correctamente']);

    }

    public function activar($id){
        $activado = Proyecto::findOrFail($id);
        $activado->estado = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);

    }
}

