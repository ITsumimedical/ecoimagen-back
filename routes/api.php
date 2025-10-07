<?php

use App\Http\Modules\Medicamentos\Controllers\OrdenamientoController;
use App\Http\Modules\MesaAyuda\MesaAyuda\Controllers\MesaAyudaController;
use Illuminate\Support\Facades\Route;

/**
 * Rutas (No requiren autenticacion)
 * Autor: Calvarez hola
 */

require __DIR__ . '/auth/auth.php';
require __DIR__ . '/citas/citaExterna.php';
require __DIR__ . '/usuarios/actualizacionContrasena.php';
require __DIR__ . '/afiliados/actualizacionPacientes.php';
require __DIR__ . '/gestionPqrsf/emailSolucion.php';


/**
 * Rutas (Requiren autenticacion)
 * Autor: Calvarez
 */
Route::middleware(['auth:api'])->group(function () {
    require __DIR__ . '/usuarios/usuario.php';
    require __DIR__ . '/tipoUsuarios/tipoUsuario.php';
    require __DIR__ . '/roles/rol.php';
    require __DIR__ . '/permisos/permiso.php';
    // Rutas de aspirantes
    require __DIR__ . '/aspirantes/aspirante.php';
    // Rutas de aseguramiento
    require __DIR__ . '/tipoNovedadAfiliados/tipoNovedadAfiliado.php';
    require __DIR__ . '/novedadAfiliado/novedadAfiliado.php';
    require __DIR__ . '/afiliados/afiliado.php';
    require __DIR__ . '/portabilidadEntrada/portabilidadEntrada.php';
    require __DIR__ . '/portabilidadSalida/portabilidadSalida.php';
    require __DIR__ . '/tipoAfiliaciones/tipoAfiliacion.php';
    require __DIR__ . '/clasificaciones/clasificacion.php';
    // require __DIR__ . '/detalleAfiliado/detalleAfiliado.php';
    require __DIR__ . '/medicoSede/medicoSede.php';
    require __DIR__ . '/subregion/subregion.php';
    // Rutas de estados
    require __DIR__ . '/estados/estado.php';
    //Rutas para tipo-vacantes talento humano
    require __DIR__ . '/tipoVacantes/tipoVacante.php';
    //Rutas para vacantes de talento humano
    // Especialidad
    require __DIR__ . '/especialidades/especialidad.php';
    // REPS
    require __DIR__ . '/reps/reps.php';
    // Agendas
    require __DIR__ . '/agendas/agenda.php';
    require __DIR__ . '/agendas/cambioAgenda.php';
    // empleados
    require __DIR__ . '/empleados/empleado.php';
    //Areas de talento humano
    require __DIR__ . '/areasTh/areaTh.php';
    // Medicamentos
    require __DIR__ . '/medicamentos/medicamento.php';
    // Rutas de departamentos
    require __DIR__ . '/departamentos/departamento.php';
    // Rutas de departamentos
    require __DIR__ . '/municipios/municipio.php';
    // CITAS
    require __DIR__ . '/citas/cita.php';
    require __DIR__ . '/tipoHistorias/tipoHistoria.php';
    // tipo documentos
    require __DIR__ . '/tipoDocumentos/tipoDocumento.php';
    // tipo citas
    require __DIR__ . '/tipoCitas/tipoCita.php';
    // consultorios
    require __DIR__ . '/consultorios/consultorio.php';
    // novedades agendamiento
    require __DIR__ . '/novedadAgendamientos/novedadAgendamiento.php';
    // CONSULTAS
    require __DIR__ . '/consultas/consulta.php';
    // tipo afiliados
    require __DIR__ . '/tipoAfiliados/tipoAfiliado.php';
    // municipios
    require __DIR__ . '/municipios/municipio.php';
    // Bodegas
    require __DIR__ . '/bodegas/bodega.php';
    // tipo Solicitud Bodegas
    require __DIR__ . '/tipoSolicitudBodegas/tipoSolicitudBodega.php';
    // tipo Solicitud Bodegas
    require __DIR__ . '/solicitudBodegas/solicitudBodega.php';
    // categoria historia
    require __DIR__ . '/categoriaHistoria/categoriaHistoria.php';
    require __DIR__ . '/campoHistoria/campoHistoria.php';
    require __DIR__ . '/tipoCampo/tipoCampo.php';
    // Tutelas
    require __DIR__ . '/tipoActuacionTutelas/tipoActuacionTutelas.php';
    require __DIR__ . '/juzgadosTutelas/juzgadosTutela.php';
    require __DIR__ . '/tutelas/tutela.php';
    require __DIR__ . '/tipoSercivioTutelas/tipoServicioTutela.php';
    require __DIR__ . '/respuestasTutelas/respuestasTutela.php';
    require __DIR__ . '/responsableTutelas/responsableTutela.php';
    require __DIR__ . '/procesoTutelas/procesoTutelas.php';
    require __DIR__ . '/actuacionTutela/actuacionTutela.php';
    //  prestadores
    require __DIR__ . '/prestadores/prestador.php';
    require __DIR__ . '/tipoPrestadores/tipoPrestador.php';
    // contacto empleados
    require __DIR__ . '/contactosEmpleados/contactoEmpleado.php';
    // grupo familiar empleados
    require __DIR__ . '/grupoFamiliarEmpleados/grupoFamiliarEmpleado.php';
    // hijo empleado
    require __DIR__ . '/hijosEmpleados/hijoEmpleado.php';
    // contrato
    require __DIR__ . '/contratos/contrato.php';
    // Tipo manual tarifario
    require __DIR__ . '/manualTarifario/manualTarifario.php';
    // Tipo familia
    require __DIR__ . '/tipoFamilias/tipoFamilia.php';
    // Familia
    require __DIR__ . '/Familias/Familia.php';
    // mascota empleado
    require __DIR__ . '/mascotasEmpleados/mascotaEmpleado.php';
    // cargos
    require __DIR__ . '/cargos/cargo.php';
    // tipos contratos empleados
    require __DIR__ . '/tipoContratosTh/tipoContratoTh.php';
    // contratos empleados
    require __DIR__ . '/contratosEmpleados/contratoEmpleado.php';
    require __DIR__ . '/contratosEmpleados/historicoContratoEmpleado.php';
    require __DIR__ . '/contratosEmpleados/cierreMesContratoEmpleado.php';
    // salario minimo
    require __DIR__ . '/salarioMinimo/salarioMinimo.php';
    // homologo
    require __DIR__ . '/homologo/homologo.php';
    // tarifas
    require __DIR__ . '/tarifas/tarifa.php';
    require __DIR__ . '/cups/cups.php';
    require __DIR__ . '/paqueteServicios/paqueteServicio.php';
    require __DIR__ . '/cums/cums.php';
    require __DIR__ . '/tipoPrestadoresTh/tipoPrestadorTh.php';
    require __DIR__ . '/prestadoresTh/prestadorTh.php';
    require __DIR__ . '/afiliacionesEmpleados/afiliacionEmpleado.php';
    require __DIR__ . '/tipoSolicitudPqrsf/tipoSolicitudPqrsf.php';
    require __DIR__ . '/ambito/ambito.php';
    require __DIR__ . '/incapacidadesEmpleados/incapacidadEmpleado.php';
    // Historico
    require __DIR__ . '/historias/historia.php';
    // Referencias
    require __DIR__ . '/referencias/referencia.php';
    //Ingreso domiciliario
    require __DIR__ . '/ingresoDomiciliarios/ingresoDomiciliario.php';
    //Informacion cuidador
    require __DIR__ . '/informacionCuidadors/informacionCuidador.php';
    //Informacion responsable
    require __DIR__ . '/informacionResponsables/informacionResponsable.php';
    // tipo solicitud teleapoyo
    require __DIR__ . '/tipoSolicitudTeleapoyo/tipoSolicitud.php';
    // Vacaciones contratos empleados
    require __DIR__ . '/vacacionesEmpleados/vacacionEmpleado.php';
    require __DIR__ . '/cie10/cie10.php';
    //teleapoyo
    require __DIR__ . '/teleapoyo/teleapoyo.php';
    // Entidades
    require __DIR__ . '/entidad/entidad.php';
    // Asguradores
    require __DIR__ . '/aseguradores/asegurador.php';
    require __DIR__ . '/estudiosEmpleados/estudioEmpleado.php';
    require __DIR__ . '/capacitacionEmpleados/CapacitacionEmpleado.php';
    // sedes
    require __DIR__ . '/sedes/sede.php';
    /** helpdesk */
    require __DIR__ . '/prioridades/prioridad.php';
    require __DIR__ . '/capacitacionEmpleadosDetalles/capacitacionEmpleadoDetalle.php';
    require __DIR__ . '/entidadExamenesLaborales/entidadExamenLaboral.php';
    // RUTAS PARA EVALUACION DE DESEMPEÑO
    require __DIR__ . '/evaluacionDesempeno/thTipoPlantilla.php';
    require __DIR__ . '/evaluacionDesempeno/thPilar.php';
    require __DIR__ . '/evaluacionDesempeno/thCompetencias.php';
    require __DIR__ . '/evaluacionDesempeno/evaluaciondesempeno.php';
    require __DIR__ . '/evaluacionDesempeno/fechaEvaluacionDesempeno.php';
    require __DIR__ . '/evaluacionDesempeno/calificacionCompetencia.php';
    require __DIR__ . '/evaluacionDesempeno/thConfiguracion.php';
    require __DIR__ . '/turnoTh/turnoTh.php';
    require __DIR__ . '/etiquetasTh/etiquetaTh.php';
    require __DIR__ . '/serviciosTh/servicioTh.php';
    require __DIR__ . '/perfilesSociodemograficos/perfilSociodemografico.php';
    require __DIR__ . '/orientacionesSexuales/OrientacionSexual.php';
    require __DIR__ . '/codigoPropio/codigoPropio.php';
    require __DIR__ . '/proyectos/proyecto.php';
    require __DIR__ . '/beneficios/beneficio.php';
    require __DIR__ . '/beneficiosEmpleados/beneficioEmpleado.php';
    require __DIR__ . '/seguimientoCompromiso/seguimientoCompromiso.php';
    require __DIR__ . '/cuadroTurnos/programacionMensual.php';
    require __DIR__ . '/cuadroTurnos/detalleProgramacionMensual.php';
    // eventos
    require __DIR__ . '/eventos/sucesos.php';
    require __DIR__ . '/eventos/clasificacionArea.php';
    require __DIR__ . '/eventos/tipoEvento.php';
    require __DIR__ . '/eventos/eventoAdverso.php';
    require __DIR__ . '/eventos/analisis.php';
    require __DIR__ . '/eventos/accionMejora.php';
    require __DIR__ . '/eventos/accionInsegura.php';
    require __DIR__ . '/eventos/gestionEventoAdverso.php';
    require __DIR__ . '/motivosAnulacionEventos/motivoAnulacionEvento.php';
    require __DIR__ . '/eventos/eventoAsignado.php';
    require __DIR__ . '/eventos/usuarioSuceso.php';
    // Ordenamiento
    require __DIR__ . '/ordenamientos/ordenamiento.php';

    //Ruta de integrantes junta girs modulo teleapoyo
    require __DIR__ . '/integrantesJuntaGirs/integrantesJuntaGir.php';
    //Ruta de  cuentas medicas
    require __DIR__ . '/tipoCuentasMedicas/tipoCuentaMedica.php';
    require __DIR__ . '/codigoGlosas/codigoGlosa.php';
    require __DIR__ . '/emailCuentasMedicas/emailCuentaMedica.php';
    require __DIR__ . '/facturas/factura.php';
    // Ordenamiento
    require __DIR__ . '/pdfs/pdf.php';
    require __DIR__ . '/tipoLicenciasTh/tipoLicencia.php';
    require __DIR__ . '/licenciasEmpleados/licenciaEmpleado.php';
    //Ruta de bitacoras mensajes
    // require __DIR__ . '/bitacoraMensajes/bitacoraMensaje.php';
    //Rutas de oncologia
    require __DIR__ . '/oncologia/organos.php';
    require __DIR__ . '/oncologia/tomaProcedimiento.php';
    //Rutas del módulo mesa de ayuda
    require __DIR__ . '/mesaAyuda/mesaAyuda.php';
    require __DIR__ . '/mesaAyuda/seguimientoActividades.php';
    //Rutas de mesa de ayudas
    require __DIR__ . '/ModuloMesaAyuda/CategoriaMesaAyuda.php';
    require __DIR__ . '/ModuloMesaAyuda/AdjuntosMesaAyudas.php';
    //Rutas de para consultar adjuntos
    require __DIR__ . '/adjuntos/adjunto.php';
    //Rutas de incidentes
    require __DIR__ . '/incidentes/incidente.php';
    require __DIR__ . '/incidentes/seguimientoIncidente.php';
    //Rutas inducciones específicas
    require __DIR__ . '/induccionesEspecificas/plantillaInduccionEspecifica.php';
    require __DIR__ . '/induccionesEspecificas/temaInduccionEspecifica.php';
    require __DIR__ . '/induccionesEspecificas/induccionEspecifica.php';
    require __DIR__ . '/induccionesEspecificas/detalleInduccionEspecifica.php';
    require __DIR__ . '/induccionesEspecificas/compromisoInduccionEspecifica.php';
    require __DIR__ . '/induccionesEspecificas/seguimientoCompromisoInduccionEspecifica.php';
    //Ruta de solicitudes de Mesa de ayuda
    require __DIR__ . '/ModuloMesaAyuda/SolicitudesMesaAyuda.php';
    // Ruta chats
    require __DIR__ . '/chat/chat.php';
    require __DIR__ . '/chat/mensaje.php';
    // Rutas evaluación periodo de prueba
    require __DIR__ . '/evaluacionPeriodoPrueba/plantillaEvaluacionPeriodoPrueba.php';
    require __DIR__ . '/evaluacionPeriodoPrueba/criterioEvaluacionPeriodoPrueba.php';
    require __DIR__ . '/evaluacionPeriodoPrueba/evaluacion_periodo_prueba.php';
    // Rutas Bancos
    require __DIR__ . '/bancos/banco.php';
    require __DIR__ . '/tiposCuentasBancarias/TipoCuentaBancaria.php';
    //Rutas cuentas medicas
    require __DIR__ . '/glosa/glosas.php';
    require __DIR__ . '/radicacionGlosa/radicacionGlosas.php';
    require __DIR__ . '/radicacionGlosaSumimedical/radicacionGlosasSumimedical.php';
    // rutas adjunto relacion pagos
    require __DIR__ . '/adjuntoRelacionPagos/adjuntoRelacionPago.php';
    // rutas gestion conocimiento
    require __DIR__ . '/gestionConocimientos/solicitudCapacitacion.php';
    // rutas rips
    require __DIR__ . '/rips/rip.php';
    require __DIR__ . '/tipoSolicitudesRedVital/tipoSolicitudRedVital.php';
    require __DIR__ . '/tipoSolicitudEmpleado/tipoSolicitudEmpleados.php';
    require __DIR__ . '/radicacionOnline/radicacionOnline.php';
    require __DIR__ . '/gestionRadicacionOnline/gestionRadicacionOnline.php';
    require __DIR__ . '/demandaInducidas/demandaInducida.php';
    // rutas de PQRSF
    require __DIR__ . '/gestionPqrsf/canalPqrsf.php';
    require __DIR__ . '/gestionPqrsf/tipoSolicitudPqrsf.php';
    require __DIR__ . '/gestionPqrsf/formularioPqrsf.php';
    require __DIR__ . '/gestionPqrsf/ServiciosPqrsf.php';

    // rutas de transcripciones
    require __DIR__ . '/transcripciones/transcripcion.php';
    //rutas de asistencia educativa
    require __DIR__ . '/asistenciaEducativas/asistenciaEducativa.php';
    //rutas para antecedentes de la historia clinica
    require __DIR__ . '/antecedentes/antecedentesHistoria.php';
    require __DIR__ . '/antecedentes/antecedente.php';
    require __DIR__ . '/antecedentes/antecedentesFamiliares.php';
    require __DIR__ . '/antecedentes/antecedentesTransfusionales.php';
    require __DIR__ . '/antecedentes/antecedentesQuirurgicos.php';
    require __DIR__ . '/antecedentes/antecedentesVacunales.php';
    require __DIR__ . '/antecedentes/antecedentesAlergicos.php';
    require __DIR__ . '/antecedentes/antecedentesSexuales.php';
    require __DIR__ . '/antecedentes/antecedentesBiopsicosociales.php';
    require __DIR__ . '/antecedentes/antecedentesGinecostetricos.php';
    require __DIR__ . '/antecedentes/antecedentesFamiliograma.php';
    require __DIR__ . '/antecedentes/antecedentesPersonales.php';


    //rutas para admisiones urgencias
    require __DIR__ . '/admisionesUrgencia/admisionesUrgencia.php';

    //ruta autorizaciones
    require __DIR__ . '/auditorias/auditoria.php';
    // modalidad
    require __DIR__ . '/modalidades/modalidad.php';

    // proveedor
    require __DIR__ . '/proveedores/proveedor.php';
    require __DIR__ . '/medicamentos/precio.php';
    // Movimientos
    require __DIR__ . '/movimientos/movimiento.php';
    require __DIR__ . '/solicitudBodegas/tipoNovedades.php';
    // Demanda Insatisfecha
    require __DIR__ . '/demandaInsatisfechas/demandaInsatisfecha.php';

    //certificado
    require __DIR__ . '/certificados/certificado.php';

    //georeferencia
    require __DIR__ . '/georeferenciaciones/Georeferenciacion.php';
    //pais
    require __DIR__ . '/pais/pais.php';
    //incapacidades
    require __DIR__ . '/incapacidades/incapacidad.php';
    //colegios
    require __DIR__ . '/colegios/colegio.php';
    //afiliado clasificaciones
    require __DIR__ . '/afiliadoClasificaciones/afiliadoClasificacion.php';
    //inventario farmacia
    require __DIR__ . '/inventarioFarmacias/inventarioFarmacia.php';

    //empalme
    require __DIR__ . '/Empalme/Empalme.php';
    //direccionamiento
    require __DIR__ . '/direccionamientos/direccionamiento.php';
    //concurrencia
    require __DIR__ . '/concurrencia/concurrencia.php';
    //barreras Acceso
    require __DIR__ . '/barreraAccesos/barreraAcceso.php';
    // bodega
    require __DIR__ . '/bodegaMedicamentos/bodegaMedicamentos.php';

    // recomendaciones
    require __DIR__ . '/recomendacionCups/recomendacionCup.php';

    //estadistica
    require __DIR__ . '/estadistica/estadistica.php';

    // proyectos empleados
    require __DIR__ . '/proyectoEmpleados/proyectoEmpleado.php';
    require __DIR__ . '/proyectoEmpleados/proyectosEmpleados.php';
    // consentimientos informados
    require __DIR__ . '/consentimientosInformados/consentimientosInformados.php';
    //  FIAS
    require __DIR__ . '/fias/fias.php';

    //Caracterizacion
    require __DIR__ . '/caracterizacion/caracterizacion.php';

    //Categorias
    require __DIR__ . '/Categorias/categoriasPadres.php';
    require __DIR__ . '/Categorias/categorias.php';
    require __DIR__ . '/Categorias/subcategorias.php';

    //SALUD OCUPACIONAL
    require __DIR__ . '/historiaOcupacional/historia.php';

    //farmacovigilancia
    require __DIR__ . '/farmacovigilancia/mensajesAlerta.php';

    //Grupos Terapeuticos
    require __DIR__ . '/gruposTerapeuticos/gruposTerapeuticos.php';
    require __DIR__ . '/gruposTerapeuticos/subgruposTerapeuticos.php';

    //areas
    require __DIR__ . '/areas/areas.php';

    //Formas Farmaceuticas
    require __DIR__ . '/formasFarmaceuticas/formasFarmaceuticas.php';

    //Lineas Bases
    require __DIR__ . '/lineasBases/lineasBases.php';

    //codesumi
    require __DIR__ . '/Codesumis/codesumi.php';

    //vias administracion
    require __DIR__ . '/viasAdministracion/viasAdministracion.php';

    //grupos
    require __DIR__ . '/grupos/grupo.php';
    require __DIR__ . '/subgrupos/subgrupo.php';

    //laboratorios
    require __DIR__ . '/ordenCabecera/ordenCabecera.php';

    //esquemas
    require __DIR__ . '/esquemas/esquema.php';
    require __DIR__ . '/detalleEsquemas/detalleEsquema.php';

    // pqrsf
    require __DIR__ . '/pqrsf/subcategoriaspqrsf.php';
    require __DIR__ . '/pqrsf/medicamentospqrsf.php';
    require __DIR__ . '/pqrsf/areaspqrsf.php';
    require __DIR__ . '/pqrsf/ipspqrsf.php';
    require __DIR__ . '/pqrsf/codigosPropiosPqrsf.php';

    //notas enfermeria
    require __DIR__ . '/notasEnfermeria/notaEnfermeria.php';

    //sarlaft
    // require __DIR__ . '/representanteLegal/representanteLegal.php';
    // require __DIR__ . '/socios/socio.php';
    // require __DIR__ . '/personalExpuesto/personalExpuesto.php';
    // require __DIR__ . '/informacionFinanciera/informacionFinanciera.php';
    // require __DIR__ . '/actividadInternacional/actividadInternacional.php';
    // require __DIR__ . '/declaracionFondos/declaracionFondo.php';
    // require __DIR__ . '/adjuntoSarlaft/adjuntoSarlaft.php';
    // require __DIR__ . '/revisionSarlft/revisionSarlaft.php';

    //Historico Portabilidad
    require __DIR__ . '/portabilidadHistorico/portabilidadHistorico.php';

    // historias por contingencia
    require __DIR__ . '/tipoArchivos/tipoArchivo.php';
    require __DIR__ . '/cargueHistoriaContingencias/cargueHistoriaContingencia.php';

    //tipo alerta
    require __DIR__ . '/farmacovigilancia/tipoAlerta.php';

    require __DIR__ . '/empleadoPqrsf/empleadoPqrsf.php';
    require __DIR__ . '/imagenes/imagen.php';

    // rutas nuevas pqr
    require __DIR__ . '/responsablePqrsf/responsablePqrsf.php';
    require __DIR__ . '/areaResponsablePqrsf/areaResponsablePqrsf.php';


    // rutas operador
    require __DIR__ . '/operadores/operador.php';

    //ruta mesa ayuda
    require __DIR__ . '/mesaAyuda/areaMesaAyuda.php';

    require __DIR__ . '/antecedentes/antecedenteHospitalario.php';

    require __DIR__ . '/antecedentes/apgarFamiliar.php';
    require __DIR__ . '/antecedentes/resultadoLaboratorio.php';

    require __DIR__ . '/areaSolicitude/areaSolicitudes.php';

    //ruta insumos procedimientos
    require __DIR__ . '/InsumosProcedimientos/InsumosProcedimientos.php';

    require __DIR__ . '/paraclinicos/paraclinico.php';

    require __DIR__ . '/estratificacionFramingham/estratificacionFramingham.php';

    require __DIR__ . '/estratificacionFindrisk/estratificacionFindrisks.php';

    require __DIR__ . '/antecedentePatologia/antecedentePatologia.php';

    require __DIR__ . '/Alertas/alertas.php';

    require __DIR__ . '/alertaDetalles/alertaDetalles.php';


    // ruta para farmacias
    require __DIR__ . '/programasFarmacias/programaFarmacia.php';
    require __DIR__ . '/programasFarmacias/programasBodegas.php';

    //Bodegas
    require __DIR__ . '/BodegasReps/BodegasReps.php';


    // ruta para precio entidad por medicamento

    require __DIR__ . '/precioEntidadMedicamentos/precioEntidadMedicamento.php';

    //nota aclaratoria
    require __DIR__ . '/notaAclaratoria/notaAclaratorias.php';

    //Antecedentes odontologicos
    require __DIR__ . '/antecedentesOdontologicos/antecedentesOdontologicos.php';

    //Examen fisico odontologia
    require __DIR__ . '/examenFisicoOdontologia/examenFisicoOdontologia.php';

    //Examen tejidos duros
    require __DIR__ . '/examenTejidosDuros/examenTejidosDuros.php';

    //Periodontograma
    require __DIR__ . '/periodontograma/periodontograma.php';

    //plan tratamiento odontologia
    require __DIR__ . '/planTratamientoOdontologia/planTratamientoOdontologia.php';

    //paraclinicos odontologia
    require __DIR__ . '/paraclinicosOdontologia/paraclinicosOdontologia.php';

    //tipo consulta
    require __DIR__ . '/tipoConsultas/tipoConsulta.php';

    //gestion orden prestador
    require __DIR__ . '/gestionOrdenPrestador/gestionOrdenPrestador.php';

    //gestion tipo violencia
    require __DIR__ . '/tipoViolencia/tipoViolencia.php';

    //practica interviene salud
    require __DIR__ . '/practicaIntervieneSalud/practicaIntervieneSalud.php';

    //tipo cancer caracterizacion
    require __DIR__ . '/tipoCancerCaracterizacion/tipoCancerCaracterizacion.php';

    //tipo metabolicas caracterizacion
    require __DIR__ . '/tipoMetabolicasCaracterizacion/tipoMetabolicasCaracterizacion.php';

    //tipo rcv caracterizacion
    require __DIR__ . '/tipoRCVCaracterizacion/tipoRCVCaracterizacion.php';

    //tipo respiratorias caracterizacion
    require __DIR__ . '/tipoRespiratoriasCaracterizacion/tipoRespiratoriasCaracterizacion.php';

    //tipo inmunodeficiencias caracterizacion
    require __DIR__ . '/tipoInmunodeficienciasCaracterizacion/tipoInmunodeficienciasCaracterizacion.php';

    //condiciones riesgo caracterizacion
    require __DIR__ . '/condicionesRiesgoCaracterizacion/condicionesRiesgoCaracterizacion.php';

    //ruta promocion caracterizacion
    require __DIR__ . '/rutaPromocionCaracterizacion/rutaPromocionCaracterizacion.php';

    require __DIR__ . '/RemisionProgramas/remisionProgramas.php';

    require __DIR__ . '/HabitosAlimentarios/habitosAlimentarios.php';


    require __DIR__ . '/sindromeGeriatrico/sindromeGeriatrico.php';

    require __DIR__ . '/TipoTest/tipoTest.php';

    require __DIR__ . '/preguntasTipoTest/preguntasTipoTest.php';

    require __DIR__ . '/RespuestaTest/RespuestaTest.php';

    require __DIR__ . '/interpretacionResultados/interpretacionResultados.php';

    require __DIR__ . '/OdontologiaProcedimientos/odontologiaProcedimientos.php';

    require __DIR__ . '/odontograma/odontograma.php';

    require __DIR__ . '/modalidadGrupoServicioTecSal/modalidadGrupoTecSal.php';

    require __DIR__ . '/grupoServicios/grupoServicios.php';

    require __DIR__ . '/codigoServicios/codigoServicios.php';

    require __DIR__ . '/finalidadConsulta/finalidadConsulta.php';

    require __DIR__ . '/ConsultaCausaExterna/ConsultaCausaExterna.php';

    require __DIR__ . '/RecomendacionesConsulta/RecomendacionesConsulta.php';

    require __DIR__ . '/NivelKaiser/nivelKaiser.php';

    // Manuales Inicio
    require __DIR__ . '/manuales/manuales.php';

    // Videos Inicio
    require __DIR__ . '/videos/videos.php';

    // Boletines Inicio
    require __DIR__ . '/boletines/boletines.php';

    require __DIR__ . '/concurrencia/costoEvitado.php';

    require __DIR__ . '/concurrencia/costoEvitable.php';

    require __DIR__ . '/concurrencia/eventoIngresoConcurrencia.php';

    require __DIR__ . '/concurrencia/lineaTiempoConcurrencia.php';

    // Derechos
    require __DIR__ . '/derechos/derechos.php';

    //CUESTIONARIOS PARA LA HISTORIA
    require __DIR__ . '/cuestionarioGAD2/cuestionarioGAD2.php';
    require __DIR__ . '/whooley/whooley.php';
    require __DIR__ . '/audit/audit.php';
    require __DIR__ . '/zarit/zarit.php';
    require __DIR__ . '/miniMental/miniMental.php';
    require __DIR__ . '/mChat/mChat.php';
    require __DIR__ . '/cuestionarioVale/cuestionarioVale.php';

    // Tipo estrategia telesalud
    require __DIR__ . '/tipoEstrategiaTelesalud/tipoEstrategiaTelesalud.php';

    // Telesalud
    require __DIR__ . '/telesalud/telesalud.php';

    //tipo de ruta
    require __DIR__ . '/tipoRutas/tipoRutas.php';

    // recomendaciones
    require __DIR__ . '/recomendaciones/recomendacion.php';
    //Resultado ayudas diagnosticas
    require __DIR__ . '/resultadoAyudasDiagnosticas/resultadoAyudasDiagnosticas.php';


    // Epidemiologia
    require __DIR__ . '/epidemiologia/epidemiologia.php';
    //Principios activos
    require __DIR__ . '/principioActivo/principioActivo.php';

    // Zonas
    require __DIR__ . '/zonas/zonas.php';

    //remision a programas
    require __DIR__ . '/ParametrizacionRemisionProgramas/ParametrizacionRemisionProgramas.php';

    require __DIR__ . '/familiograma/figura.php';
    require __DIR__ . '/familiograma/relacion.php';
    //remision a programas
    require __DIR__ . '/ParametrizacionRemisionProgramas/ParametrizacionRemisionProgramas.php';

    // Reportes
    require __DIR__ . '/reportes/reporte.php';

    //plan de cuidado
    require __DIR__ . '/plancuidado/planCuidado.php';
    //Escala del dolor
    require __DIR__ . '/escalaDolor/escalaDolor.php';

    //rqc
    require __DIR__ . '/rqc/rqc.php';

    //test srq
    require __DIR__ . '/srq/srq.php';

    //Figura humana
    require __DIR__ . '/figuraHumana/figuraHumana.php';

    // Contratos Medicamentos
    require __DIR__ . '/contratosMedicamentos/contratosMedicamentos.php';
    require __DIR__ . '/tarifasContratosMedicamentos/tarifasContratosMedicamentos.php';
    require __DIR__ . '/tarifasCums/tarifasCums.php';
    require __DIR__ . '/novedadesContratosMedicamentos/novedadesContratosMedicamentos.php';

    //organosFonoarticulatorios
    require __DIR__ . '/organosFonoarticulatorios/organosFonoarticulatorios.php';

    //examen fisioterapia
    require __DIR__ . '/ExamenFisicoFisioterapia/ExamenFisicoFisioterapia.php';

    //estructura dinamica
    require __DIR__ . '/EstructuraDinamicaFamiliar/EstructuraDinamicaFamiliar.php';
    require __DIR__ . '/valoracionAntropometrica/valoracionAntropometrica.php';
    require __DIR__ . '/Minuta/minuta.php';
    require __DIR__ . '/estadoAnimoComportamiento/estadoAnimoComportamiento.php';
    require __DIR__ . '/rxFinal/rxFinal.php';

    // Tratamiento Farmacológico
    require __DIR__ . '/tratamientoFarmacologico/tratamientoFarmacologico.php';

    // Evolución Signos y Sintomas
    require __DIR__ . '/evolucionSignosSintomas/evolucionSignosSintomas.php';
    // ecomapa
    require __DIR__ . '/ecomapa/figuraEcomapa.php';
    require __DIR__ . '/ecomapa/relacionEcomapa.php';

    // gestacion
    require __DIR__ . '/antecedentesGestacion/antecedentesGestacion.php';
    //Parto

    require __DIR__ . '/antecedenteParto/antecedenteParto.php';


    //conducta
    require __DIR__ . '/conductaRelacionamiento/conductaRelacionamiento.php';

    //conducta inadaptativa
    require __DIR__ . '/conductaInadaptativa/conductaInadaptativa.php';

    //Sucesion evolutiva
    require __DIR__ . '/sucesionEvolutiva/sucesionEvolutiva.php';

    //Tanner
    require __DIR__ . '/escalaTanner/escalaTanner.php';



    //patologia Respiratoria (Historia clinica 32)
    require __DIR__ . '/patologiaRespiratoria/patologiaRespiratoria.php';
    //sistema Respiratrorio (Historia clinica 32)
    require __DIR__ . '/sistemaRespiratorio/sistemaRespiratorio.php';
    //Adjuntos Ayudas Diagnosticos
    require __DIR__ . '/adjuntosAyudasDiagnosticos/adjuntosAyudasDiagnosticas.php';

    require __DIR__ . '/logsKeiron/logsKeiron.php';


    # Logs de interoperabilidad
    require __DIR__ . '/segimientoInteroperabilidad/segimientoInteroperabilidad.php';

    require __DIR__ . '/clientes/clientes.php';

    require __DIR__ . '/tipoSolicitudEntidades/tipoSolicitudEntidades.php';
    require __DIR__ . '/indicadores/indicador.php';

    // rutas de notificaciones
    require __DIR__ . '/notificacion/notificaciones.php';

    // rutas evolucion

    require __DIR__ . '/evolucion/evolucion.php';

    // rutas epicrisis
    require __DIR__ . '/epicrisi/epicrisis.php';


    //imagenes inicio
    require __DIR__ . '/imagenesInicio/imagenesInicio.php';

    //Proveedores
    require __DIR__ . '/areasProveedores/areasProveedores.php';
    require __DIR__ . '/lineasCompras/lineasCompras.php';
    require __DIR__ . '/proveedoresCompras/proveedoresCompras.php';
    //Parametrizacion de codesumis por entidades
    require __DIR__ . '/codesumiEntidad/codesumiEntidad.php';

    //Oficios
    require __DIR__ . '/oficio/oficios.php';

    //Eventos Sivigila
    require __DIR__ . '/eventoSivigila/eventos.php';

    //Cabeceras Sivigila
    require __DIR__ . '/cabeceraSivigila/cabeceras.php';

    //Campos Sivigila
    require __DIR__ . '/campoSivigila/campo.php';

    //Opciones Campos Sivigila
    require __DIR__ . '/opcionesCamposSivigila/opciones.php';

    //Componentes HIstoria Clinica
    require __DIR__ . '/componentesHistoriaClinica/componentesHistoriaClinica.php';

    //pabellon
    require __DIR__ . '/pabellones/pabellon.php';
    require __DIR__ . '/camas/cama.php';
    require __DIR__ . '/asignacionCama/asignacionCamas.php';
    require __DIR__ . '/camas/novedadCamas.php';
    require __DIR__ . '/notaEnfermeriaUrgencia/notaEnfermeriaUrgencias.php';

    require __DIR__ . '/signosVitales/signoVital.php';
    require __DIR__ . '/oxigeno/oxigeno.php';
    require __DIR__ . '/consentimientoInformadoUrgencia/consentiemientoInformadoUrgencias.php';

    //Forma farmaceutica ffm
    require __DIR__ . '/formaFarmaceuticaffm/formaFarmaceuticaffm.php';

    //Unidades de medidas de los medicamentos
    require __DIR__ . '/unidadesMedidasMedicamentos/unidadesMedidasMedicamentos.php';

    //Unidades medidas medicamentos dispensación
    require __DIR__ . '/unidadesMedidasMedicamentosDispensacion/unidadesMedidasMedicamentosDispensacion.php';

    require __DIR__ . '/registroRecepcionOrdenesInteroperabilidad/registroRecepcionOrdenesInteroperabilidad.php';

    //Escala Abreviada Desarrollo
    require __DIR__ . '/escalaAbreviadaDesarrollo/escalaAbreviadaDesarrollo.php';

    //CAC
    require __DIR__ . '/cac/cac.php';
    //Barreras de Acceso Parametrización
    //Tipos de Barreras Acceso
    require __DIR__ . '/barreraAccesos/tipoBarreraAcceso.php';
    //Responsable
    require __DIR__ . '/barreraAccesos/responsable.php';
    //Area Responsable
    require __DIR__ . '/barreraAccesos/areaResponsable.php';

    //cobro Servicios
    require __DIR__ . '/cobroServicio/cobroServicio.php';

    //Logos para prestadores y reps
    require __DIR__ . '/LogosRepHistoria/LogosRepHistoria.php';

    //Tratamientos cronicos
    require __DIR__ . '/TratamientosCronicos/tratamientosCronicos.php';

    //Tratamientos Biologicos
    require __DIR__ . '/TratamientosBiologicos/TratamientosBiologicos.php';

    //Recibe Quimioterapia
    require __DIR__ . '/RecibeQuimioterapia/RecibeQuimioterapia.php';

    //Tipos de cancer
    require __DIR__ . '/tipoCancer/tipoCancer.php';

    //Biopsias
    require __DIR__ . '/registroBiopsiaPatologias/registroBiopsiaPatologias.php';

    require __DIR__ . '/ordenamientos/paqueteOrdenamiento.php';

    //RUTAS PARA FACTURACION DE SERVICIOS DE SALUD ELECTRONICAMENTE
    require __DIR__ . '/facturacionElectronica/facturacionElectronica.php';

    //rips sumimedical
    require __DIR__ . '/logRegistroSumi/logRegistroSumi.php';

    //Rutas para consolidacion de mesa de ayuda
    require __DIR__ . '/clienteMesaAyuda/clienteMesaAyuda.php';
    //funcion renal
    require __DIR__ . '/funcionRenal/funcionRenal.php';

    //Graficas oms
    require __DIR__ . '/graficasOms/graficasOms.php';

    // facturacion de servicios y medicamentos
    require __DIR__ . '/facturacion/facturacion.php';

    require __DIR__ . '/imagenesSoporte/imagenesSoporte.php';


    require __DIR__ . '/interoperabilidadMesaAyuda/interoperabilidadMesaAyuda.php';
});

///// API ACCESO KEIRON /////
Route::middleware(['client'])->group(function () {
    require __DIR__ . '/keiron/keiron.php';
});

/** interoperabilidad */
require __DIR__ . '/interoperabilidad/interoperabilidad.php';

Route::prefix('ordenamiento')->group(function () {
    Route::post('/historico-por-afiliado', [OrdenamientoController::class, 'historico'])->middleware('auditoria.uso');
});
