<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Nuevo vehículo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-slate-800 pb-2">
                        Datos del vehículo
                    </h3>

                    <form method="POST" action="{{ route('vehiculos.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <x-input-label for="cliente_id" value="Cliente" class="text-slate-100" />
                                <select id="cliente_id" name="cliente_id"
                                        class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">-- Seleccione un cliente --</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" @selected(old('cliente_id') == $cliente->id)>
                                            {{ $cliente->nombre }} {{ $cliente->apellido }} (DNI: {{ $cliente->dni }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="marca" value="Marca" class="text-slate-100" />
                                <x-text-input id="marca" name="marca" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('marca')" required />
                                <x-input-error :messages="$errors->get('marca')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="modelo" value="Modelo" class="text-slate-100" />
                                <x-text-input id="modelo" name="modelo" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('modelo')" required />
                                <x-input-error :messages="$errors->get('modelo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="anio" value="Año" class="text-slate-100" />
                                <x-text-input id="anio" name="anio" type="number" min="1980"
                                              class="mt-1 block w-full"
                                              :value="old('anio')" required />
                                <x-input-error :messages="$errors->get('anio')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="patente" value="Patente" class="text-slate-100" />
                                <x-text-input id="patente" name="patente" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('patente')" required />
                                <x-input-error :messages="$errors->get('patente')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tipo" value="Tipo" class="text-slate-100" />
                                <select id="tipo" name="tipo"
                                        class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">-- Seleccione tipo --</option>
                                    <option value="auto" @selected(old('tipo') === 'auto')>Auto</option>
                                    <option value="moto" @selected(old('tipo') === 'moto')>Moto</option>
                                    <option value="camioneta" @selected(old('tipo') === 'camioneta')>Camioneta</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2 flex items-center mt-2">
                                <input id="activo" name="activo" type="checkbox" value="1"
                                       class="rounded border-slate-700 bg-slate-950 text-emerald-500 shadow-sm focus:ring-emerald-500"
                                       {{ old('activo', true) ? 'checked' : '' }}>
                                <label for="activo" class="ml-2 text-sm text-slate-200">
                                    Vehículo activo
                                </label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('vehiculos.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-md border border-slate-600 bg-slate-800 text-xs font-semibold uppercase tracking-widest text-slate-100 hover:bg-slate-700 hover:border-slate-500">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Guardar vehículo
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
