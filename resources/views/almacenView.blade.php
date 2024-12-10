<x-app-layout>
    <header class="bg-blue-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <h1 class="text-2xl font-bold">Inventario Almacén: {{ $name }}</h1>
            </div>
        </div>
    </header>

    <div class="bg-blue-200 py-6">
        <div class="text-center mb-4">
            <!-- Mostrar mensaje de éxito -->
            @if (session('success'))
                <div class="bg-green-200 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="flex justify-center mb-4">
            <a href="{{ route('articulos.create', $almacen->id, ['almacen' => $name]) }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Agregar artículo
            </a>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <table class="table-auto w-full bg-white rounded shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Producto</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $articulo)
                        <tr class="border-b text-center">
                            <td class="px-4 py-2">{{ $articulo->id }}</td>
                            <td class="px-4 py-2">{{ $articulo->producto }}</td>
                            <td class="px-4 py-2">{{ $articulo->cantidad }}</td>
                            <td class="px-4 py-2">{{ $articulo->descripcion }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('articulos.edit', ['almacen' => $almacen->id, 'articulo' => $articulo->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded">
                                    Modificar
                                </a>
                                <form method="POST" action="{{ route('articulos.destroy', ['almacen' => $almacen->id, 'articulo' => $articulo->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded"
                                        onclick="return confirm('¿Estás seguro de eliminar este artículo?')">
                                        Eliminar
                                    </button>
                                </form>
                                <button 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded"
                                    onclick="#">
                                    Enviar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
