<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Nuevo mecánico
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-slate-800 pb-2">
                        Datos del mecánico
                    </h3>

                    <form method="POST" action="{{ route('mecanicos.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nombre" value="Nombre" class="text-slate-100" />
                                <x-text-input id="nombre" name="nombre" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('nombre')" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="apellido" value="Apellido" class="text-slate-100" />
                                <x-text-input id="apellido" name="apellido" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('apellido')" required />
                                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="email" value="Correo electrónico" class="text-slate-100" />
                                <x-text-input id="email" name="email" type="email"
                                              class="mt-1 block w-full"
                                              :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="especialidad" value="Especialidad" class="text-slate-100" />
                                <x-text-input id="especialidad" name="especialidad" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('especialidad')" />
                                <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="telefono" value="Teléfono" class="text-slate-100" />
                                <x-text-input id="telefono" name="telefono" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('telefono')" />
                                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2 flex items-center mt-2">
                                <input id="activo" name="activo" type="checkbox" value="1"
                                       class="rounded border-slate-700 bg-slate-950 text-emerald-500 shadow-sm focus:ring-emerald-500"
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label for="activo" class="ml-2 text-sm text-slate-200">
                                    Mecánico activo
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('mecanicos.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-md border border-slate-600 bg-slate-800 text-xs font-semibold uppercase tracking-widest text-slate-100 hover:bg-slate-700 hover:border-slate-500">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Guardar mecánico
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
