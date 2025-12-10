<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\OrdenRepuesto;
use App\Models\Repuesto;
use Illuminate\Http\Request;

class OrdenRepuestoController extends Controller
{
    public function __construct()
    {
        // Admin + recepcionista gestionan repuestos de una orden
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            if (! $user || (! $user->esAdmin() && ! $user->esRecepcionista())) {
                abort(403, 'No tiene permisos para gestionar repuestos en las órdenes.');
            }

            return $next($request);
        });
    }

    /**
     * Agregar un repuesto a una orden.
     */
    public function store(Request $request, Orden $orden)
    {
        // Solo órdenes pendientes o en_proceso pueden agregar repuestos
        if (! $orden->esActiva()) {
            return back()->with('error', 'Solo se pueden agregar repuestos a órdenes pendientes o en proceso.');
        }

        $data = $request->validate([
            'repuesto_id' => ['required', 'exists:repuestos,id'],
            'cantidad'    => ['required', 'integer', 'min:1'],
        ]);

        $repuesto = Repuesto::findOrFail($data['repuesto_id']);

        // Un repuesto no puede repetirse en la misma orden
        $yaExiste = OrdenRepuesto::where('orden_id', $orden->id)
            ->where('repuesto_id', $repuesto->id)
            ->exists();

        if ($yaExiste) {
            return back()
                ->with('error', 'Este repuesto ya fue agregado a la orden. Edite la cantidad si es necesario.')
                ->withInput();
        }

        // No puede usarse más stock del disponible
        if ($data['cantidad'] > $repuesto->stock) {
            return back()
                ->with('error', 'No hay stock suficiente para el repuesto seleccionado.')
                ->withInput();
        }

        $subtotal = $repuesto->precio * $data['cantidad'];

        // Creamos el registro en la tabla pivot
        OrdenRepuesto::create([
            'orden_id'    => $orden->id,
            'repuesto_id' => $repuesto->id,
            'cantidad'    => $data['cantidad'],
            'subtotal'    => $subtotal,
        ]);

        // Descontamos stock del repuesto
        $repuesto->decrement('stock', $data['cantidad']);

        return back()->with('success', 'Repuesto agregado a la orden correctamente.');
    }

    /**
     * Actualizar la cantidad de un repuesto ya asociado a una orden.
     */
    public function update(Request $request, Orden $orden, OrdenRepuesto $ordenRepuesto)
    {
        // Seguridad: el pivot debe pertenecer a la orden recibida
        if ($orden->id !== $ordenRepuesto->orden_id) {
            abort(404);
        }

        // Solo órdenes activas permiten modificar repuestos
        if (! $orden->esActiva()) {
            return back()->with('error', 'Solo se pueden modificar repuestos en órdenes pendientes o en proceso.');
        }

        $data = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $repuesto = $ordenRepuesto->repuesto;

        $cantidadAnterior = $ordenRepuesto->cantidad;
        $nuevaCantidad    = $data['cantidad'];

        $diferencia = $nuevaCantidad - $cantidadAnterior;

        if ($diferencia > 0) {
            // Se está aumentando la cantidad: necesitamos más stock
            if ($diferencia > $repuesto->stock) {
                return back()
                    ->with('error', 'No hay stock suficiente para aumentar la cantidad.')
                    ->withInput();
            }

            $repuesto->decrement('stock', $diferencia);
        } elseif ($diferencia < 0) {
            // Se está reduciendo la cantidad: devolvemos stock
            $repuesto->increment('stock', abs($diferencia));
        }

        $ordenRepuesto->update([
            'cantidad' => $nuevaCantidad,
            'subtotal' => $repuesto->precio * $nuevaCantidad,
        ]);

        return back()->with('success', 'Cantidad de repuesto actualizada correctamente.');
    }

    /**
     * Eliminar un repuesto de la orden.
     */
    public function destroy(Orden $orden, OrdenRepuesto $ordenRepuesto)
    {
        // Seguridad: el pivot debe pertenecer a la orden recibida
        if ($orden->id !== $ordenRepuesto->orden_id) {
            abort(404);
        }

        $repuesto = $ordenRepuesto->repuesto;

        // Devolvemos stock al repuesto
        $repuesto->increment('stock', $ordenRepuesto->cantidad);

        $ordenRepuesto->delete();

        return back()->with('success', 'Repuesto eliminado de la orden.');
    }
}
