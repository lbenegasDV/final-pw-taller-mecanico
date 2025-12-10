<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
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
     * Listado de clientes.
     */
    public function index()
    {
        $this->authorizeAdminOrRecepcionista();

        $clientes = Cliente::orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $this->authorizeAdminOrRecepcionista();

        return view('clientes.create');
    }

    /**
     * Guardar nuevo cliente.
     */
    public function store(Request $request)
    {
        $this->authorizeAdminOrRecepcionista();

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:20', 'unique:clientes,dni'],
            'email' => ['required', 'email', 'max:255', 'unique:clientes,email'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->has('activo');

        Cliente::create($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Mostrar detalle (opcional).
     */
    public function show(Cliente $cliente)
    {
        $this->authorizeAdminOrRecepcionista();

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Cliente $cliente)
    {
        $this->authorizeAdminOrRecepcionista();

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $this->authorizeAdminOrRecepcionista();

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:20', 'unique:clientes,dni,' . $cliente->id],
            'email' => ['required', 'email', 'max:255', 'unique:clientes,email,' . $cliente->id],
            'telefono' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $data['activo'] = $request->has('activo');

        $cliente->update($data);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Eliminar cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $this->authorizeAdminOrRecepcionista();

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
