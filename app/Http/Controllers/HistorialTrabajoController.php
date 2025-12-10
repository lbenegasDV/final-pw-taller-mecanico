<?php

namespace App\Http\Controllers;

use App\Models\HistorialTrabajo;
use App\Models\Mecanico;
use App\Models\Orden;
use Illuminate\Http\Request;

class HistorialTrabajoController extends Controller
{
    public function __construct()
    {
        // Solo mecánicos (y opcionalmente admin) pueden tocar historial
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            if (! $user || (! $user->esMecanico() && ! $user->esAdmin())) {
                abort(403, 'No tiene permisos para gestionar historial de trabajo.');
            }

            return $next($request);
        });
    }

    protected function mecanicoActual()
    {
        $user = auth()->user();
        return Mecanico::where('user_id', $user->id)->first();
    }

    public function store(Request $request, Orden $orden)
    {
        // Orden debe estar en proceso
        if ($orden->estado !== 'en_proceso') {
            return back()->with('error', 'Solo se puede cargar historial cuando la orden está en proceso.');
        }

        $mecanico = $this->mecanicoActual();

        if (auth()->user()->esMecanico()) {
            if (! $mecanico || $orden->mecanico_id !== $mecanico->id) {
                abort(403, 'Solo el mecánico asignado puede cargar historial.');
            }
        } else {
            // admin: puede usar el mecánico asignado a la orden
            $mecanico = $orden->mecanico;
        }

        if (! $mecanico || ! $mecanico->activo) {
            return back()->with('error', 'El mecánico asociado no está activo.');
        }

        $data = $request->validate([
            'descripcion' => ['required', 'string'],
            'horas_trabajadas' => ['required', 'numeric', 'min:0.1'],
            'fecha' => ['required', 'date'],
        ]);

        HistorialTrabajo::create([
            'orden_id' => $orden->id,
            'mecanico_id' => $mecanico->id,
            'descripcion' => $data['descripcion'],
            'horas_trabajadas' => $data['horas_trabajadas'],
            'fecha' => $data['fecha'],
        ]);

        return back()->with('success', 'Historial de trabajo agregado correctamente.');
    }

    public function update(Request $request, Orden $orden, HistorialTrabajo $historial)
    {
        if ($historial->orden_id !== $orden->id) {
            abort(404);
        }

        if ($orden->estado !== 'en_proceso') {
            return back()->with('error', 'Solo se puede modificar historial cuando la orden está en proceso.');
        }

        $mecanico = $this->mecanicoActual();

        if (auth()->user()->esMecanico()) {
            if (! $mecanico || $historial->mecanico_id !== $mecanico->id) {
                abort(403, 'Solo el mecánico que registró la entrada puede modificarla.');
            }
        }

        $data = $request->validate([
            'descripcion' => ['required', 'string'],
            'horas_trabajadas' => ['required', 'numeric', 'min:0.1'],
            'fecha' => ['required', 'date'],
        ]);

        $historial->update($data);

        return back()->with('success', 'Historial de trabajo actualizado correctamente.');
    }

    public function destroy(Orden $orden, HistorialTrabajo $historial)
    {
        if ($historial->orden_id !== $orden->id) {
            abort(404);
        }

        $mecanico = $this->mecanicoActual();

        if (auth()->user()->esMecanico()) {
            if (! $mecanico || $historial->mecanico_id !== $mecanico->id) {
                abort(403, 'Solo el mecánico que registró la entrada puede eliminarla.');
            }
        }

        $historial->delete();

        return back()->with('success', 'Entrada de historial eliminada.');
    }
}
