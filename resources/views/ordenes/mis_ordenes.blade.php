<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Mis órdenes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 overflow-hidden shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <h3 class="text-lg font-semibold mb-4 border-b border-slate-800 pb-2">
                        Órdenes asignadas al mecánico
                    </h3>

                    <table class="min-w-full divide-y divide-slate-800">
                        <thead>
                        <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                            <th class="px-3 py-2">#</th>
                            <th class="px-3 py-2">Vehículo</th>
                            <th class="px-3 py-2">Cliente</th>
                            <th class="px-3 py-2">Ingreso</th>
                            <th class="px-3 py-2">Estado</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                        @forelse($ordenes as $orden)
                            <tr class="text-sm">
                                <td class="px-3 py-2">
                                    <a href="{{ route('ordenes.show', $orden) }}"
                                       class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-slate-800 text-emerald-300 border border-emerald-500/40 hover:bg-slate-700 hover:text-emerald-200 transition-colors">
                                        #{{ $orden->id }}
                                    </a>
                                </td>

                                <td class="px-3 py-2">
                                    @if($orden->vehiculo)
                                        {{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}
                                        <span class="text-slate-400">
                                            ({{ $orden->vehiculo->patente }})
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
                                    {{ $orden->fecha_ingreso?->format('d/m/Y H:i') }}
                                </td>

                                <td class="px-3 py-2">
                                    @php
                                        $estado = $orden->estado;
                                        $label = ucfirst(str_replace('_', ' ', $estado));

                                        $classes = match($estado) {
                                            'pendiente' => 'bg-amber-500/20 text-amber-200 border-amber-500/40',
                                            'en_proceso' => 'bg-sky-500/20 text-sky-200 border-sky-500/40',
                                            'finalizada' => 'bg-emerald-500/20 text-emerald-200 border-emerald-500/40',
                                            'cancelada' => 'bg-red-500/20 text-red-200 border-red-500/40',
                                            default => 'bg-slate-700 text-slate-200 border-slate-600',
                                        };
                                    @endphp

                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs border {{ $classes }}">
                                        {{ $label }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-4 text-center text-slate-400">
                                    No tenés órdenes asignadas.
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
