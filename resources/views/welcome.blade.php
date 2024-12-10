<x-app-layout>
    <header class="bg-blue-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <img src="{{ asset('images/bienvenido.png') }}" alt="Registro" style="width: 300px; max-width: 100%;">
            </div>
        </div>
    </header>

    <div class="bg-blue-200">
        <div class="text-center">

            <!-- Botón para agregar almacén -->
            <button 
                id="add-warehouse-button" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Agregar Almacén
            </button>
            <button 
                id="add-prov-button" 
                onclick="window.location.href='{{ route('proveedores.create') }}'" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Agregar Proveedor
            </button>

            <!-- Lista de almacenes -->
            <div class="grid grid-cols-2 ">
                <div id="warehouses-container" style="margin-top: 20px;">
                    @foreach ($almacenes as $almacen)
                        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <!-- Recuadro clickeable -->
                            <div 
                                data-id="{{ $almacen->id }}"
                                onclick="window.location.href='{{ route('almacenView', ['name' => $almacen->nombre]) }}'" 
                                style="background-color: rgba(226, 232, 240, 0.8); 
                                    width: 300px; 
                                    padding: 20px; 
                                    text-align: center; 
                                    font-weight: bold; 
                                    border-radius: 12px; 
                                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
                                    cursor: pointer; 
                                    font-size: 18px; 
                                    height: 60px;"
                                onmouseover="this.style.backgroundColor='rgba(203, 213, 225, 0.9)'"
                                onmouseout="this.style.backgroundColor='rgba(226, 232, 240, 0.8)'">
                                {{ $almacen->nombre }}
                            </div>
                            <!-- Botón Editar -->
                            <button 
                                onclick="editWarehouse('{{ $almacen->id }}', '{{ $almacen->nombre }}')" 
                                style="background-color: #4caf50; 
                                    color: white; 
                                    margin-left: 10px; 
                                    width: 80px; 
                                    height: 60px; 
                                    border-radius: 8px; 
                                    cursor: pointer;">
                                Editar
                            </button>
                            <!-- Botón Eliminar -->
                            <button 
                                onclick="deleteWarehouse('{{ $almacen->id }}')" 
                                style="background-color: #f44336; 
                                    color: white; 
                                    margin-left: 10px; 
                                    width: 80px; 
                                    height: 60px; 
                                    border-radius: 8px; 
                                    cursor: pointer;"
                            >
                                Eliminar
                            </button>
                        </div>
                    @endforeach
                </div>
                <!--PROVEEDORES -->
                <div id="warehouses-container" style="margin-top: 20px;">
                    @foreach ($proveedores as $proveedor)
                        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                            <!-- Recuadro clickeable -->
                            <div 
                                onclick="window.location.href='#'"
                                style="background-color: rgba(226, 232, 240, 0.8); 
                                    width: 300px; 
                                    padding: 20px; 
                                    text-align: center; 
                                    font-weight: bold; 
                                    border-radius: 12px; 
                                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
                                    cursor: pointer; 
                                    font-size: 18px; 
                                    height: 60px;"
                                onmouseover="this.style.backgroundColor='rgba(203, 213, 225, 0.9)'"
                                onmouseout="this.style.backgroundColor='rgba(226, 232, 240, 0.8)'">
                                {{ $proveedor->nombre }}
                            </div>
                            <!-- Botón Editar -->
                            <a href="{{ route('proveedores.edit', $proveedor->id) }} "
                                style="background-color: #4caf50; color: white; margin-left: 10px; width: 80px; height: 60px; border-radius: 8px; cursor: pointer; display: flex; justify-content: center; align-items: center; ">
                                Editar
                            </a>
                            <form method="POST" action="{{ route('proveedores.destroy', $proveedor->id) }} ">
                                @csrf 
                                @method('DELETE')
                                <button type="submit"
                                    style="background-color: #f44336; color: white; margin-left: 10px; width: 80px; height: 60px; border-radius: 8px; cursor: pointer;"
                                    onclick="return confirm('¿Está seguro de eliminar este proveedor?')">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Agregar un nuevo almacén
        document.getElementById('add-warehouse-button').addEventListener('click', function () {
            const name = prompt('Ingrese el nombre del almacén:');
            if (name) {
                fetch('/api/almacenes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ name }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Almacén agregado con éxito.');

                            // Recargar la página para reflejar los cambios
                            location.reload();
                        } else {
                            alert('Error al agregar el almacén.');
                        }
                    });
            }
        });

        // Editar un almacén
        function editWarehouse(id, currentName) {
            const newName = prompt('Editar nombre del almacén:', currentName);
            if (newName) {
                fetch(`/api/almacenes/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ name: newName }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Almacén actualizado con éxito.');

                            // Recargar la página para reflejar los cambios
                            location.reload();
                        } else {
                            alert('Error al actualizar el almacén.');
                        }
                    });
            }
        }

        // Eliminar un almacén
        function deleteWarehouse(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este almacén?')) {
                fetch(`/api/almacenes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Almacén eliminado con éxito.');

                            // Recargar la página para reflejar los cambios
                            location.reload();
                        } else {
                            alert('Error al eliminar el almacén.');
                        }
                    });
            }
        }
    </script>
</x-app-layout>
