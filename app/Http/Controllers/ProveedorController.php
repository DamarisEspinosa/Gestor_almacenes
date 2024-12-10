<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    public function create() 
    {
        return view('proveedores.create');
    }
    
    public function store(Request $request) 
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:10',
            'email' => 'required|string|max:255',
            'direccion' => 'required|string',
            'formaPago' => 'required|string'
        ]);

        $proveedor = new Proveedor();
        $proveedor->nombre = $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->formaPago = $request->formaPago;
        $proveedor->user_id = Auth::id();
        $proveedor->save();

        return redirect()->route('welcome')
                        ->with('success', 'Proveedor agregado exitosamente');
    }

    public function edit ($proveedorId) 
    {
        $proveedor = Proveedor::findOrFail($proveedorId);

        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $proveedorId) 
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:10',
            'email' => 'required|string|max:255',
            'direccion' => 'required|string',
            'formaPago' => 'required|string'
        ]);

        $proveedor = Proveedor::findOrFail($proveedorId);

        $proveedor->nombre = $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;
        $proveedor->direccion = $request->direccion;
        $proveedor->formaPago = $request->formaPago;
        $proveedor->user_id = Auth::id();
        $proveedor->save();

        return redirect()->route('welcome')
                        ->with('success', 'Proveedor editado exitosamente');
    }

    public function destroy($proveedorId) 
    {
        $proveedor = Proveedor::findOrFail($proveedorId);

        $proveedor->delete();
        
        return redirect()->route('welcome')
                        ->with('success', 'Proveedor eliminado exitosamente');
    }
}
