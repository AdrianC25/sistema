<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;


class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $categorias = Categoria::all();
        return view('productos', compact('productos', 'categorias'));
    }

    public function addProducto(Request $request)
    {
        $new_producto = new Producto;
        $new_producto->nombre = $request->nombre;
        $new_producto->pecio = $request->precio;
        $new_producto->detalle = $request->detalle;
        $new_producto->id_categoria = $request->categoria;
        $new_producto->save();

        return Response()->json(['nuevo_producto' => $new_producto]);
    }

    public function editarProducto($idProducto)
    {
        $producto_elejido = Producto::where('id', $idProducto)->first();

        return Response()->json(['producto' => $producto_elejido]);
    }

    public function guardarEditarProducto(Request $request)
    {
        $idProducto = $request->id;
        $producto_elejido = Producto::find($idProducto);
        $producto_elejido->nombre = $request->nombre;
        $producto_elejido->pecio = $request->precio;
        $producto_elejido->detalle = $request->detalle;
        $producto_elejido->id_categoria = $request->categoria;
        $producto_elejido->save();

        return Response()->json(['nuevo_producto' => $producto_elejido]);
    }

    public function eliminarProducto($idProducto)
    {
        $producto_elejido = Producto::find($idProducto)->delete();

        return Response()->json(['producto' => 'Producto Eliminado Exitosamente']);
    }

}
