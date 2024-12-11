<x-app-layout>
    <div class="bg-blue-200 text-white p-4 rounded-lg" style="min-height: 60px;">
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @if($user->tipo === 'admin') 
                        @include('profile.partials.update-profile-information-form')
                    @else 
                        <div class="max-w-xl space-y-4">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Información del Perfil</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Nombre: <span class="font-medium">{{ $user->name }}</span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                Correo electrónico: <span class="font-medium">{{ $user->email }}</span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                Teléfono: <span class="font-medium">{{ $user->telefono }}</span>
                            </p>
                            <p class="text-gray-600 dark:text-gray-300">
                                RFC: <span class="font-medium">{{ $user->rfc }}</span>
                            </p>
                        </div>
                        
                    @endif
                </div>
            </div>
            @if($user->tipo === 'admin') 
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @if($user->tipo === 'admin')     
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                @else 
                    <div class="max-w-6xl">
                        <p class="text-gray-600 dark:text-gray-300 text-center max-w-6xl pb-6">
                            Si desea realizar un cambio en sus datos, favor de contactarse con el administrador
                        </p>
                        <p class="text-gray-600 dark:text-gray-300 text-center max-w-6xl">
                            DATOS DE CONTACTO <br>
                            Teléfono: 8341111111 <br>
                            Correo electrónico: angela@gmail.com
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
