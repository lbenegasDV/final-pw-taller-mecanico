<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">
            Inicio
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Bloque de bienvenida --}}
            <div class="bg-slate-900 border border-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-100">
                    <h3 class="text-lg font-semibold mb-1">
                        Bienvenido al sistema de gestión del Taller Mecánico
                    </h3>
                    <p class="text-sm text-slate-300">
                        Estás autenticado como
                        <span class="font-semibold text-emerald-300">
                            {{ Auth::user()->rol }}
                        </span>.
                        Utilizá los accesos rápidos para ir directamente a los módulos que usás todos los días.
                    </p>
                </div>
            </div>

            {{-- Accesos rápidos, adaptados al rol --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                {{-- Clientes (Admin + Recepcionista) --}}
                @if(Auth::user()->esAdmin() || Auth::user()->esRecepcionista())
                    <a href="{{ route('clientes.index') }}"
                       class="bg-slate-900 border border-slate-800 rounded-xl p-4 hover:border-emerald-500/70 hover:bg-slate-900/80 transition-colors duration-150 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-semibold text-emerald-300 tracking-wide uppercase mb-1">
                                Gestión
                            </p>
                            <h4 class="text-base font-semibold text-slate-100">
                                Clientes
                            </h4>
                            <p class="mt-1 text-sm text-slate-400">
                                Alta, edición y listado de clientes del taller.
                            </p>
                        </div>
                        <div class="mt-3 text-xs text-slate-400 flex items-center justify-between">
                            <span>Ver clientes</span>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-800 text-slate-200">
                                →
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('vehiculos.index') }}"
                       class="bg-slate-900 border border-slate-800 rounded-xl p-4 hover:border-emerald-500/70 hover:bg-slate-900/80 transition-colors duration-150 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-semibold text-emerald-300 tracking-wide uppercase mb-1">
                                Gestión
                            </p>
                            <h4 class="text-base font-semibold text-slate-100">
                                Vehículos
                            </h4>
                            <p class="mt-1 text-sm text-slate-400">
                                Administración de vehículos asociados a cada cliente.
                            </p>
                        </div>
                        <div class="mt-3 text-xs text-slate-400 flex items-center justify-between">
                            <span>Ver vehículos</span>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-800 text-slate-200">
                                →
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('ordenes.index') }}"
                       class="bg-slate-900 border border-slate-800 rounded-xl p-4 hover:border-emerald-500/70 hover:bg-slate-900/80 transition-colors duration-150 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-semibold text-emerald-300 tracking-wide uppercase mb-1">
                                Operación
                            </p>
                            <h4 class="text-base font-semibold text-slate-100">
                                Órdenes de reparación
                            </h4>
                            <p class="mt-1 text-sm text-slate-400">
                                Creación y seguimiento de órdenes activas y finalizadas.
                            </p>
                        </div>
                        <div class="mt-3 text-xs text-slate-400 flex items-center justify-between">
                            <span>Ver órdenes</span>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-800 text-slate-200">
                                →
                            </span>
                        </div>
                    </a>
                @endif

                {{-- Repuestos + Mecánicos: solo Admin --}}
                @if(Auth::user()->esAdmin())
                    <a href="{{ route('repuestos.index') }}"
                       class="bg-slate-900 border border-slate-800 rounded-xl p-4 hover:border-emerald-500/70 hover:bg-slate-900/80 transition-colors duration-150 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-semibold text-emerald-300 tracking-wide uppercase mb-1">
                                Inventario
                            </p>
                            <h4 class="text-base font-semibold text-slate-100">
                                Repuestos
                            </h4>
                            <p class="mt-1 text-sm text-slate-400">
                                Gestión de catálogo, precios y stock disponible.
                            </p>
                        </div>
                        <div class="mt-3 text-xs text-slate-400 flex items-center justify-between">
                            <span>Ver repuestos</span>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-800 text-slate-200">
                                →
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('mecanicos.index') }}"
                       class="bg-slate-900 border border-slate-800 rounded-xl p-4 hover:border-emerald-500/70 hover:bg-slate-900/80 transition-colors duration-150 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-semibold text-emerald-300 tracking-wide uppercase mb-1">
                                Equipo
                            </p>
                            <h4 class="text-base font-semibold text-slate-100">
                                Mecánicos
                            </h4>
                            <p class="mt-1 text-sm text-slate-400">
                                Administración del equipo técnico y sus especialidades.
                            </p>
                        </div>
                        <div class="mt-3 text-xs text-slate-400 flex items-center justify-between">
                            <span>Ver mecánicos</span>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-800 text-slate-200">
                                →
                            </span>
                        </div>
                    </a>
                @endif

                {{-- Mis órdenes: Mecánico --}}
                @if(Auth::user()->esMecanico())
                    <a href="{{ route('ordenes.mis-ordenes') }}"
                       class="bg-slate-900 border border-slate-800 rounded-xl p-4 hover:border-emerald-500/70 hover:bg-slate-900/80 transition-colors duration-150 flex flex-col justify-between">
                        <div>
                            <p class="text-xs font-semibold text-emerald-300 tracking-wide uppercase mb-1">
                                Mi trabajo
                            </p>
                            <h4 class="text-base font-semibold text-slate-100">
                                Mis órdenes asignadas
                            </h4>
                            <p class="mt-1 text-sm text-slate-400">
                                Acceso directo a las órdenes donde estás asignado como mecánico.
                            </p>
                        </div>
                        <div class="mt-3 text-xs text-slate-400 flex items-center justify-between">
                            <span>Ver mis órdenes</span>
                            <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-slate-800 text-slate-200">
                                →
                            </span>
                        </div>
                    </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
