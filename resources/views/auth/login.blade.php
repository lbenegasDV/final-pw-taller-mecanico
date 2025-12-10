<x-guest-layout>
    {{-- Encabezado con logo y título --}}
    <div class="flex flex-col items-center mb-6">
        {{-- Logo simple del taller (podés luego reemplazar por una imagen) --}}
        <div class="h-14 w-14 rounded-xl bg-emerald-500/10 border border-emerald-500/40 flex items-center justify-center mb-3">
            <span class="text-emerald-300 font-bold text-xl">TM</span>
        </div>
        <h1 class="text-xl font-semibold text-slate-100">
            Taller Mecánico
        </h1>
        <p class="mt-1 text-sm text-slate-400 text-center">
            Iniciá sesión para gestionar clientes, vehículos, órdenes y repuestos.
        </p>
    </div>

    {{-- Mensajes de sesión --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Correo electrónico --}}
        <div>
            <x-input-label for="email" value="Correo electrónico" class="text-slate-300"/>
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Contraseña --}}
        <div>
            <x-input-label for="password" value="Contraseña" class="text-slate-300"/>

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Recordarme --}}
        <div class="flex items-center justify-between mt-2">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-slate-600 bg-slate-900 text-emerald-500 shadow-sm focus:ring-emerald-500 focus:ring-offset-0"
                    name="remember"
                >
                <span class="ms-2 text-sm text-slate-300">
                    Recordarme
                </span>
            </label>
        </div>

        {{-- Botón de acceso --}}
        <div class="mt-4">
            <x-primary-button class="w-full justify-center py-2.5 text-sm">
                Iniciar sesión
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
