# Final Producción Web – Sistema de Gestión de Taller Mecánico

Aplicación web desarrollada en **Laravel** como trabajo final de la materia **Producción Web**.  
El sistema permite gestionar clientes, vehículos, mecánicos, órdenes de reparación, repuestos utilizados e historial de trabajo, aplicando el patrón **MVC**, **Eloquent ORM** y buenas prácticas de desarrollo.

## Tecnologías

- PHP 8.2
- Laravel 10
- MySQL
- Tailwind CSS (a través de Breeze / stack de auth)
- Blade Templates

## Funcionalidades principales

### Clientes
- ABM de clientes.
- Validación de **DNI único** y **email único**.
- Campo `activo` para deshabilitar clientes.
- Los clientes se vinculan a sus vehículos.

### Vehículos
- ABM de vehículos.
- Campos: cliente, marca, modelo, año, patente, tipo, activo.
- Validación de **patente única** y **año ≥ 1980**.
- Solo vehículos activos pueden recibir órdenes.

### Mecánicos
- ABM de mecánicos (solo admin).
- Campos: nombre, apellido, email, teléfono, especialidad, activo.
- Solo mecánicos activos pueden asignarse a órdenes.

### Órdenes de reparación
- Asociación a vehículo y mecánico.
- Estados: `pendiente`, `en_proceso`, `finalizada`, `cancelada`.
- Reglas de negocio:
  - No se asignan órdenes a vehículos o mecánicos inactivos.
  - `fecha_estimada_entrega > fecha_ingreso`.
  - Una sola **orden activa por vehículo**.
  - Máximo **5 órdenes activas por mecánico**.
  - Órdenes finalizadas requieren `costo_final` y `fecha_salida`.
  - Órdenes canceladas no pueden modificarse.

### Repuestos
- ABM de repuestos (solo admin).
- Código interno único.
- Validación de stock no negativo y precio > 0.
- Tipos (enum): motor, electrónica, frenos, suspensión, otros.

### Repuestos utilizados (pivot)
- Asociación entre órdenes y repuestos.
- Validaciones:
  - Solo órdenes `pendiente` o `en_proceso` pueden agregar repuestos.
  - No se puede usar más stock del disponible.
  - Un repuesto no puede repetirse en la misma orden (`orden_id + repuesto_id` único).
- Actualización automática de stock al agregar, editar o eliminar repuestos utilizados.

### Historial de trabajo
- Registro de actividades por orden.
- Campos: orden, mecánico, descripción, horas trabajadas, fecha.
- Solo se puede cargar historial cuando la orden está `en_proceso`.
- El mecánico asignado (o el admin) carga y gestiona el historial.

### Usuarios y roles

Tabla `users` con campo `rol`:

- `admin`: gestiona usuarios, mecánicos, repuestos, vehículos y órdenes.
- `recepcionista`: registra clientes, vehículos y órdenes, y gestiona repuestos utilizados.
- `mecanico`: ve sus órdenes asignadas, carga historial de trabajo y actualiza el estado de sus órdenes.

Usuarios de prueba (creados con `php artisan migrate --seed`):

- Admin: `admin@taller.test` / `password`
- Recepcionista: `recepcion@taller.test` / `password`
- Mecánico: `mecanico@taller.test` / `password`
---
### 📝 Notas

- El sistema utiliza el patrón **MVC** de Laravel y relaciones entre modelos mediante **Eloquent ORM**.
- Las vistas se estructuran con **layouts Blade** y **componentes reutilizables**.
- Las validaciones se realizan del lado del servidor, aprovechando las **reglas de validación de Laravel**.

---

**Alumno:** Benegas Héctor Leonardo  
**Comisión:** ACN3BV  
**Profesor:** Calderón Nicolás Ariel

