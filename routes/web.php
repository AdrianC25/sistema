<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// productos
Route::get('/productos',[ProductoController::class,'index'])->name('productos');

Route::post('/productos/add_producto',[ProductoController::class,'addProducto'])->name('productos');

Route::get('/productos/editar_producto/{idProducto}',[ProductoController::class,'editarProducto'])->name('productos');

Route::post('/productos/add_edit_producto',[ProductoController::class,'guardarEditarProducto'])->name('productos');

Route::delete('/productos/eliminar/{idProducto}',[ProductoController::class,'eliminarProducto'])->name('productos');

// categorias
Route::get('/',[CategoriaController::class,'index'])->name('categorias');
Route::post('/welcome/add_categoria',[CategoriaController::class,'addCategoria'])->name('categorias');
Route::get('/welcome/editar_categoria/{idCategoria}',[CategoriaController::class,'editarCategoria'])->name('categorias');
Route::post('/welcome/add_edit_categoria',[CategoriaController::class,'guardarEditarCategoria'])->name('categorias');
Route::delete('/welcome/eliminar/{idCategoria}',[CategoriaController::class,'eliminarCategoria'])->name('categorias');

