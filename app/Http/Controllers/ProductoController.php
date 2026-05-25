<?php

namespace App\Http\Controllers;

use App\Models\ProductoTerminado;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of products with inventory.
     */
    public function index()
    {
        $productos = ProductoTerminado::with('inventario')->get();
        return view('productos.index', compact('productos'));
    }
}
