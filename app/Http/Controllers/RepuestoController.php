<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use Illuminate\Http\Request;

class RepuestoController extends Controller
{
    public function __construct()
    {
        // Solo admin gestiona repuestos
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
        $repuestos = Repuesto::orderBy('nombre')->paginate(10);

        return view('repuestos.index', compact('repuestos'));
    }

    public function create()
    {
        return view('repuestos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'marca' => ['nullable', 'string', 'max:255'],
            'codigo_interno' => ['required', 'string', 'max:100', 'unique:repuestos,codigo_interno'],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'tipo' => ['required', 'in:motor,electronica,frenos,suspension,otros'],
        ]);

        Repuesto::create($data);

        return redirect()
            ->route('repuestos.index')
            ->with('success', 'Repuesto creado correctamente.');
    }

    public function show(Repuesto $repuesto)
    {
        return view('repuestos.show', compact('repuesto'));
    }

    public function edit(Repuesto $repuesto)
    {
        return view('repuestos.edit', compact('repuesto'));
    }

    public function update(Request $request, Repuesto $repuesto)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'marca' => ['nullable', 'string', 'max:255'],
            'codigo_interno' => ['required', 'string', 'max:100', 'unique:repuestos,codigo_interno,' . $repuesto->id],
            'precio' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'tipo' => ['required', 'in:motor,electronica,frenos,suspension,otros'],
        ]);

        $repuesto->update($data);

        return redirect()
            ->route('repuestos.index')
            ->with('success', 'Repuesto actualizado correctamente.');
    }

    public function destroy(Repuesto $repuesto)
    {
        // Si está usado en órdenes, mejor no borrarlo
        if ($repuesto->ordenes()->exists()) {
            return redirect()
                ->route('repuestos.index')
                ->with('error', 'No se puede eliminar un repuesto que ya fue utilizado en órdenes.');
        }

        $repuesto->delete();

        return redirect()
            ->route('repuestos.index')
            ->with('success', 'Repuesto eliminado correctamente.');
    }
}
