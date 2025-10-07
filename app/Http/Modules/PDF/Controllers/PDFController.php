<?php

namespace App\Http\Modules\PDF\Controllers;


use App\Formats\Anexo2;
use App\Formats\Anexo9;
use App\Formats\Anexos;
use App\Formats\CaracterizacionEcis;
use App\Formats\MedicamentoIntrahospitalario;
use App\Formats\Prefactura;
use App\Formats\Servicio;
use App\Formats\TeleApoyo;
use App\Formats\Telesalud;
use App\Formats\Incapacidad;
use App\Formats\Medicamento;
use Illuminate\Http\Request;
use setasign\Fpdi\TcpdfFpdi;
use App\Formats\CodigoPropio;
use App\Formats\HistoriaBase;
use App\Formats\ActaRecepcion;
use App\Formats\AnalisisCasos;
use App\Formats\Anexo1;
use App\Formats\FormatoSarlaft;
use App\Formats\HistoriaBaseV1;
use App\Formats\Anexo3Servicios;
use App\Formats\CertificadoRips;
use App\Formats\HistoriaClinica;
use App\Formats\SolicitudCompra;
use App\Formats\Anexo3Medicamentos;
use App\Formats\RecomendacionesCups;
use App\Http\Controllers\Controller;
use App\Formats\ChatsCentroRegulador;
use App\Formats\MedicamentoPendiente;
use App\Formats\RecomendacionesCie10;
use App\Http\Modules\Reps\Models\Rep;
use App\Formats\MedicamentoDispensado;
use App\Formats\CertificadoIncapacidad;
use App\Formats\SolicitudCopiaHistoria;
use App\Formats\RecomendacionesConsultas;
use App\Http\Modules\Chat\Models\mensaje;
use App\Formats\CertificadoAtencionMedica;
use App\Formats\ConsentimientosInformados;
use App\Formats\HistoriaClinicaIntegralBase;
use App\Formats\certificadoAtencionLaboratorio;
use App\Formats\FormatoNegacion;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use Illuminate\Validation\UnauthorizedException;
use App\Formats\CertificadoAtencionMedicinaIntegral;
use App\Formats\CertificadoEpicrisis;
use App\Formats\CertificadoFormatoReferencia;
use App\Formats\CertificadoTriage;
use App\Formats\consentimientoInformadoAnestesia;
use App\Formats\consentimientoInformadoTelemedicina;
use App\Formats\ConsentimientosInformadosLaboratorio;
use App\Formats\EvolucionCertificado;
use App\Formats\IncapacidadGenerico;
use App\Formats\NotaEnfermeriaUrgencias;
use App\Formats\OxigenoUrgencias;
use App\Formats\ReciboCaja;
use App\Formats\SignosVitalesFormato;
use App\Http\Modules\AdmisionesUrgencias\Repositories\AdmisionesUrgenciaRepository;
use App\Http\Modules\Chat\Repositories\MensajeRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\DetalleSolicitudBodegas\Repositories\DetalleSolicitudBodegaRepository;
use App\Http\Modules\Eventos\EventosAdversos\Repositories\EventoAdversoRepository;
use App\Http\Modules\Incapacidades\Models\Incapacidade;
use App\Http\Modules\Incapacidades\Repositories\IncapacidadRepository;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Ordenamiento\Models\OrdenCodigoPropio;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Ordenamiento\Repositories\OrdenArticuloRepository;
use App\Http\Modules\Ordenamiento\Repositories\OrdenProcedimientoRepository;
use App\Http\Modules\PDF\Repositories\PdfRepository;
use App\Http\Modules\PDF\Requests\UnirPdfRequest;
use App\Http\Modules\PDF\Services\PdfService;
use Illuminate\Support\Facades\Storage; // Asegúrate de importar Storage
use App\Http\Modules\RecomendacionesConsulta\Model\RecomendacionesConsulta;
use App\Http\Modules\Rips\Repositories\PaqueteRipRepository;
use App\Http\Modules\SolicitudBodegas\Repositories\SolicitudBodegaRepository;
use App\Http\Modules\Telesalud\Repositories\TelesaludRepository;
use App\Traits\PdfTrait;

class PDFController extends Controller
{

    public function __construct(
        protected PdfService $pdfService,
        protected ConsultaRepository $consultaRepository,
        protected IncapacidadRepository $incapacidadRepository,
        protected SolicitudBodegaRepository $solicitudBodegaRepository,
        protected EventoAdversoRepository $eventoAdversoRepository,
        protected OrdenArticuloRepository $ordenArticuloRepository,
        protected OrdenProcedimientoRepository $ordenProcedimientoRepository,
        protected AdmisionesUrgenciaRepository $admisionesUrgenciaRepository,
        protected TelesaludRepository $telesaludRepository,
        protected PaqueteRipRepository $paqueteRipRepository,
        protected MensajeRepository $mensajeRepository,
        protected DetalleSolicitudBodegaRepository $detalleSolicitudBodegaRepository,
    ) {}

    public function imprimir(Request $request)
    {

        // if(isset($request->documento)){
        //     $afiliado = Afiliado::where('numero_documento', $request->documento)->first();
        //     if ($afiliado->estado_afiliacion_id == 31) {
        //         throw new Error('El afiliado se encuentra Retirado', 403);
        //     }
        // }

        // $afiliado = Afiliado::where('numero_documento', $request->documento)->first();
        // if ($afiliado->estado_afiliacion_id == 31) {
        //     throw new Error('El afiliado se encuentra Retirado', 403);
        // }f

        switch ($request->tipo) {
            case 'medicamento':
                if (isset($request->detalles)) {
                    if ($request->filtro === 1 || $request->filtro === 9) {
                        $orden = Orden::where('id', $request->id)->first();
                        $ordenArticulo = OrdenArticulo::where('orden_articulos.orden_id', $orden->id)->first();
                    } else {
                        $ordenArticulo = OrdenArticulo::where('orden_articulos.id', $request->detalles['id'])->first();
                    }
                    $pdf = new Medicamento();
                    return $pdf->generar($ordenArticulo, $request->filtro, $request->fomag || null);
                }
                break;

            case 'servicio':

                $ubicaciones = [];
                $enviar = $request->enviar ?? null;
                $correo = $request->correo ?? null;
                $pdfFiles = [];

                if (isset($request->detalles)) {

                    $pdfPath = $this->generarPdfServicio($request->detalles, $enviar, $correo, $request->fomag);
                    if ($request->fomag) {
                        return $pdfPath;
                    }
                    $pdfFiles[] = $pdfPath;
                } else {
                    foreach ($request->servicios as $servicio) {
                        $orden_procedimiento = OrdenProcedimiento::leftJoin('auditorias', 'auditorias.orden_procedimiento_id', 'orden_procedimientos.id')
                            ->where('orden_procedimientos.id', $servicio['identificador'])
                            ->first();

                        $fechaOrden = $orden_procedimiento->fecha_vigencia;
                        if ($orden_procedimiento->rep_id) {
                            $sede = Rep::find($orden_procedimiento->rep_id);
                            $ubicaciones[$orden_procedimiento->rep_id]["servicios"][] = $orden_procedimiento;
                            $ubicaciones[$orden_procedimiento->rep_id]["datos"] = $sede;
                        } else {
                            $ubicaciones['sin_dato']["servicios"][] = $orden_procedimiento;
                            $ubicaciones['sin_dato']["datos"] = [];
                        }
                    }

                    foreach ($ubicaciones as $repId => $ubicacion) {
                        $pdf = new Servicio();
                        $pdfPath = storage_path('app/temp/') . uniqid() . '.pdf';
                        $pdf->generar($ubicacion, $enviar, $correo, $pdfPath);
                        $pdfFiles[] = $pdfPath;
                    }
                }

                // Combinar los PDFs generados
                $combinedPdfPath = storage_path('app/temp/') . 'combined_' . uniqid() . '.pdf';
                $this->combinePdfs($pdfFiles, $combinedPdfPath);

                // Limpiar archivos temporales
                foreach ($pdfFiles as $file) {
                    Storage::delete($file);
                }

                // Devolver el PDF combinado
                return response()->file($combinedPdfPath);
            case 'codigoPropio':
                $ubicaciones = [];
                $enviar = $request->enviar ?? null;
                $correo = $request->correo ?? null;
                $pdfFiles = [];

                if (isset($request->detalles)) {
                    $pdfPath = $this->generarPdfCodigoPropio($request->detalles, $enviar, $correo);
                    $pdfFiles[] = $pdfPath;
                } else {
                    foreach ($request->servicios as $servicio) {
                        $orden_codigo_propio = OrdenCodigoPropio::leftJoin('auditorias', 'auditorias.orden_codigo_propio_id', 'orden_codigo_propios.id')
                            ->where('orden_codigo_propios.id', $servicio['identificador'])
                            ->first();

                        $fechaOrden = $orden_codigo_propio->fecha_vigencia;
                        if ($orden_codigo_propio->rep_id) {
                            $sede = Rep::find($orden_codigo_propio->rep_id);
                            $ubicaciones[$orden_codigo_propio->rep_id]["servicios"][] = $orden_codigo_propio;
                            $ubicaciones[$orden_codigo_propio->rep_id]["datos"] = $sede;
                        } else {
                            $ubicaciones['sin_dato']["servicios"][] = $orden_codigo_propio;
                            $ubicaciones['sin_dato']["datos"] = [];
                        }
                    }

                    foreach ($ubicaciones as $repId => $ubicacion) {
                        $pdf = new codigoPropio();
                        $pdfPath = storage_path('app/temp/') . uniqid() . '.pdf';
                        $pdf->generar($ubicacion, $enviar, $correo, $pdfPath);
                        $pdfFiles[] = $pdfPath;
                    }
                }

                // Combinar los PDFs generados
                $combinedPdfPath = storage_path('app/temp/') . 'combined_' . uniqid() . '.pdf';
                $this->combinePdfs($pdfFiles, $combinedPdfPath);

                // Limpiar archivos temporales
                foreach ($pdfFiles as $file) {
                    Storage::delete($file);
                }

                // Devolver el PDF combinado
                return response()->file($combinedPdfPath);


                //No se requiere teleapoyo
                // case 'teleapoyo':
                //     $pdf = new TeleApoyo();
                //     return $pdf->generar($request);

                //No se modifica consentimientos Informados
            case 'consentimientoInformado':
                $pdf = new ConsentimientosInformados('P', 'mm', 'A4');
                return $pdf->generar($request->all());

            case 'consentimientoInformadoLaboratorio':
                $pdf = new ConsentimientosInformadosLaboratorio();
                return $pdf->generar($request->all());

            case 'incapacidad':
                $incapacidad = $this->incapacidadRepository->formatoIncapacidad($request);

                if (!$incapacidad || !isset($incapacidad->entidad)) {
                    throw new \Exception("No se pudo obtener la información de la incapacidad o el campo 'entidad' no está definido.");
                }

                $pdf = match ($incapacidad->entidad) {
                    3 => new CertificadoIncapacidad('P', 'mm', 'A4'),
                    1 => new Incapacidad('P', 'mm', 'A4'),
                    default => new IncapacidadGenerico('P', 'mm', 'A4'),
                };

                return $pdf->generar($incapacidad);

            case 'recomendacionOrdenCup':
                $recomendaciones = $this->consultaRepository->recomendacionesCups($request);
                $pdf = new RecomendacionesCups('P', 'mm', 'A4');
                return $pdf->generar($recomendaciones);

            case 'ordenCompra':
                $ordenCompra = $this->solicitudBodegaRepository->formatoSolicitudes($request->id);
                $pdf = new SolicitudCompra('p', 'mm', 'A4');
                return $pdf->generar($ordenCompra);

            case 'historia':
                $consulta = $this->consultaRepository->consultarCompleto($request, 'HistoriaClinica');
                $pdf = new HistoriaClinicaIntegralBase('P', 'mm', 'A4');
                $pdf->generar($consulta, $request->correo, $request->triage);
                break;

            //NO SE UTILIZA
            case 'historiaAntigua':
                $pdf = new HistoriaClinica();
                $pdf->generar($request->consulta, $request->correo);
                break;

            //NO SE UTILIZA
            case 'historia_base':
                $pdf = new HistoriaBase();
                $pdf->generar($request->consulta, $request->correo);
                break;

            case 'ActaRecepcion':
                $actaRecepcion = $this->detalleSolicitudBodegaRepository->actaRecepcion($request->all());
                $pdf = new ActaRecepcion('p', 'mm', 'A3');
                return $pdf->generar($actaRecepcion);

            case 'solicitudCopiaHistoria':
                $pdf = new SolicitudCopiaHistoria('p', 'mm', 'A4');
                $pdf->generar();
                return $pdf;

            case 'eventoAdverso':
                $analisisCasos = $this->eventoAdversoRepository->formatoAnalisisCasos($request->all());
                $pdf = new AnalisisCasos('P', 'mm', 'A4');
                $pdf->generar($analisisCasos);
                return $pdf;

            case 'Sarlafts':
                $pdf = new FormatoSarlaft();
                return $pdf->generar($request->id);

            case 'anexo10':
                $pdf = new Anexos('P', 'mm', 'A4');
                return $pdf->generar($request->all());

            case 'anexo3Medicamentos':
                $anexo3medicamentos = $this->consultaRepository->anexos($request, 4);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo3medicamentos, 4);

            case 'anexo3Servicios':
                $anexo3Servicios = $this->consultaRepository->anexos($request, 3);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo3Servicios, 3);

            case 'anexo3codigoPropio':
                $anexo3Servicios = $this->consultaRepository->anexos($request, 3, true);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo3Servicios, 3);

            case 'anexo4Medicamentos':
                $anexo4medicamentos = $this->consultaRepository->anexos($request, 4);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo4medicamentos, 5);

            case 'anexo4Servicios':
                $anexo4Servicios = $this->consultaRepository->anexos($request, 3);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo4Servicios, 5);

            case 'anexo4codigoPropio':
                $anexo4Servicios = $this->consultaRepository->anexos($request, 3, true);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo4Servicios, 5);


            case 'anexo9':
                $anexo9 = $this->consultaRepository->anexos($request, 9);
                $pdf = new Anexo1('P', 'mm', 'A4');
                return $pdf->generar($anexo9, 9);

            case 'anexo9Referencia':
                $pdf = new Anexos('P', 'mm', 'A4');
                return $pdf->generar($request->all());

            case 'ChatsCentroRegulador':
                $mensajes = $this->mensajeRepository->chatsCentroRegulador($request);
                $pdf = new ChatsCentroRegulador();
                return $pdf->generar($mensajes);

            case 'medicamentoDispensado':
                if (isset($request->detalles)) {
                    $ordenArticulo = OrdenArticulo::where('orden_articulos.id', $request->detalles['id'])->first();
                    $pdf = new MedicamentoDispensado();
                    return $pdf->generar($ordenArticulo, $request->detalles['movimiento']);
                }
            case 'medicamentoPendiente':
                $medicamentoPendiente = $this->ordenArticuloRepository->medicamentoPendiente($request->orden_id);
                $pdf = new MedicamentoPendiente('p', 'mm', 'A4');
                return $pdf->generar($medicamentoPendiente);
                break;

            case 'impresionV1':
                $pdf = new HistoriaBaseV1();
                return $pdf->generar($request->data);

            case 'certificadoRips':
                $certificadoRips = $this->paqueteRipRepository->certificadoRips($request);
                $pdf = new CertificadoRips('P', 'mm', 'A4');
                return $pdf->generar($certificadoRips);

            case 'recomendacionesConsulta':
                $recomendacionesConsultas = $this->consultaRepository->recomendacionesConsultas($request->consulta);
                $pdf = new RecomendacionesConsultas('p', 'mm', 'A4');
                return $pdf->generar($recomendacionesConsultas);

            case 'telesalud':
                $telesalud = $this->telesaludRepository->formatoTelesalud($request->telesalud_id);
                $pdf = new Telesalud('p', 'mm', 'A4');
                $pdf->generar($telesalud);
                return $pdf;

            case 'recomendacionDiagnosticos':
                $recomendaciones = $this->consultaRepository->recomendacionesCie10($request->all());
                $pdf = new RecomendacionesCie10('P', 'mm', 'A4');
                return $pdf->generar($recomendaciones);

            case 'recomendacionServicios':
                $recomendaciones = $this->consultaRepository->recomendacionesCups($request);
                $pdf = new RecomendacionesCups('P', 'mm', 'A4');
                return $pdf->generar($recomendaciones);

            case 'certificadoAtencionMedica':
                $pdf = new CertificadoAtencionMedica();
                return $pdf->generar($request);

            case 'certificadoAtencionLaboratorio':
                $certificadoLaboratorio = $this->ordenProcedimientoRepository->certificadoAtencionLaboratorio($request);
                $pdf = new CertificadoAtencionLaboratorio('L', 'mm', [285, 150]);
                return $pdf->generar($certificadoLaboratorio);

            case 'consentimientoInformadoTelemedicina':
                $consentimiento = $this->consultaRepository->consentimientoTelemedicina($request);
                $pdf = new consentimientoInformadoTelemedicina('P', 'mm', 'A4');
                return $pdf->generar($consentimiento);

            case 'consentimientoInformadoAnestesia':
                $consentimiento = $this->consultaRepository->consentimientoAnestesia($request->consulta_id);
                $pdf = new consentimientoInformadoAnestesia('P', 'mm', 'A4');
                return $pdf->generar($consentimiento);

            case 'formatoNegacion':
                $pdf = new FormatoNegacion('P', 'mm', 'A4');
                $pdf = $this->pdfService->formatoNegacion($pdf, $request);
                return $pdf;
                break;

            case 'anexo2':
                $anexo2 = $this->consultaRepository->anexo2($request);
                $pdf = new Anexo2('P', 'mm', 'A4');
                return $pdf->generar($anexo2);

            case 'CertificadoMedimas':
                $certificadoMedimas = $this->consultaRepository->certificadoMedimas($request);
                $pdf = new CertificadoAtencionMedicinaIntegral('L', 'mm', [290, 150]);
                $pdf->generar($certificadoMedimas);
                return $pdf;
                break;

            case 'CertificadoTriage':
                $certificadoTriage = $this->admisionesUrgenciaRepository->certificadoTriage($request);
                $pdf = new CertificadoTriage('L', 'mm', [290, 150]);
                $pdf->generar($certificadoTriage);
                return $pdf;
                break;

            case 'Evolucion':
                $evolucionCertificado = $this->consultaRepository->evolucionCertificado($request);
                $pdf = new EvolucionCertificado('p', 'mm', 'A4');
                $pdf->generar($evolucionCertificado);
                return $pdf;

                //epicriasis
            case 'CertificadoEpicrisis':
                $pdf = new CertificadoEpicrisis();
                return $pdf->generar($request);

                /// falta por error en epicriasis
            case 'CertificadoFormatoReferencia':
                $pdf = new CertificadoFormatoReferencia();
                return $pdf->generar($request);
            case 'medicamentoIntrahospitalario':
                $pdf = new MedicamentoIntrahospitalario();
                return $pdf->generar($request->all());


            case 'notaEnfermeriaUrgencias':
                $pdf = new NotaEnfermeriaUrgencias();
                return $pdf->generar($request);

            case 'oxigenoUrgencias':
                $pdf = new OxigenoUrgencias();
                return $pdf->generar($request);

            case 'signosVitales':
                $pdf = new SignosVitalesFormato();
                return $pdf->generar($request);

            case 'prefactura':
                $pdf = new Prefactura();
                return $pdf->generar();

            case 'caracterizacionEcis':
                $pdf = new CaracterizacionEcis();
                return $pdf->generar($request->all());

            case 'reciboCaja':
                $pdf = new ReciboCaja();
                return $pdf->generar($request->all());
        }
    }

    private function combinePdfs($pdfFiles, $outputPath)
    {
        $pdf = new TcpdfFpdi();
        foreach ($pdfFiles as $file) {
            $pageCount = $pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                $pdf->useTemplate($templateId);
            }
        }
        $pdf->Output($outputPath, 'F');
    }


    private function generarPdfCodigoPropio($detalles, $enviar, $correo)
    {
        $orden_codigo_propio = OrdenCodigoPropio::leftJoin('auditorias', 'auditorias.orden_codigo_propio_id', 'orden_codigo_propios.id')
            ->where('orden_codigo_propios.id', $detalles['id'])
            ->first();

        $fechaOrden = $orden_codigo_propio->fecha_vigencia;
        $ubicaciones = [];

        if ($orden_codigo_propio->rep_id) {
            $sede = Rep::find($orden_codigo_propio->rep_id);
            $ubicaciones["servicios"][] = $orden_codigo_propio;
            $ubicaciones["datos"] = $sede;
        } else {
            $ubicaciones["servicios"][] = $orden_codigo_propio;
            $ubicaciones["datos"] = [];
        }

        $pdf = new CodigoPropio();
        $pdfPath = storage_path('app/temp/') . uniqid() . '.pdf';
        $pdf->generar($ubicaciones, $enviar, $correo, $pdfPath);
        return $pdfPath;
    }


    private function generarPdfServicio($detalles, $enviar, $correo, $fomag = false)
    {
        $orden_procedimiento = OrdenProcedimiento::leftJoin('auditorias', 'auditorias.orden_procedimiento_id', 'orden_procedimientos.id')
            ->where('orden_procedimientos.id', $detalles['id'])
            ->first();

        $fechaOrden = $orden_procedimiento->fecha_vigencia;
        $ubicaciones = [];

        if ($orden_procedimiento->rep_id) {
            $sede = Rep::find($orden_procedimiento->rep_id);
            $ubicaciones["servicios"][] = $orden_procedimiento;
            $ubicaciones["datos"] = $sede;
        } else {
            $ubicaciones["servicios"][] = $orden_procedimiento;
            $ubicaciones["datos"] = [];
        }

        $pdf = new Servicio();
        $pdfPath = storage_path('app/temp/') . uniqid() . '.pdf';
        $pdfEnBase64 = $pdf->generar($ubicaciones, $enviar, $correo, $pdfPath, "S E R V I C I O  M E D I C O", $fomag);
        return $pdfEnBase64;
    }

    public function unirPdf(UnirPdfRequest $request)
    {
        try {
            $pdf = $this->pdfService->unirPdf($request->validated());
            return response()->download($pdf, '', [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error durante el procesamiento de los documentos',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    public function imprimirPrefacturaElectronica(Request $request)
    {
        try {
            $pdf = $this->pdfService->imprimirPrefacturaElectronica($request->all());
            return response()->download($pdf, '', [
                'Content-Type' => 'application/pdf',
            ])->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Hubo un error durante el procesamiento de la prefactura',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
