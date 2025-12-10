<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Editar repuesto
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-slate-800 pb-2">
                        Datos del repuesto
                    </h3>

                    <form method="POST" action="{{ route('repuestos.update', $repuesto) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nombre" value="Nombre" class="text-slate-100" />
                                <x-text-input id="nombre" name="nombre" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('nombre', $repuesto->nombre)" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="marca" value="Marca" class="text-slate-100" />
                                <x-text-input id="marca" name="marca" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('marca', $repuesto->marca)" />
                                <x-input-error :messages="$errors->get('marca')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="codigo_interno" value="Código interno" class="text-slate-100" />
                                <x-text-input id="codigo_interno" name="codigo_interno" type="text"
                                              class="mt-1 block w-full"
                                              :value="old('codigo_interno', $repuesto->codigo_interno)" required />
                                <x-input-error :messages="$errors->get('codigo_interno')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tipo" value="Tipo" class="text-slate-100" />
                                <select id="tipo" name="tipo"
                                        class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="motor" @selected(old('tipo', $repuesto->tipo) === 'motor')>Motor</option>
                                    <option value="electronica" @selected(old('tipo', $repuesto->tipo) === 'electronica')>Electrónica</option>
                                    <option value="frenos" @selected(old('tipo', $repuesto->tipo) === 'frenos')>Frenos</option>
                                    <option value="suspension" @selected(old('tipo', $repuesto->tipo) === 'suspension')>Suspensión</option>
                                    <option value="otros" @selected(old('tipo', $repuesto->tipo) === 'otros')>Otros</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="precio" value="Precio" class="text-slate-100" />
                                <x-text-input id="precio" name="precio" type="number" step="0.01" min="0.01"
                                              class="mt-1 block w-full"
                                              :value="old('precio', $repuesto->precio)" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stock" value="Stock" class="text-slate-100" />
                                <x-text-input id="stock" name="stock" type="number" min="0"
                                              class="mt-1 block w-full"
                                              :value="old('stock', $repuesto->stock)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('repuestos.index') }}"
                               class="inline-flex items-center px-4 py-2 rounded-md border border-slate-600 bg-slate-800 text-xs font-semibold uppercase tracking-widest text-slate-100 hover:bg-slate-700 hover:border-slate-500">
                                Cancelar
                            </a>

                            <x-primary-button>
                                Guardar cambios
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
