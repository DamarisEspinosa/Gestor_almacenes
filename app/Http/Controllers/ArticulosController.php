<?php

namespace App\Http\Controllers;

use App\Models\Articulos;
use App\Models\Almacen;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ArticulosController extends Controller
{

    public function create($almacenId)
    {
        $almacen = Almacen::findOrFail($almacenId);
        $proveedores = Proveedor::all();

        return view('articulos.create', compact('almacen', 'proveedores'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'producto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'nombreProveedor' => 'required|string'
        ]);

        // Encuentra el almacén al que pertenece el artículo
        $almacen = Almacen::findOrFail($id);
        // Encuentra el proveedor para enviarlo al registro 
        $nombreProveedor = Proveedor::findOrFail($request->nombreProveedor);

        // Crea un nuevo artículo asociado al almacén
        $articulo = new Articulos();
        $articulo->producto = $request->producto;
        $articulo->cantidad = $request->cantidad;
        $articulo->descripcion = $request->descripcion;
        $articulo->almacen_id = $almacen->id;
        $articulo->proveedor_id = $nombreProveedor->id;
        $articulo->save();

        // Redirige al almacén con un mensaje de éxito
        return redirect()->route('almacenView', ['name' => $almacen->nombre])
                            ->with('success', 'Artículo agregado exitosamente');
    }

    // Mostrar formulario para editar un artículo existente
    public function edit($almacenId, $articuloId)
    {
        // Encuentra el almacén y el artículo
        $almacen = Almacen::findOrFail($almacenId);
        $articulo = Articulos::findOrFail($articuloId);

        return view('articulos.edit', compact('almacen', 'articulo'));
    }

    // Actualizar un artículo existente
    public function update(Request $request, $almacenId, $articuloId)
    {
        $request->validate([
            'producto' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
        ]);

        // Encuentra el almacén y el artículo
        $almacen = Almacen::findOrFail($almacenId);
        $articulo = Articulos::findOrFail($articuloId);

        // Actualiza los campos del artículo
        $articulo->producto = $request->producto;
        $articulo->cantidad = $request->cantidad;
        $articulo->descripcion = $request->descripcion;
        $articulo->save();

        return redirect()->route('almacenView', ['name' => $almacen->nombre])
                            ->with('success', 'Artículo modificado exitosamente');
    }

    // Eliminar un artículo
    public function destroy($almacenId, $articuloId)
    {
        $articulo = Articulos::findOrFail($articuloId);

        // Borra el articulo 
        $articulo->delete();

        return redirect()->route('almacenView', ['name' => Almacen::findOrFail($almacenId)->nombre])
                            ->with('success', 'Artículo eliminado exitosamente');
    }

    // Función para enviar 
    public function send(Articulo $articulo)
    {
        return redirect()->route('almacenView', $articulo->almacen_id)
                         ->with('success', 'Artículo enviado correctamente.');
    }
}
