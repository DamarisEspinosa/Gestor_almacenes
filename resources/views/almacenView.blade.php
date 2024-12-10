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
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
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
                        <th class="px-4 py-2">Proveedor</th>
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
                            <td class="px-4 py-2">{{ $articulo->proveedor_id }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <a href="{{ route('articulos.edit', ['almacen' => $almacen->id, 'articulo' => $articulo->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded">
                                    Modificar
                                </a>
                                <button 
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded"
                                    onclick="deleteArticulo({{ $almacen->id }}, {{ $articulo->id }})">
                                    Eliminar
                                </button>
                                <button
                                    onclick="sendArticulo({{ $articulo->id }})"
                                    class="btn-enviar bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-2 rounded"
                                    data-producto="{{ $articulo->producto }}" 
                                    data-cantidad="{{ $articulo->cantidad }}"
                                    data-stock="{{ $articulo->cantidad }}"
                                    data-articulo-id="{{ $articulo->id }}"
                                    data-almacen-id="{{ $almacen->id }}">
                                    Enviar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para enviar producto -->
    <div id="modal-enviar" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white w-96 rounded shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Enviar Producto</h2>
            <div>
                <p class="mb-2"><span class="font-bold">Producto:</span> <span id="modal-producto"></span></p>
                <label for="modal-cantidad" class="font-bold mb-2">Cantidad:</label>
                <input type="number" id="modal-cantidad" class="block w-full border border-gray-300 rounded p-2 mb-4"
                    min="1" />
                <label for="almacen-destino" class="font-bold mb-2">Selecciona el almacén:</label>
                <select id="almacen-destino" class="block w-full border border-gray-300 rounded p-2 mb-4">
                    <option value="">Selecciona un almacén</option>
                    @foreach ($almacenes as $almacenItem)
                        @if ($almacenItem->user_id === Auth::id())  <!-- Solo almacenes del usuario autenticado -->
                            @if ($almacenItem->id !== $almacen->id)
                                <option value="{{ $almacenItem->id }}">{{ $almacenItem->nombre }}</option>
                            @endif
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button id="btn-cancelar" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Cancelar
                </button>
                <button id="btn-enviar" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Enviar
                </button>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para enviar la transferencia -->
    <form method="POST" id="form-transferir" style="display: none;">
        @csrf
        <input type="hidden" name="almacen_destino_id" id="almacen-destino-id">
        <input type="hidden" name="cantidad" id="cantidad-enviar">
    </form>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Confirmar eliminación de un artículo con SweetAlert
        function deleteArticulo(almacenId, articuloId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Este artículo será eliminado de forma permanente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/almacenes/${almacenId}/articulos/${articuloId}') }}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Eliminado', 'El artículo ha sido eliminado.', 'success').then(() => {
                                });
                            } else {
                                Swal.fire('Error', 'No se pudo eliminar el artículo.', 'error');
                            }
                        });
                        location.reload();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const botonesEnviar = document.querySelectorAll('.btn-enviar');
            const modal = document.getElementById('modal-enviar');
            const modalProducto = document.getElementById('modal-producto');
            const modalCantidad = document.getElementById('modal-cantidad');
            const almacenDestino = document.getElementById('almacen-destino');
            const btnCancelar = document.getElementById('btn-cancelar');
            const btnEnviar = document.getElementById('btn-enviar');
            let stockDisponible = 0;
            let articuloId = null;
            let almacenId = null;

            // Abrir el modal al hacer clic en "Enviar"
            botonesEnviar.forEach((boton) => {
                boton.addEventListener('click', (e) => {
                    e.preventDefault();
                    const producto = boton.getAttribute('data-producto');
                    const cantidad = boton.getAttribute('data-cantidad');
                    stockDisponible = boton.getAttribute('data-stock');
                    articuloId = boton.getAttribute('data-articulo-id');
                    almacenId = boton.getAttribute('data-almacen-id');

                    modalProducto.textContent = producto;
                    modalCantidad.value = cantidad;
                    modalCantidad.max = stockDisponible;
                    modal.classList.remove('hidden');
                });
            });

            // Cerrar el modal
            btnCancelar.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Enviar el formulario de transferencia
            btnEnviar.addEventListener('click', () => {
                const cantidad = parseInt(modalCantidad.value);
                const almacenDestinoId = almacenDestino.value;

                // Validar la cantidad ingresada
                if (cantidad <= 0 || cantidad > stockDisponible) {
                    alert(`La cantidad debe estar entre 1 y ${stockDisponible}.`);
                    return;
                }

                // Configurar el formulario dinámicamente
                const form = document.getElementById('form-transferir');
                form.action = `/almacenes/${almacenId}/articulos/${articuloId}/transferir`;
                document.getElementById('almacen-destino-id').value = almacenDestinoId;
                document.getElementById('cantidad-enviar').value = cantidad;

                // Enviar el formulario
                form.submit();

                Swal.fire({
                    title: '¡Enviado!',
                    text: `El artículo fue enviado con éxito.`,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                });
            });
        });
    </script>
</x-app-layout>
