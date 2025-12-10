<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Órdenes de reparación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="flex justify-between mb-4">
                <div></div>
                <a href="{{ route('ordenes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-emerald-500/80 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 hover:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 focus:ring-offset-slate-950">
                    + Nueva orden
                </a>
            </div>

            <div class="bg-slate-900 overflow-hidden shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead>
                        <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                            <th class="px-3 py-2">#</th>
                            <th class="px-3 py-2">Vehículo</th>
                            <th class="px-3 py-2">Cliente</th>
                            <th class="px-3 py-2">Mecánico</th>
                            <th class="px-3 py-2">Ingreso</th>
                            <th class="px-3 py-2">Estado</th>
                            <th class="px-3 py-2 text-right">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                        @forelse($ordenes as $orden)
                            <tr class="text-sm">
                                <td class="px-3 py-2">
                                    #{{ $orden->id }}
                                </td>
                                <td class="px-3 py-2">
                                    @if($orden->vehiculo)
                                        {{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-slate-800 text-slate-100 border border-slate-700 ml-1">
                                            {{ $orden->vehiculo->patente }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">Sin vehículo</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    @if($orden->vehiculo && $orden->vehiculo->cliente)
                                        {{ $orden->vehiculo->cliente->nombre }}
                                        {{ $orden->vehiculo->cliente->apellido }}
                                    @else
                                        <span class="text-slate-400">Sin cliente</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    @if($orden->mecanico)
                                        {{ $orden->mecanico->nombre }} {{ $orden->mecanico->apellido }}
                                    @else
                                        <span class="text-slate-400">Sin mecánico</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2">
                                    {{ $orden->fecha_ingreso?->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 py-2">
                                    @php
                                        $estado = $orden->estado;
                                    @endphp
                                    @if($estado === 'pendiente')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-amber-500/20 text-amber-200 border border-amber-500/40">
                                            Pendiente
                                        </span>
                                    @elseif($estado === 'en_proceso')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-sky-500/20 text-sky-200 border border-sky-500/40">
                                            En proceso
                                        </span>
                                    @elseif($estado === 'finalizada')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-emerald-500/20 text-emerald-200 border border-emerald-500/40">
                                            Finalizada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-200 border border-red-500/40">
                                            Cancelada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right space-x-2">
                                    <a href="{{ route('ordenes.show', $orden) }}"
                                       class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-slate-800 text-slate-100 border border-slate-600 hover:bg-slate-700 hover:border-slate-500">
                                        Ver
                                    </a>

                                    <a href="{{ route('ordenes.edit', $orden) }}"
                                       class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-slate-800 text-slate-100 border border-slate-600 hover:bg-slate-700 hover:border-slate-500">
                                        Editar
                                    </a>

                                    <form action="{{ route('ordenes.destroy', $orden) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Seguro que desea eliminar esta orden?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-red-600 text-white hover:bg-red-500 border border-red-500/80">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-3 py-4 text-center text-slate-400">
                                    No hay órdenes registradas.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $ordenes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
