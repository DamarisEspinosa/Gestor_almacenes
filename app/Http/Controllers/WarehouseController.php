<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Articulos;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Crear el almacén
        Almacen::create([
            'nombre' => $request->name,
            'user_id' => Auth::id(),
        ]);

        // Responder con éxito
        return response()->json(['success' => true]);
    }

    public function view($name)
    {
        // Encuentra el almacén por su nombre
        $almacen = Almacen::where('nombre', $name)->firstOrFail();

        // Obtén los artículos relacionados con este almacén
        $articulos = $almacen->articulos;

        // Obtener todos los almacenes del usuario autenticado
        $almacenes = Almacen::all();

        return view('almacenView', compact('articulos', 'almacen', 'almacenes', 'name'));
    }

    public function index()
    {
        // Obtener todos los almacenes desde la base de datos
        $almacenes = Almacen::all();

        // Pasar los almacenes a la vista welcome
        return view('welcome', compact('almacenes'));
    }

    public function update(Request $request, $id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->update(['nombre' => $request->name]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->delete();
        return response()->json(['success' => true]);
    }

}
