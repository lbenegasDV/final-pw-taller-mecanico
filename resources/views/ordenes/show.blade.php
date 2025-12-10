<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Orden #{{ $orden->id }}
        </h2>
    </x-slot>

    <div class="py-6 space-y-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-emerald-500/10 border border-emerald-500/40 px-4 py-3 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-md bg-red-500/10 border border-red-500/40 px-4 py-3 text-sm text-red-200">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Datos principales de la orden --}}
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800 mb-6">
                <div class="p-6 text-slate-100 space-y-5">
                    {{-- Encabezado --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div>
                            <p class="text-xs font-medium tracking-wide text-slate-400 uppercase">
                                Orden de reparación
                            </p>
                            <p class="text-2xl font-semibold mt-1">
                                #{{ $orden->id }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @php $estado = $orden->estado; @endphp
                            @if($estado === 'pendiente')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-amber-500/20 text-amber-200 border border-amber-500/40">
                                    Pendiente
                                </span>
                            @elseif($estado === 'en_proceso')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-sky-500/20 text-sky-200 border border-sky-500/40">
                                    En proceso
                                </span>
                            @elseif($estado === 'finalizada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-emerald-500/20 text-emerald-200 border border-emerald-500/40">
                                    Finalizada
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-red-500/20 text-red-200 border border-red-500/40">
                                    Cancelada
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Grid de información resumida --}}
                    <div class="grid md:grid-cols-2 gap-4 text-sm mt-2">
                        {{-- Vehículo / Cliente --}}
                        <div class="rounded-lg bg-slate-950/40 border border-slate-800 px-4 py-3">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                                Vehículo
                            </p>
                            <p class="mt-1">
                                @if($orden->vehiculo)
                                    <span class="font-medium">
                                        {{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 ml-1 rounded-full text-[11px] bg-slate-800 text-slate-100 border border-slate-700 align-middle">
                                        {{ $orden->vehiculo->patente }}
                                    </span>
                                    <br>
                                    <span class="text-xs text-slate-400">
                                        Cliente:
                                        @if($orden->vehiculo->cliente)
                                            {{ $orden->vehiculo->cliente->nombre }}
                                            {{ $orden->vehiculo->cliente->apellido }}
                                        @else
                                            Sin cliente
                                        @endif
                                    </span>
                                @else
                                    <span class="text-slate-400">Sin vehículo</span>
                                @endif
                            </p>
                        </div>

                        {{-- Mecánico --}}
                        <div class="rounded-lg bg-slate-950/40 border border-slate-800 px-4 py-3">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                                Mecánico asignado
                            </p>
                            <p class="mt-1">
                                @if($orden->mecanico)
                                    <span class="font-medium">
                                        {{ $orden->mecanico->nombre }} {{ $orden->mecanico->apellido }}
                                    </span>
                                    @if($orden->mecanico->especialidad)
                                        <span class="text-xs text-slate-400">
                                            – {{ $orden->mecanico->especialidad }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-slate-400">Sin mecánico</span>
                                @endif
                            </p>
                        </div>

                        {{-- Fechas --}}
                        <div class="rounded-lg bg-slate-950/40 border border-slate-800 px-4 py-3">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                                Fechas
                            </p>
                            <p class="mt-1 space-y-0.5">
                                <span class="block">
                                    <span class="text-slate-400">Ingreso:</span>
                                    <span class="ml-1">
                                        {{ $orden->fecha_ingreso?->format('d/m/Y H:i') ?? '-' }}
                                    </span>
                                </span>
                                <span class="block">
                                    <span class="text-slate-400">Estimada entrega:</span>
                                    <span class="ml-1">
                                        {{ $orden->fecha_estimada_entrega?->format('d/m/Y H:i') ?? '-' }}
                                    </span>
                                </span>
                                <span class="block">
                                    <span class="text-slate-400">Salida:</span>
                                    <span class="ml-1">
                                        {{ $orden->fecha_salida?->format('d/m/Y H:i') ?? '-' }}
                                    </span>
                                </span>
                            </p>
                        </div>

                        {{-- Costos --}}
                        <div class="rounded-lg bg-slate-950/40 border border-slate-800 px-4 py-3">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                                Costos
                            </p>
                            <p class="mt-1 space-y-0.5">
                                <span class="block">
                                    <span class="text-slate-400">Estimado:</span>
                                    <span class="ml-1">
                                        {{ $orden->costo_estimado !== null ? '$ '.number_format($orden->costo_estimado, 2, ',', '.') : '-' }}
                                    </span>
                                </span>
                                <span class="block">
                                    <span class="text-slate-400">Final:</span>
                                    <span class="ml-1 font-medium">
                                        {{ $orden->costo_final !== null ? '$ '.number_format($orden->costo_final, 2, ',', '.') : '-' }}
                                    </span>
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Descripción del problema --}}
                    <div class="pt-4 border-t border-slate-800 mt-2">
                        <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                            Descripción del problema
                        </p>
                        <p class="mt-1 text-sm leading-relaxed">
                            {{ $orden->descripcion_problema }}
                        </p>
                    </div>

                    @php
                        $esMecanicoAsignado = $user->esMecanico()
                            && $orden->mecanico
                            && $orden->mecanico->user_id === $user->id;
                    @endphp

                    {{-- Bloque para actualizar estado (mecánico asignado) --}}
                    @if($esMecanicoAsignado && $orden->estado !== 'cancelada')
                        <div class="mt-4 pt-4 border-t border-slate-800">
                            <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase mb-2">
                                Actualizar estado (mecánico asignado)
                            </p>

                            <form method="POST" action="{{ route('ordenes.update', $orden) }}" class="space-y-3">
                                @csrf
                                @method('PUT')

                                {{-- Campos ocultos necesarios para pasar la validación del update --}}
                                <input type="hidden" name="vehiculo_id" value="{{ $orden->vehiculo_id }}">
                                <input type="hidden" name="mecanico_id" value="{{ $orden->mecanico_id }}">
                                <input type="hidden" name="fecha_ingreso"
                                       value="{{ $orden->fecha_ingreso ? $orden->fecha_ingreso->format('Y-m-d H:i:s') : '' }}">
                                <input type="hidden" name="fecha_estimada_entrega"
                                       value="{{ $orden->fecha_estimada_entrega ? $orden->fecha_estimada_entrega->format('Y-m-d H:i:s') : '' }}">
                                <input type="hidden" name="descripcion_problema" value="{{ $orden->descripcion_problema }}">
                                @if($orden->costo_estimado !== null)
                                    <input type="hidden" name="costo_estimado" value="{{ $orden->costo_estimado }}">
                                @endif

                                <div class="grid md:grid-cols-3 gap-4 items-end">
                                    <div>
                                        <x-input-label for="estado" value="Nuevo estado" class="text-slate-100" />
                                        <select id="estado" name="estado"
                                                class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                            <option value="pendiente" @selected(old('estado', $orden->estado) === 'pendiente')>
                                                Pendiente
                                            </option>
                                            <option value="en_proceso" @selected(old('estado', $orden->estado) === 'en_proceso')>
                                                En proceso
                                            </option>
                                            <option value="finalizada" @selected(old('estado', $orden->estado) === 'finalizada')>
                                                Finalizada
                                            </option>
                                            {{-- No ofrecemos "cancelada" al mecánico --}}
                                        </select>
                                        <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="fecha_salida" value="Fecha de salida (si se finaliza)" class="text-slate-100" />
                                        <x-text-input id="fecha_salida" name="fecha_salida" type="datetime-local"
                                                      class="mt-1 block w-full"
                                                      :value="old('fecha_salida', $orden->fecha_salida ? $orden->fecha_salida->format('Y-m-d\TH:i') : '')" />
                                        <x-input-error :messages="$errors->get('fecha_salida')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="costo_final" value="Costo final (si se finaliza)" class="text-slate-100" />
                                        <x-text-input id="costo_final" name="costo_final" type="number" step="0.01" min="0"
                                                      class="mt-1 block w-full"
                                                      :value="old('costo_final', $orden->costo_final)" />
                                        <x-input-error :messages="$errors->get('costo_final')" class="mt-2" />
                                    </div>
                                </div>

                                <p class="text-xs text-slate-400">
                                    Si marcás la orden como <strong>finalizada</strong>, la fecha de salida y el costo final son obligatorios.
                                </p>

                                <div class="flex justify-end">
                                    <x-primary-button>
                                        Actualizar estado
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Repuestos utilizados --}}
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800 mb-6">
                <div class="p-6 text-slate-100 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-lg">
                            Repuestos utilizados
                        </h3>

                        @if(($user->esAdmin() || $user->esRecepcionista()) && $orden->esActiva())
                            <form method="POST" action="{{ route('ordenes.repuestos.store', $orden) }}" class="flex flex-wrap gap-3 items-end">
                                @csrf
                                <div>
                                    <x-input-label for="repuesto_id" value="Repuesto" class="text-slate-100" />
                                    <select id="repuesto_id" name="repuesto_id"
                                            class="mt-1 block w-56 rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                        <option value="">-- Seleccione --</option>
                                        @foreach($repuestosDisponibles as $repuesto)
                                            <option value="{{ $repuesto->id }}"
                                                @if(old('repuesto_id') == $repuesto->id) selected @endif>
                                                {{ $repuesto->nombre }} (stock: {{ $repuesto->stock }}) - $ {{ number_format($repuesto->precio, 2, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('repuesto_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="cantidad" value="Cantidad" class="text-slate-100" />
                                    <x-text-input id="cantidad" name="cantidad" type="number" min="1"
                                                  class="mt-1 block w-24"
                                                  :value="old('cantidad', 1)" />
                                    <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                                </div>

                                <div>
                                    <x-primary-button class="mt-5">
                                        Agregar
                                    </x-primary-button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <table class="min-w-full divide-y divide-slate-800 text-sm">
                        <thead>
                        <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                            <th class="px-3 py-2">Repuesto</th>
                            <th class="px-3 py-2">Tipo</th>
                            <th class="px-3 py-2">Precio unitario</th>
                            <th class="px-3 py-2">Cantidad</th>
                            <th class="px-3 py-2">Subtotal</th>
                            @if($user->esAdmin() || $user->esRecepcionista())
                                <th class="px-3 py-2 text-right">Acciones</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                        @forelse($orden->repuestos as $rep)
                            <tr>
                                <td class="px-3 py-2">
                                    {{ $rep->nombre }}
                                    @if($rep->codigo_interno)
                                        <span class="text-xs text-slate-400">({{ $rep->codigo_interno }})</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    {{ ucfirst($rep->tipo) }}
                                </td>
                                <td class="px-3 py-2">
                                    $ {{ number_format($rep->precio, 2, ',', '.') }}
                                </td>
                                <td class="px-3 py-2">
                                    @if(($user->esAdmin() || $user->esRecepcionista()) && $orden->esActiva())
                                        <form method="POST"
                                              action="{{ route('ordenes.repuestos.update', [$orden, $rep->pivot->id]) }}"
                                              class="inline-flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <x-text-input name="cantidad" type="number" min="1"
                                                          class="w-20"
                                                          :value="old('cantidad_'.$rep->pivot->id, $rep->pivot->cantidad)" />
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs rounded-md bg-slate-800 text-slate-100 border border-slate-600 hover:bg-slate-700 hover:border-slate-500">
                                                Actualizar
                                            </button>
                                        </form>
                                    @else
                                        {{ $rep->pivot->cantidad }}
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    $ {{ number_format($rep->pivot->subtotal, 2, ',', '.') }}
                                </td>
                                @if($user->esAdmin() || $user->esRecepcionista())
                                    <td class="px-3 py-2 text-right">
                                        @if($orden->esActiva())
                                            <form method="POST"
                                                  action="{{ route('ordenes.repuestos.destroy', [$orden, $rep->pivot->id]) }}"
                                                  onsubmit="return confirm('¿Eliminar este repuesto de la orden?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-500 border border-red-500/80">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ ($user->esAdmin() || $user->esRecepcionista()) ? 6 : 5 }}"
                                    class="px-3 py-4 text-center text-slate-400">
                                    No hay repuestos cargados para esta orden.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Historial de trabajo --}}
            <div class="bg-slate-900 shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-lg">
                            Historial de trabajo
                        </h3>

                        @php
                            $puedeCargarHistorial = $orden->estado === 'en_proceso' &&
                                (
                                    ($user->esMecanico() && $orden->mecanico && $orden->mecanico->user_id === $user->id)
                                    || $user->esAdmin()
                                );
                        @endphp

                        @if($puedeCargarHistorial)
                            <form method="POST" action="{{ route('ordenes.historial.store', $orden) }}" class="flex flex-wrap gap-3 items-end">
                                @csrf
                                <div>
                                    <x-input-label for="fecha" value="Fecha" class="text-slate-100" />
                                    <x-text-input id="fecha" name="fecha" type="date"
                                                  class="mt-1 block w-full"
                                                  :value="old('fecha', now()->format('Y-m-d'))" />
                                    <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="horas_trabajadas" value="Horas" class="text-slate-100" />
                                    <x-text-input id="horas_trabajadas" name="horas_trabajadas" type="number" step="0.1" min="0.1"
                                                  class="mt-1 block w-24"
                                                  :value="old('horas_trabajadas', 1)" />
                                    <x-input-error :messages="$errors->get('horas_trabajadas')" class="mt-2" />
                                </div>

                                <div class="w-64">
                                    <x-input-label for="descripcion" value="Descripción" class="text-slate-100" />
                                    <textarea id="descripcion" name="descripcion" rows="2"
                                              class="mt-1 block w-full rounded-md border-slate-700 bg-slate-950 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('descripcion') }}</textarea>
                                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                                </div>

                                <div>
                                    <x-primary-button class="mt-5">
                                        Agregar
                                    </x-primary-button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <table class="min-w-full divide-y divide-slate-800 text-sm">
                        <thead>
                        <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                            <th class="px-3 py-2">Fecha</th>
                            <th class="px-3 py-2">Mecánico</th>
                            <th class="px-3 py-2">Horas</th>
                            <th class="px-3 py-2">Descripción</th>
                            @if($user->esMecanico() || $user->esAdmin())
                                <th class="px-3 py-2 text-right">Acciones</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                        @forelse($orden->historialTrabajos as $hist)
                            <tr>
                                <td class="px-3 py-2">
                                    {{ $hist->fecha?->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-2">
                                    @if($hist->mecanico)
                                        {{ $hist->mecanico->nombre }} {{ $hist->mecanico->apellido }}
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    {{ $hist->horas_trabajadas }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $hist->descripcion }}
                                </td>

                                @if($user->esAdmin() || ($user->esMecanico() && $orden->mecanico && $orden->mecanico->user_id === $user->id))
                                    <td class="px-3 py-2 text-right">
                                        @if($orden->estado === 'en_proceso')
                                            {{-- Form inline para actualizar (ejemplo simple de update) --}}
                                            <form method="POST"
                                                  action="{{ route('ordenes.historial.update', [$orden, $hist]) }}"
                                                  class="inline-block mb-1">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="fecha" value="{{ $hist->fecha?->format('Y-m-d') }}">
                                                <input type="hidden" name="horas_trabajadas" value="{{ $hist->horas_trabajadas }}">
                                                <input type="hidden" name="descripcion" value="{{ $hist->descripcion }}">
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 text-xs rounded-md bg-slate-800 text-slate-100 border border-slate-600 hover:bg-slate-700 hover:border-slate-500">
                                                    Reiniciar datos (ejemplo update)
                                                </button>
                                            </form>

                                            <form method="POST"
                                                  action="{{ route('ordenes.historial.destroy', [$orden, $hist]) }}"
                                                  class="inline-block"
                                                  onsubmit="return confirm('¿Eliminar esta entrada de historial?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-500 border border-red-500/80">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ ($user->esMecanico() || $user->esAdmin()) ? 5 : 4 }}"
                                    class="px-3 py-4 text-center text-slate-400">
                                    No hay historial registrado para esta orden.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
