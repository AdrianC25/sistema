<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('welcome', compact('categorias'));
    }
    public function addCategoria(Request $request)
    {
        $new_categoria = new Categoria;
        $new_categoria->nombre = $request->nombre;
        $new_categoria->save();

        return Response()->json(['nueva_categoria' => $new_categoria]);
    }

    public function editarCategoria($idCategoria)
    {
        $categoria_elejida = Categoria::where('id', $idCategoria)->first();

        return Response()->json(['categoria' => $categoria_elejida]);
    }

    public function guardarEditarCategoria(Request $request)
    {
        $idCategoria = $request->id;
        $categoria_elejida = Categoria::find($idCategoria);
        $categoria_elejida->nombre = $request->nombre;
        $categoria_elejida->save();

        return Response()->json(['nueva_categoria' => $categoria_elejida]);
    }

    public function eliminarCategoria($idCategoria)
    {
        $categoria_elejida = Categoria::find($idCategoria)->delete();

        return Response()->json(['categoria' => 'Categoria Eliminada Exitosamente']);
    }

}
