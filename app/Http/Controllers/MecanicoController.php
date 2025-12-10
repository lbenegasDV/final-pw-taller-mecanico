<?php

namespace App\Http\Controllers;

use App\Models\Mecanico;
use Illuminate\Http\Request;

class MecanicoController extends Controller
{
    public function __construct()
    {
        // Solo admin puede gestionar mecánicos
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            if (! $user || ! $user->esAdmin()) {
                abort(403, 'No tiene permisos para acceder a esta sección.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $mecanicos = Mecanico::orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('mecanicos.index', compact('mecanicos'));
    }

    public function create()
    {
        return view('mecanicos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:mecanicos,email'],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->has('activo');

        // user_id lo dejamos null; se usa solo para el mecánico que loguea
        Mecanico::create($data);

        return redirect()
            ->route('mecanicos.index')
            ->with('success', 'Mecánico creado correctamente.');
    }

    public function show(Mecanico $mecanico)
    {
        return view('mecanicos.show', compact('mecanico'));
    }

    public function edit(Mecanico $mecanico)
    {
        return view('mecanicos.edit', compact('mecanico'));
    }

    public function update(Request $request, Mecanico $mecanico)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:mecanicos,email,' . $mecanico->id],
            'especialidad' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->has('activo');

        $mecanico->update($data);

        return redirect()
            ->route('mecanicos.index')
            ->with('success', 'Mecánico actualizado correctamente.');
    }

    public function destroy(Mecanico $mecanico)
    {
        // En un sistema real se podría validar que no tenga órdenes activas
        $mecanico->delete();

        return redirect()
            ->route('mecanicos.index')
            ->with('success', 'Mecánico eliminado correctamente.');
    }
}
