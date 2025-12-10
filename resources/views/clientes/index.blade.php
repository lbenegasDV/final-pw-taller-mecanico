<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-emerald-500/10 border border-emerald-500/60 px-4 py-3 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <div></div>
                <a href="{{ route('clientes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-emerald-500/80 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-500 hover:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950">
                    + Nuevo cliente
                </a>
            </div>

            <div class="bg-slate-900 overflow-hidden shadow-sm sm:rounded-lg border border-slate-800">
                <div class="p-6 text-slate-100">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead>
                        <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                            <th class="px-3 py-2">Nombre</th>
                            <th class="px-3 py-2">DNI</th>
                            <th class="px-3 py-2">Email</th>
                            <th class="px-3 py-2">Teléfono</th>
                            <th class="px-3 py-2">Estado</th>
                            <th class="px-3 py-2 text-right">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                        @forelse($clientes as $cliente)
                            <tr class="text-sm">
                                <td class="px-3 py-2">
                                    {{ $cliente->nombre }} {{ $cliente->apellido }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $cliente->dni }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $cliente->email }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ $cliente->telefono }}
                                </td>
                                <td class="px-3 py-2">
                                    @if($cliente->activo)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-emerald-500/15 text-emerald-300 border border-emerald-500/50">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-slate-800 text-slate-300 border border-slate-600">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 text-right space-x-2">
                                    <a href="{{ route('clientes.edit', $cliente) }}"
                                       class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-sky-600 text-white hover:bg-sky-500">
                                        Editar
                                    </a>

                                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Seguro que desea eliminar este cliente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-red-600 text-white hover:bg-red-500">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-3 py-4 text-center text-slate-400">
                                    No hay clientes registrados.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $clientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
