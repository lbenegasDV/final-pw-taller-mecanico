<?php

namespace App\Http\Controllers;

use App\Models\Mecanico;
use App\Models\Orden;
use App\Models\Vehiculo;
use App\Models\Repuesto;
use Illuminate\Http\Request;

class OrdenController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();

            if (! $user) {
                abort(403, 'Debe iniciar sesión.');
            }

            // Mis Órdenes → solo mecánico
            if ($request->routeIs('ordenes.mis-ordenes')) {
                if (! $user->esMecanico()) {
                    abort(403, 'Solo los mecánicos pueden ver sus órdenes.');
                }
                return $next($request);
            }

            // Ver detalle de orden → admin, recepcionista, mecánico asignado
            if ($request->routeIs('ordenes.show')) {
                return $next($request);
            }

            // Actualizar orden → admin/recep, mecánico (solo desde show)
            if ($request->routeIs('ordenes.update')) {
                return $next($request);
            }

            // CRUD completo → solo admin / recepcionista
            if (! $user->esAdmin() && ! $user->esRecepcionista()) {
                abort(403, 'No tiene permisos para acceder a esta sección.');
            }

            return $next($request);
        });
    }

    /**
     * INDEX – listado general (admin/recep)
     */
    public function index()
    {
        $ordenes = Orden::with(['vehiculo.cliente', 'mecanico'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * MIS ÓRDENES – vista solo para mecánicos
     */
    public function misOrdenes()
    {
        $user = auth()->user();

        if (! $user->esMecanico()) {
            abort(403, 'Solo los mecánicos pueden acceder a esta sección.');
        }

        $mecanico = Mecanico::where('user_id', $user->id)->firstOrFail();

        $ordenes = Orden::with(['vehiculo.cliente'])
            ->where('mecanico_id', $mecanico->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('ordenes.mis_ordenes', compact('ordenes', 'mecanico'));
    }

    /**
     * CREATE – formulario
     */
    public function create()
    {
        $vehiculos = Vehiculo::with('cliente')
            ->where('activo', true)
            ->orderBy('id', 'desc')
            ->get();

        $mecanicos = Mecanico::where('activo', true)
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('ordenes.create', compact('vehiculos', 'mecanicos'));
    }

    /**
     * STORE – crear nueva orden
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vehiculo_id' => ['required', 'exists:vehiculos,id'],
            'mecanico_id' => ['required', 'exists:mecanicos,id'],
            'fecha_ingreso' => ['required', 'date'],
            'fecha_estimada_entrega' => ['required', 'date', 'after:fecha_ingreso'],
            'descripcion_problema' => ['required', 'string'],
            'costo_estimado' => ['nullable', 'numeric', 'min:0'],
        ]);

        $vehiculo = Vehiculo::findOrFail($data['vehiculo_id']);
        $mecanico = Mecanico::findOrFail($data['mecanico_id']);

        if (! $vehiculo->activo) {
            return back()->withErrors(['vehiculo_id' => 'Este vehículo está inactivo.'])->withInput();
        }

        if (! $mecanico->activo) {
            return back()->withErrors(['mecanico_id' => 'Este mecánico está inactivo.'])->withInput();
        }

        // Una orden activa por vehículo
        $existeActiva = Orden::where('vehiculo_id', $vehiculo->id)
            ->whereIn('estado', ['pendiente', 'en_proceso'])
            ->exists();

        if ($existeActiva) {
            return back()
                ->withErrors(['vehiculo_id' => 'El vehículo ya tiene una orden activa.'])
                ->withInput();
        }

        // Máximo 5 órdenes activas por mecánico
        $actMecanico = Orden::where('mecanico_id', $mecanico->id)
            ->whereIn('estado', ['pendiente', 'en_proceso'])
            ->count();

        if ($actMecanico >= 5) {
            return back()
                ->withErrors(['mecanico_id' => 'El mecánico ya tiene 5 órdenes activas.'])
                ->withInput();
        }

        $data['estado'] = 'pendiente';
        $data['fecha_salida'] = null;
        $data['costo_final'] = null;

        Orden::create($data);

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden creada correctamente.');
    }

    /**
     * SHOW – detalle de orden
     */
    public function show(Orden $orden)
    {
        $user = auth()->user();

        // Un mecánico solo puede ver órdenes asignadas a él
        if ($user->esMecanico()) {
            $m = Mecanico::where('user_id', $user->id)->first();

            if (! $m || $orden->mecanico_id !== $m->id) {
                abort(403, 'No puede ver esta orden.');
            }
        }

        $orden->load([
            'vehiculo.cliente',
            'mecanico',
            'repuestos',
            'historialTrabajos.mecanico',
        ]);

        $repuestosDisponibles = Repuesto::where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();

        return view('ordenes.show', [
            'orden' => $orden,
            'repuestosDisponibles' => $repuestosDisponibles,
            'user' => $user,
        ]);
    }

    /**
     * EDIT – formulario
     */
    public function edit(Orden $orden)
    {
        if ($orden->estado === 'cancelada') {
            return redirect()->route('ordenes.index')
                ->with('error', 'Las órdenes canceladas no pueden editarse.');
        }

        $vehiculos = Vehiculo::with('cliente')
            ->orderBy('id', 'desc')
            ->get();

        $mecanicos = Mecanico::orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('ordenes.edit', compact('orden', 'vehiculos', 'mecanicos'));
    }

    /**
     * UPDATE – actualizar orden (admin/recep + mecánico)
     */
    public function update(Request $request, Orden $orden)
    {
        if ($orden->estado === 'cancelada') {
            return redirect()->route('ordenes.index')
                ->with('error', 'Las órdenes canceladas no pueden modificarse.');
        }

        $data = $request->validate([
            'vehiculo_id' => ['required', 'exists:vehiculos,id'],
            'mecanico_id' => ['required', 'exists:mecanicos,id'],
            'fecha_ingreso' => ['required', 'date'],
            'fecha_estimada_entrega' => ['required', 'date', 'after:fecha_ingreso'],
            'fecha_salida' => ['nullable', 'date', 'after_or_equal:fecha_ingreso'],
            'estado' => ['required', 'in:pendiente,en_proceso,finalizada,cancelada'],
            'descripcion_problema' => ['required', 'string'],
            'costo_estimado' => ['nullable', 'numeric', 'min:0'],
            'costo_final' => ['nullable', 'numeric', 'min:0'],
        ]);

        $vehiculo = Vehiculo::findOrFail($data['vehiculo_id']);
        $mecanico = Mecanico::findOrFail($data['mecanico_id']);

        if (! $vehiculo->activo) {
            return back()->withErrors(['vehiculo_id' => 'Vehículo inactivo.'])->withInput();
        }

        if (! $mecanico->activo) {
            return back()->withErrors(['mecanico_id' => 'Mecánico inactivo.'])->withInput();
        }

        // Restricciones para estados activos
        if (in_array($data['estado'], ['pendiente', 'en_proceso'])) {

            $existeActiva = Orden::where('vehiculo_id', $vehiculo->id)
                ->whereIn('estado', ['pendiente', 'en_proceso'])
                ->where('id', '!=', $orden->id)
                ->exists();

            if ($existeActiva) {
                return back()
                    ->withErrors(['vehiculo_id' => 'Este vehículo ya tiene una orden activa.'])
                    ->withInput();
            }

            $actMecanico = Orden::where('mecanico_id', $mecanico->id)
                ->whereIn('estado', ['pendiente', 'en_proceso'])
                ->where('id', '!=', $orden->id)
                ->count();

            if ($actMecanico >= 5) {
                return back()
                    ->withErrors(['mecanico_id' => 'El mecánico ya tiene 5 órdenes activas.'])
                    ->withInput();
            }
        }

        // Finalizada → requiere costo final + fecha salida
        if ($data['estado'] === 'finalizada') {

            if ($data['costo_final'] === null) {
                return back()
                    ->withErrors(['costo_final' => 'El costo final es obligatorio.'])
                    ->withInput();
            }

            if (empty($data['fecha_salida'])) {
                return back()
                    ->withErrors(['fecha_salida' => 'La fecha de salida es obligatoria.'])
                    ->withInput();
            }
        }

        // Cancelada → limpiar campos opcionales
        if ($data['estado'] === 'cancelada') {
            $data['fecha_salida'] = $data['fecha_salida'] ?? null;
            $data['costo_final'] = $data['costo_final'] ?? null;
        }

        $orden->update($data);

        $user = auth()->user();

        // Si es mecánico → vuelve al detalle
        if ($user->esMecanico()) {
            return redirect()
                ->route('ordenes.show', $orden)
                ->with('success', 'Orden actualizada correctamente.');
        }

        // Admin / recep → vuelve al index
        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden actualizada correctamente.');
    }

    /**
     * DELETE
     */
    public function destroy(Orden $orden)
    {
        $orden->delete();

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden eliminada correctamente.');
    }
}
