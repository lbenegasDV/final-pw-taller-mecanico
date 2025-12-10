<nav x-data="{ open: false }" class="bg-slate-950 border-b border-slate-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo / Marca -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2">
                        <div class="h-8 w-8 rounded-xl bg-emerald-500/10 border border-emerald-500/50 flex items-center justify-center">
                            <span class="text-emerald-300 font-bold text-sm">TM</span>
                        </div>
                        <span class="text-slate-100 font-semibold text-sm sm:text-base">
                            Taller Mecánico
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                    <div class="hidden space-x-2 sm:-my-px sm:ml-10 sm:flex">
                        {{-- Inicio (Dashboard) --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Inicio
                        </x-nav-link>

                        {{-- Clientes, Vehículos, Órdenes: Admin + Recepcionista --}}
                        @if(auth()->user()->esAdmin() || auth()->user()->esRecepcionista())
                            <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">
                                Clientes
                            </x-nav-link>

                            <x-nav-link :href="route('vehiculos.index')" :active="request()->routeIs('vehiculos.*')">
                                Vehículos
                            </x-nav-link>

                            <x-nav-link :href="route('ordenes.index')" :active="request()->routeIs('ordenes.index')">
                                Órdenes
                            </x-nav-link>
                        @endif

                        {{-- Mecánicos: solo Admin --}}
                        @if(auth()->user()->esAdmin())
                            <x-nav-link :href="route('mecanicos.index')" :active="request()->routeIs('mecanicos.*')">
                                Mecánicos
                            </x-nav-link>
                        @endif

                        {{-- Repuestos: solo Admin --}}
                        @if(auth()->user()->esAdmin())
                            <x-nav-link :href="route('repuestos.index')" :active="request()->routeIs('repuestos.*')">
                                Repuestos
                            </x-nav-link>
                        @endif

                        {{-- Vista para Mecánico: sus órdenes --}}
                        @if(auth()->user()->esMecanico())
                            <x-nav-link :href="route('ordenes.mis-ordenes')" :active="request()->routeIs('ordenes.mis-ordenes')">
                                Mis órdenes
                            </x-nav-link>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-slate-700 text-sm leading-4 font-medium rounded-md text-slate-100 bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-slate-950 transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-slate-300 hover:text-slate-100 hover:bg-slate-800 focus:outline-none focus:bg-slate-800 focus:text-slate-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-slate-950 border-t border-slate-800">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Inicio
                </x-responsive-nav-link>

                @if(auth()->user()->esAdmin() || auth()->user()->esRecepcionista())
                    <x-responsive-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">
                        Clientes
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('vehiculos.index')" :active="request()->routeIs('vehiculos.*')">
                        Vehículos
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('ordenes.index')" :active="request()->routeIs('ordenes.index')">
                        Órdenes
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->esAdmin())
                    <x-responsive-nav-link :href="route('mecanicos.index')" :active="request()->routeIs('mecanicos.*')">
                        Mecánicos
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('repuestos.index')" :active="request()->routeIs('repuestos.*')">
                        Repuestos
                    </x-responsive-nav-link>
                @endif

                @if(auth()->user()->esMecanico())
                    <x-responsive-nav-link :href="route('ordenes.mis-ordenes')" :active="request()->routeIs('ordenes.mis-ordenes')">
                        Mis órdenes
                    </x-responsive-nav-link>
                @endif
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-slate-800">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-100">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
