<x-app-layout>
    <header class="bg-blue-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <h1 class="text-2xl font-bold">Agregar artículo en {{ $almacen->nombre }}</h1>
            </div>
        </div>
    </header>

    <div class="bg-blue-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('articulos.store', $almacen->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div class="flex items-center">
                        <label for="producto" class="w-1/4">Producto:</label>
                        <input type="text" name="producto" id="producto" class="w-3/4 px-4 py-2 border rounded" required>
                    </div>

                    <div class="flex items-center">
                        <label for="cantidad" class="w-1/4">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" class="w-3/4 px-4 py-2 border rounded" required>
                    </div>

                    <div class="flex items-center">
                        <label for="descripcion" class="w-1/4">Descripción:</label>
                        <textarea name="descripcion" id="descripcion" class="w-3/4 px-4 py-2 border rounded"></textarea>
                    </div>

                    <div class="flex items-center">
                        <label for="nombreProveedor" class="w-1/4">Proveedor:</label>
                        <select name="nombreProveedor" id="nombreProveedor" class="w-3/4 px-4 py-2 border rounded" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">Guardar Artículo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
