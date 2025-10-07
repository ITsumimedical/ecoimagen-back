<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $role = Role::where('name', 'desarrollador')->first();
            $permisos = [
                [
                    'name' => 'blog.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'blog.vistas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.contrato.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.familias.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.prestadores.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.servicios.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudCapacitacion.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'gestionConocimiento.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'transcripcion.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'transcripcion.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'transcripcion.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'empleado.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incidente.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'evaluacionDesempeno.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'planSeguimientoIndividual.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'beneficioEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'talentoHumano.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'talentoHumano.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.asignar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para asignar eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.reporte',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para realizar reportes de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para realizar gestión sobre un evento adverso',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para parametrizar el modulo de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver el menu de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.actualizarEvento',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualización de información de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.cerrar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.menu.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el menu de parametrizacion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.menu.portabilidad',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el menu de portabilidad',
                    'estado_id' => 1
                ],
                [
                    'name' => 'certificadoAfiliacion.descargar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso descargar certificado de afiliación de un afiliado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.menu.afiliados',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.menu.barreraAcceso',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menu de barrera de acceso',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.barreraAcceso.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar las barreras de acceso',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.barreraAcceso.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear las barreras de acceso',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.barreraAcceso.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar las barreras de acceso',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.barreraAcceso.exportar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para exportar las barreras de acceso',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.verificacion.descargueReporteRed',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para exportar los afiliados asignados al prestador logueado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.medico.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.parametrizacion.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.medico',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.bloquear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso bloquear una agenda desde el módulo de programación en agendamiento',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.eliminar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso eliminar una agenda desde el módulo de programación en agendamiento',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cita.agendamiento.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cita.parametrizacion.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cita.afiliados',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'blog.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacia.solicitudes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacia.auditorias',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacia.Farmacovigilancia',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el menu en farmacia a farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacia.movimientos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacovigilancia.perfil',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el perfil de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacovigilancia.alertas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'alertasFarmacovigilancia.mensajes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver los mensajes de las alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'alertasFarmacovigilancia.tipoMensajes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver los tipos de mensajes de las alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'alertasFarmacovigilancia.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver editar los mensajes de las alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'alertasFarmacovigilancia.crearMensaje',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear los mensajes de las alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'alertasFarmacovigilancia.parametrizacionAlertas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para parametrizar las alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacovigilancia.seguimientoAlertas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para le seguimiento de alertas de farmacovigilancia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacia.bodegas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'panelmedico.atenciones.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'panelmedico.atenciones',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historico.atenciones.consultas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historico.atenciones.ordenes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historico.atenciones.prestadores',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historico.atenciones.procedimientos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historico.atenciones',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'blog.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'blog.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historia.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historia.categorias',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historia.tiposCampos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'historia.campos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'citas.vistas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.prestador',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'blog.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.pendientes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.conceptosGirs',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.solucionados',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.reporte',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.administracion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.asignacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.auditoria',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.tesoreria',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'turnos.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tablero.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'llamado.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'taquilla.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'area.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.radicar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.asignadas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.admin',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.informe',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.radicar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.radicar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.radicar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.radicar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.formulario',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.formulario',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.solucionarCentral',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para solucionar pqrsf desde central',
                    'estado_id' => 1
                ],
                [
                    'name' => 'roles.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'usuarios.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'especialidades.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'entidades.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'citas.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'sedes.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'admin.enter',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'permisos.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estados.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'modulo.permisos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'rol.vistas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'usuarios.vistas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'admin.especialidades.vistas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'permisos.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estados.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'parametrizacion.agenda',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'vademecum.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudesBodegas.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendamiento.medico.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'parametrizacion.agenda.enters',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'parametrizacion.historia',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar sesion',
                    'estado_id' => 1
                ],
                // permisos cuentas medicas

                [
                    'name' => 'cuentasMedicas.facturasConciliacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas en conciliacion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturasCerradas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas cerradas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaAuditoriaFinal',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas en auditoria final',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.guardarAuditoriaFinal',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar las facturas en auditoria final',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaConciliadaAuditoriaFinal',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas conciliadas en auditoria final',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.conciliar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para  conciliar',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaConciliadaConsaldo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas conciliadas con saldo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaCerradas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturtas cerradas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.listarEmail',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los correo de los prestadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.crearEmail',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear los correos de los prestadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.cambiarEmail',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cambiar o editar los correos de los prestadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.notificar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para notificar el proceso de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoCuentaMedica.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los tipos de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoCuentaMedica.guardar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear los tipos de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.glosasConciliacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las glosas que esten en conciliacion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.glosasCerrada',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las glosas que esten cerradas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.glosasCerrada',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las glosas que esten cerradas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaGlosaAuditoriaFinal',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las glosas que esten en auditoria final',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaConciliada',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las glosas que esten en conciliacion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.facturaConciliadaConSaldo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las glosas que esten en conciliacion con saldo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.crearActualizarRadicacionGlosa',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear o actualizar una radicacion de una glosa',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.guardarAccionConciliacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar una accion de concilacion',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.guardarAccionConciliacionAdministrativa',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar una accion de concilacion administrativa',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.guardarAccionConciliacionConSaldo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar una accion de concilacion con saldo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.listarCodigoGlosas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los codigos de las glosas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.guardarCodigoGlosa',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar los codigos de las glosas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.cambiarEstadoCodigoGlosa',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar el estado de los codigos de las glosas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.acumuladoPrestador',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el acumulado de un prestador',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.auditoriaFinal',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para la auditoria final',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.conciliadasAuditoriaFinal',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas en auditoria final consiliadas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.consiliadasConSaldo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas en auditoria final consiliadas con saldo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.auditoriaFinalCerradas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para las facturas en auditoria final cerradas',
                    'estado_id' => 1
                ],
                [
                    'name'         => 'agendamiento.medico.vista',
                    'guard_name'   => 'api',
                    'descripcion'  => 'vista crear agenda en agendamiento',
                    'estado_id'    => 1
                ],

                [
                    'name'         => 'agendamiento.parametrizacion.vista',
                    'guard_name'   => 'api',
                    'descripcion'  => 'vista parametrizacion de agendas en agendamiento',
                    'estado_id'    => 1
                ],

                [
                    'name'         => 'agendamiento.medico',
                    'guard_name'   => 'api',
                    'descripcion'  => 'menu agendamiento',
                    'estado_id'    => 1
                ],
                [
                    'name' => 'agenda.guardar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear agenda a un medico',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendaDisponible.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los espacios disponibles de un consultorio para asignar',
                    'estado_id' => 1
                ],
                [
                    'name' => 'agendaDisponible.reasignar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los espacios disponibles de un consultorio para reasignar',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.reps.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'vista para la pestaña de sedes en contratos',
                    'estado_id' => 1
                ],
                [
                    'name'        => 'cita.agendamiento.vista',
                    'guard_name'  => 'api',
                    'descripcion' => 'vista agendamiento de citas',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'cita.parametrizacion.vista',
                    'guard_name'  => 'api',
                    'descripcion' => 'vista parametrizacion de citas ',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'cita.afiliados',
                    'guard_name'  => 'api',
                    'descripcion' => 'menu citas',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.citasindividuales',
                    'guard_name'  => 'api',
                    'descripcion' => 'consulta sobre las citas activas asociadas a un paciente',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.generarhistoria',
                    'guard_name'  => 'api',
                    'descripcion' => 'consulta historico de atenciones al paciente',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.crear',
                    'guard_name'  => 'api',
                    'descripcion' => 'crear consulta de atencion para afiliados',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.actualizar',
                    'guard_name'  => 'api',
                    'descripcion' => 'actualizar consulta de atencion para afiliados',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.guardarhistoria',
                    'guard_name'  => 'api',
                    'descripcion' => 'guardar datos de la atencion',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.consultapaciente',
                    'guard_name'  => 'api',
                    'descripcion' => 'consulta atenciones activas del afiliado',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.cancelarconsulta',
                    'guard_name'  => 'api',
                    'descripcion' => 'cancela consulta asignada al afiliado',
                    'estado_id'   => 1
                ],
                [
                    'name'        => 'consulta.reasignarconsulta',
                    'guard_name'  => 'api',
                    'descripcion' => 'reasigna consulta asignada del afiliado',
                    'estado_id'   => 1
                ],
                // permisos contrato
                [
                    'name' => 'contrato.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.guardar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cups.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar cups',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cups.guardar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar cups',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cups.actualizarMasivo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar masivamente cups',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.salarioMinimo.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los salarios minimos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.salarioMinimo.guardar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar los salarios minimos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.salarioMinimo.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar los salarios minimos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Panel de contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.contrato.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar contratos en el menu',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.familias.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar familias en el menu',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.prestadores.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar prestadores en el menu',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.servicios.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar servicios en el menu',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.servicios.cups',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar los cups en el modulo de servicios',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.servicios.codigos_propios',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar los codigos propios en el modulo de servicios',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.servicios.homologo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar el homologo en el modulo de servicios',
                    'estado_id' => 1
                ],
                [
                    'name' => 'homologo.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar los datos del homologo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'homologo.actualizacionMasiva',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el boton de actualizacion del homologo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.servicios.paquetes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar los paquetes en el modulo de servicios',
                    'estado_id' => 1
                ],
                [
                    'name' => 'paqueteServicio.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar los datos de los paquetes de servicio',
                    'estado_id' => 1
                ],
                [
                    'name' => 'paqueteServicio.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear los paquetes de servicio',
                    'estado_id' => 1
                ],
                [
                    'name' => 'paqueteServicio.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar los paquetes de servicio',
                    'estado_id' => 1
                ],
                [
                    'name' => 'talentoHumano.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú general de talento humano',
                    'estado_id' => 1
                ],
                [
                    'name' => 'talentoHumano.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú parametrización de talento humano',
                    'estado_id' => 1
                ],
                [
                    'name' => 'beneficioEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los beneficios de los empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'beneficioEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear beneficios de los empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'beneficioEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar beneficios de los empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'beneficioEmpleado.autorizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para autorizar beneficios de los empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'beneficioEmpleado.anular',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para anular beneficios de los empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'planSeguimientoIndividual.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar planes de seguimiento individual de los empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'evaluacionDesempeno.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar evaluaciones de desempeño',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incidente.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar incidentes de desempeño',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incidente.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear incidentes de desempeño',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incidente.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar incidentes de desempeño',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incidente.cerrar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar incidentes de desempeño',
                    'estado_id' => 1
                ],
                [
                    'name' => 'empleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'empleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'empleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'empleado.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú general de empleados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cargo.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar un cargoa de talento humano',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cargo.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear un cargo de talento humano',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cargo.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar cargo de talento humano',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al módulo solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.informe',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al infome de solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.admin',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al admin de solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.asignadas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder a las solicitudes asignadas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder a la gestión de solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.radicar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder a la radicación de solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoSolicitudEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar tipo de solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoSolicitudEmpleado.inactivar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para inactivar tipo de solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoSolicitudRedVital.guardar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar tipo de solicitud de red vital',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoSolicitudRedVital.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar tipo de solicitud de red vital',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tipoSolicitudRedVital.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar tipo de solicitud de red vital',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.crearRadicacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear una radicacion de solicitud',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.buscarPorFiltro',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar solicitudes por filtro',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.comentar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para comentar una solicitud',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.respuesta',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para responder una solicitud',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.asignar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para asignar una solicitud',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.buscarPorFiltroSolucioandas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar solicitudes solucionadas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.buscarPendientesAsignadas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar solicitudes asignadas pendientes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.devolver',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para devolver una solicitud',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.solucionadasAsignadas',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar solicitudes asignadas y solucionadas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.buscarPendientes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar solicitudes pendientes en admin',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.solucionadasAdmin',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar solicitudes solucionadas en admin',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.verComentariosPublicos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver comentarios publicos en solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.verComentariosPrivados',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver comentarios privados en solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.verDevoluciones',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver devoluciones en solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.guardarGestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para guardar una gestion en solicitudes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.adminTipoSolicitudes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para tipo solicitudes en admin',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudes.adminGestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para gestionar solicitudes en admin',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratoEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar un contrato de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratoEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear un contrato de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratoEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar contrato de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratoEmpleado.terminarContrato',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para terminar contrato de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'licenciaEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar una licencia de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'licenciaEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear una licencia de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'licenciaEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizara licencia de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'vacacionEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar una vacación de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'vacacionEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear una vacación de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'vacacionEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar vacación de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'vacacionEmpleado.autorizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear una vacación de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'vacacionEmpleado.anular',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar vacación de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incapacidadEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar una incapacidad de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incapacidadEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear una incapacidad de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incapacidadEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar incapacidad de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contactoEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar un contacto de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contactoEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear un contacto de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contactoEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar contacto de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estudioEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar un estudio de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estudioEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear un estudio de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estudioEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar estudio de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'hijoEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar un hijo de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'hijoEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear un hijo de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'hijoEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar hijo de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'grupoFamiliarEmpleado.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar un grupo familiar de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'grupoFamiliarEmpleado.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear un grupo familiar de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'grupoFamiliarEmpleado.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar grupo familiar de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'perfilSociodemografico.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso gestionar el perfilsociodemográfico de un empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'prestador.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para consultar prestadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'prestador.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear prestadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'prestador.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar prestadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tarifa.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear tarifas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tarifa.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar tarifas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'familia.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar familias',
                    'estado_id' => 1
                ],
                [
                    'name' => 'familia.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear familias',
                    'estado_id' => 1
                ],
                [
                    'name' => 'familia.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar familias',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso general para el menú de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.reporte',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para registrar eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para submeú de gestión de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso el submódulo de parametrización de eventos adversos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'eventoAdverso.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar eventos adversos contadores',
                    'estado_id' => 1
                ],
                [
                    'name' => 'usuarios.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver en el menu los usuarios',
                    'estado_id' => 1
                ],
                [
                    'name' => 'permisos.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver en el menu los permisos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'gestionConocimiento.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú general de gestión del conocimiento',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudCapacitacion.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar todas las solicitudes de capacitación',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudCapacitacion.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso crear solicitudes de capacitación',
                    'estado_id' => 1
                ],
                [
                    'name' => 'solicitudCapacitacion.agregarParticipante',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para agregar participantes a una solicitud de capacitación',
                    'estado_id' => 1
                ],
                [
                    'name' => 'rep.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear los reps',
                    'estado_id' => 1
                ],
                [
                    'name' => 'rep.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear los reps',
                    'estado_id' => 1
                ],
                [
                    'name' => 'rep.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar los reps',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso general para menú de PQRSF',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.formulario',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ingreso a módulo formulario de pqrsf',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pqrsf.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para parametrización módulo de pqrsf',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'modulo.permisos',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a permisos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'permisos.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a permisos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estados.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a estados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'admin.enter',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar admin',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a asegurador',
                    'estado_id' => 1
                ],
                [
                    'name' => 'sedes.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a sedes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'citas.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a citas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'entidades.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a entidades',
                    'estado_id' => 1
                ],
                [
                    'name' => 'especialidades.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a especialidades',
                    'estado_id' => 1
                ],
                [
                    'name' => 'roles.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a roles',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.administracion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a la administración de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.asignacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a la asignación de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.auditoria',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a la auditoria de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.tesoreria',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para entrar a la tesoreria de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'transcripcion.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso listar transcripciones',
                    'estado_id' => 1
                ],                [
                    'name' => 'transcripcion.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso crear transcripciones',
                    'estado_id' => 1
                ],
                [
                    'name' => 'nivel.ordenamiento.1',
                    'guard_name' => 'api',
                    'descripcion' => 'nivel ordenamiento 1',
                    'estado_id' => 1
                ],
                [
                    'name' => 'nivel.ordenamiento.2',
                    'guard_name' => 'api',
                    'descripcion' => 'nivel ordenamiento 2',
                    'estado_id' => 1
                ],
                [
                    'name' => 'nivel.ordenamiento.3',
                    'guard_name' => 'api',
                    'descripcion' => 'nivel ordenamiento 3',
                    'estado_id' => 1
                ],
                [
                    'name' => 'nivel.ordenamiento.4',
                    'guard_name' => 'api',
                    'descripcion' => 'nivel ordenamiento 4',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.pendientes.ver',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyos pendientes por ver',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.cambiar.especialidad',
                    'guard_name' => 'api',
                    'descripcion' => 'cambiar especialidad teleapoyo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'asegurador.afiliados',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para mostar afiliado en el menu de aseguramiento',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.guardar.girs',
                    'guard_name' => 'api',
                    'descripcion' => 'Guardar GIRS teleapoyo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Guardar teleapoyo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.pendientes',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyo pendientes',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.actualizarEspecialidad',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyo actualizar especialidad',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.responder',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyo responder',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.conceptosGirs',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyo concepto girs',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyo actualizar',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.solucionados',
                    'guard_name' => 'api',
                    'descripcion' => 'teleapoyo solucionados',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.contador',
                    'guard_name' => 'api',
                    'descripcion' => 'Contador de teleapoyos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.reporte',
                    'guard_name' => 'api',
                    'descripcion' => 'Reporte de teleapoyo',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratoEmpleado.firma',
                    'guard_name' => 'api',
                    'descripcion' => 'Firma empleado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'teleapoyo.vista',
                    'guard_name' => 'api',
                    'descripcion' => 'Vista teleapooyo',
                    'estado_id' => 1
                ],

                [
                    'name' => 'contrato.georreferencia.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Listar Georreferenciaciones',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.georreferencia.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Crear Georreferenciaciones',
                    'estado_id' => 1
                ],
                [
                    'name' => 'pais.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Listar paises',
                    'estado_id' => 1
                ],
                [
                    'name' => 'accionConstitucional.juzgado',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver juzgados en parametrización acciones constitucionales',
                    'estado_id' => 1
                ],
                [
                    'name' => 'accionConstitucional.proceso',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver procesos en parametrización acciones constitucionales',
                    'estado_id' => 1
                ],
                [
                    'name' => 'accionesconstitucionales.menu.asignada',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver menu de asignadas en el modulo acciones constitucionales',
                    'estado_id' => 1
                ],
                [
                    'name' => 'accionesconstitucionales.menu.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver menu de gestion en el modulo acciones constitucionales',
                    'estado_id' => 1
                ],
                [
                    'name' => 'accionesconstitucionales.menu.reportes',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver menu de reportes en el modulo acciones constitucionales',
                    'estado_id' => 1
                ],
                [
                    'name' => 'accionesconstitucionales.menu.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver menu de parametrizacn en el modulo acciones constitucionales',
                    'estado_id' => 1
                ],
                [
                    'name' => 'farmacia.menu.reportes',
                    'guard_name' => 'api',
                    'descripcion' => 'Ver menu de reportes en el modulo de farmacia ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'cuentasMedicas.adminInforme',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el informe de cuentas medicas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.modalidadContrato.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el visualizar y listar modalidad de contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.modalidadContrato.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el visualizar y listar modalidad de contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratos.modalidadContrato.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para el visualizar y listar modalidad de contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.direccionamiento.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar direccionamiento en el modulo de contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.direccionamiento.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear direccionamiento en el modulo de contratos',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contrato.direccionamiento.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar direccionamiento en el modulo de contratos',
                    'estado_id' => 1
                ],
                //empalme
                [
                    'name' => 'empalme.listarFerrocarriles',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar y buscar en el módulo de empalme ',
                    'estado_id' => 1
                ],
                //estadistica
                [
                    'name' => 'estadistica.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para visualizar em módulo de estadistica ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estadistica.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear una nueva estadistica ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estadistica.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar una estadistica ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estadistica.eliminar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para eliminar una estadistica',
                    'estado_id' => 1
                ],
                [
                    'name' => 'estadistica.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para parametrizar una estadistica',
                    'estado_id' => 1
                ],
                [
                    'name' => 'referencia.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar las referencias',
                    'estado_id' => 1
                ],[
                    'name' => 'referencia.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear referencia',
                    'estado_id' => 1
                ],[
                    'name' => 'referencia.actualizar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para actualizar una referencia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'referencia.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver en el menu el item referencia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'referencia.seguimiento',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver en el menu el item de seguimiento a referencia',
                    'estado_id' => 1
                ],
                [
                    'name' => 'referencia.seguimiento.prestador',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver el seguimiento especifico del usuario logueado',
                    'estado_id' => 1
                ],
                [
                    'name' => 'referencia.seguimiento.todo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver todos los seguimientos (solo para personal del centro regulador)',
                    'estado_id' => 1
                ],
                //Caracterización
                [
                    'name' => 'caracterizacion.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para buscar en caracterizacion ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'contratoEmpleado.cierreMes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cerrar mes y almacenar infromación de los contratos laborales ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tutelas.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para ver el menú de tutelas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tutelas.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al módulo de parametrización de tutelas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tutelas.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al módulo de gestión tutela',
                    'estado_id' => 1
                ],
                [
                    'name' => 'tutelas.asignada',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder a las tutelas asignadas',
                    'estado_id' => 1
                ],
                [
                    'name' => 'mesaAyuda.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al módulo de mesa de ayuda',
                    'estado_id' => 1
                ],
                [
                    'name' => 'mesaAyuda.gestion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al módulo de mesa de ayuda gestión',
                    'estado_id' => 1
                ],
                [
                    'name' => 'mesaAyuda.parametrizacion',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para acceder al módulo de mesa de ayuda parametrización',
                    'estado_id' => 1
                ],
                [
                    'name' => 'consultorio.listar',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para listar los consultorios ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'consultorio.crear',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para crear consultorios ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'consultorio.cambiarEstado',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para cambiar estado de los consultorios ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'concurrencia.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso menú general módulo concurrencia ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'concurrencia.ingreso',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso menú registrar ingresos a concurrencia ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'concurrencia.seguimiento',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú de seguimiento a concurrencias ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'concurrencia.alta',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú de alta a concurrencias ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'concurrencia.lineaTiempo',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menú de línea de tiempo concurrencias ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'incapacidades.anular',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para anular incapacidades ',
                    'estado_id' => 1
                ],
                [
                    'name' => 'recomendaciones.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para Menpu de recomendaciones',
                    'estado_id' => 1
                ],
                [
                    'name' => 'autogestion.ordenes',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menu de ordenes en autogestión',
                    'estado_id' => 1
                ],
                [
                    'name' => 'ordenamiento.menu',
                    'guard_name' => 'api',
                    'descripcion' => 'Permiso para menu de ordenamiento',
                    'estado_id' => 1
                ],



            ];
            foreach ($permisos as $Afiliacion) {
                Permission::updateOrCreate([
                    'name'  => $Afiliacion['name']
                ],[
                    'name'  => $Afiliacion['name'],
                    'guard_name' => $Afiliacion['guard_name'],
                    'descripcion' => $Afiliacion['descripcion'],
                    'estado_id' => $Afiliacion['estado_id'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de permission'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
