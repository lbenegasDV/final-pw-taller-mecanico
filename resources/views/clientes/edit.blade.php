<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Editar cliente
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <form method="POST" action="{{ route('clientes.update', $cliente) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nombre" value="Nombre" class="text-slate-200" />
                                <x-text-input
                                    id="nombre"
                                    name="nombre"
                                    type="text"
                                    class="mt-1 block w-full bg-slate-950 border-slate-700 text-slate-100 placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500"
                                    :value="old('nombre', $cliente->nombre)"
                                    required
                                    autofocus
                                />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="apellido" value="Apellido" class="text-slate-200" />
                                <x-text-input
                                    id="apellido"
                                    name="apellido"
                                    type="text"
                                    class="mt-1 block w-full bg-slate-950 border-slate-700 text-slate-100 placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500"
                                    :value="old('apellido', $cliente->apellido)"
                                    required
                                />
                                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="dni" value="DNI" class="text-slate-200" />
                                <x-text-input
                                    id="dni"
                                    name="dni"
                                    type="text"
                                    class="mt-1 block w-full bg-slate-950 border-slate-700 text-slate-100 placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500"
                                    :value="old('dni', $cliente->dni)"
                                    required
                                />
                                <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" value="Correo electrónico" class="text-slate-200" />
                                <x-text-input
                                    id="email"
                                    name="email"
                                    type="email"
                                    class="mt-1 block w-full bg-slate-950 border-slate-700 text-slate-100 placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500"
                                    :value="old('email', $cliente->email)"
                                    required
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="telefono" value="Teléfono" class="text-slate-200" />
                                <x-text-input
                                    id="telefono"
                                    name="telefono"
                                    type="text"
                                    class="mt-1 block w-full bg-slate-950 border-slate-700 text-slate-100 placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500"
                                    :value="old('telefono', $cliente->telefono)"
                                />
                                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="direccion" value="Dirección" class="text-slate-200" />
                                <x-text-input
                                    id="direccion"
                                    name="direccion"
                                    type="text"
                                    class="mt-1 block w-full bg-slate-950 border-slate-700 text-slate-100 placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500"
                                    :value="old('direccion', $cliente->direccion)"
                                />
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2 flex items-center mt-2">
                                <input
                                    id="activo"
                                    name="activo"
                                    type="checkbox"
                                    value="1"
                                    class="rounded border-slate-700 bg-slate-950 text-emerald-500 shadow-sm focus:ring-emerald-500 focus:ring-offset-0"
                                    {{ old('activo', $cliente->activo) ? 'checked' : '' }}
                                >
                                <label for="activo" class="ml-2 text-sm text-slate-200">
                                    Cliente activo
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('clientes.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-md border border-slate-600 bg-slate-800 text-xs font-semibold uppercase tracking-widest text-slate-100 hover:bg-slate-700 hover:border-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Actualizar
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
