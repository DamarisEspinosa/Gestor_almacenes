<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function welcome(){
        // Obtener todos los almacenes de la base de datos
        $almacenes = Almacen::where('user_id', Auth::id())->get();
        $proveedores = Proveedor::where('user_id', Auth::id())->get();

        // Pasar los almacenes a la vista welcome
        return view('welcome', compact('almacenes', 'proveedores'));
    }


    public function index()
    {
        if (auth()->user()->tipo === 'admin') {
            $almacenes = Almacen::all();
            return view('welcome', compact('almacenes'));
        } else{
            $almacenes = Almacen::all();
            return view('welcome', compact('almacenes'));
        }
    }
}
