<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Nueva orden de reparación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-slate-800 pb-2">
                        Datos de la orden
                    </h3>

                    <form method="POST" action="{{ route('ordenes.store') }}" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Vehículo --}}
                            <div class="md:col-span-2">
                                <x-input-label for="vehiculo_id" value="Vehículo" class="text-slate-100" />
                                <select id="vehiculo_id" name="vehiculo_id"
                                        class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">-- Seleccione un vehículo --</option>
                                    @foreach($vehiculos as $vehiculo)
                                        <option value="{{ $vehiculo->id }}" @selected(old('vehiculo_id') == $vehiculo->id)>
                                            {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
                                            ({{ $vehiculo->patente }})
                                            @if($vehiculo->cliente)
                                                - {{ $vehiculo->cliente->nombre }} {{ $vehiculo->cliente->apellido }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vehiculo_id')" class="mt-2" />
                            </div>

                            {{-- Mecánico asignado --}}
                            <div class="md:col-span-2">
                                <x-input-label for="mecanico_id" value="Mecánico asignado" class="text-slate-100" />
                                <select id="mecanico_id" name="mecanico_id"
                                        class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">-- Seleccione un mecánico --</option>
                                    @foreach($mecanicos as $mecanico)
                                        <option value="{{ $mecanico->id }}" @selected(old('mecanico_id') == $mecanico->id)>
                                            {{ $mecanico->nombre }} {{ $mecanico->apellido }}
                                            @if($mecanico->especialidad)
                                                - {{ $mecanico->especialidad }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('mecanico_id')" class="mt-2" />
                            </div>

                            {{-- Fechas --}}
                            <div>
                                <x-input-label for="fecha_ingreso" value="Fecha de ingreso" class="text-slate-100" />
                                <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="datetime-local"
                                              class="mt-1 block w-full"
                                              :value="old('fecha_ingreso')" required />
                                <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="fecha_estimada_entrega" value="Fecha estimada de entrega" class="text-slate-100" />
                                <x-text-input id="fecha_estimada_entrega" name="fecha_estimada_entrega" type="datetime-local"
                                              class="mt-1 block w-full"
                                              :value="old('fecha_estimada_entrega')" required />
                                <x-input-error :messages="$errors->get('fecha_estimada_entrega')" class="mt-2" />
                            </div>

                            {{-- Descripción del problema --}}
                            <div class="md:col-span-2">
                                <x-input-label for="descripcion_problema" value="Descripción del problema" class="text-slate-100" />
                                <textarea id="descripcion_problema" name="descripcion_problema" rows="4"
                                          class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('descripcion_problema') }}</textarea>
                                <x-input-error :messages="$errors->get('descripcion_problema')" class="mt-2" />
                            </div>

                            {{-- Costo estimado --}}
                            <div class="md:col-span-2">
                                <x-input-label for="costo_estimado" value="Costo estimado (opcional)" class="text-slate-100" />
                                <x-text-input id="costo_estimado" name="costo_estimado" type="number" step="0.01" min="0"
                                              class="mt-1 block w-full"
                                              :value="old('costo_estimado')" />
                                <x-input-error :messages="$errors->get('costo_estimado')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('ordenes.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-md border border-slate-600 bg-slate-800 text-xs font-semibold uppercase tracking-widest text-slate-100 hover:bg-slate-700 hover:border-slate-500">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Guardar orden
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
