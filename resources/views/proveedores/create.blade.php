<x-app-layout>
    <header class="bg-blue-200">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center">
                <h1 class="text-2xl font-bold">Agregar Proveedor</h1>
            </div>
        </div>
    </header>

    <div class="bg-blue-200 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action=" {{ route('proveedores.store') }} " method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div class="flex items-center">
                        <label for="nombre" class="w-1/4">Nombre del proveedor:</label>
                        <input type="text" name="nombre" id="nombre" class="w-3/4 px-4 py-2 border rounded" required>
                    </div>

                    <div class="flex items-center">
                        <label for="telefono" class="w-1/4">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" class="w-3/4 px-4 py-2 border rounded" required>
                    </div>

                    <div class="flex items-center">
                        <label for="email" class="w-1/4">Correo electrónico:</label>
                        <input type="email" name="email" id="email" class="w-3/4 px-4 py-2 border rounded" required>
                    </div>

                    <div class="flex items-center">
                        <label for="direccion" class="w-1/4">Dirección:</label>
                        <textarea name="direccion" id="direccion" class="w-3/4 px-4 py-2 border rounded" required></textarea>
                    </div>

                    <div class="flex items-center">
                        <label for="formaPago" class="w-1/4">Forma de pago:</label>
                        <select name="formaPago" id="formaPago"
                            class="w-3/4 px-4 py-2 border rounded">
                            <option value="">Elige una forma de pago</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="efectivo">Efectivo</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">
                            Guardar Proveedor
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
