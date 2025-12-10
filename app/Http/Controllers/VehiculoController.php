<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    /**
     * Verifica que el usuario sea admin o recepcionista.
     */
    private function authorizeAdminOrRecepcionista(): void
    {
        $user = auth()->user();

        if (! $user || (! $user->esAdmin() && ! $user->esRecepcionista())) {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }
    }

    /**
     * Listado de vehículos.
     */
    public function index()
    {
        $this->authorizeAdminOrRecepcionista();

        $vehiculos = Vehiculo::with('cliente')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('vehiculos.index', compact('vehiculos'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $this->authorizeAdminOrRecepcionista();

        // Solo clientes activos pueden recibir vehículos nuevos
        $clientes = Cliente::where('activo', true)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('vehiculos.create', compact('clientes'));
    }

    /**
     * Guardar nuevo vehículo.
     */
    public function store(Request $request)
    {
        $this->authorizeAdminOrRecepcionista();

        $data = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'anio' => ['required', 'integer', 'min:1980'],
            'patente' => ['required', 'string', 'max:20', 'unique:vehiculos,patente'],
            'tipo' => ['required', 'in:auto,moto,camioneta'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $cliente = Cliente::findOrFail($data['cliente_id']);

        if (! $cliente->activo) {
            return back()
                ->withErrors(['cliente_id' => 'No se pueden registrar vehículos para clientes inactivos.'])
                ->withInput();
        }

        $data['activo'] = $request->has('activo');

        Vehiculo::create($data);

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo creado correctamente.');
    }

    /**
     * Mostrar detalle (opcional).
     */
    public function show(Vehiculo $vehiculo)
    {
        $this->authorizeAdminOrRecepcionista();

        $vehiculo->load('cliente');

        return view('vehiculos.show', compact('vehiculo'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Vehiculo $vehiculo)
    {
        $this->authorizeAdminOrRecepcionista();

        // Podés permitir seleccionar solo clientes activos para reasignar
        $clientes = Cliente::orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('vehiculos.edit', compact('vehiculo', 'clientes'));
    }

    /**
     * Actualizar vehículo.
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $this->authorizeAdminOrRecepcionista();

        $data = $request->validate([
            'cliente_id' => ['required', 'exists:clientes,id'],
            'marca' => ['required', 'string', 'max:255'],
            'modelo' => ['required', 'string', 'max:255'],
            'anio' => ['required', 'integer', 'min:1980'],
            'patente' => ['required', 'string', 'max:20', 'unique:vehiculos,patente,' . $vehiculo->id],
            'tipo' => ['required', 'in:auto,moto,camioneta'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $cliente = Cliente::findOrFail($data['cliente_id']);

        // Regla de negocio: no activar vehículo para cliente inactivo
        if (! $cliente->activo && $request->has('activo')) {
            return back()
                ->withErrors(['cliente_id' => 'No se puede activar un vehículo cuyo cliente está inactivo.'])
                ->withInput();
        }

        $data['activo'] = $request->has('activo');

        $vehiculo->update($data);

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado correctamente.');
    }

    /**
     * Eliminar vehículo.
     */
    public function destroy(Vehiculo $vehiculo)
    {
        $this->authorizeAdminOrRecepcionista();

        // En un sistema real podríamos validar que no tenga órdenes activas
        $vehiculo->delete();

        return redirect()
            ->route('vehiculos.index')
            ->with('success', 'Vehículo eliminado correctamente.');
    }
}
