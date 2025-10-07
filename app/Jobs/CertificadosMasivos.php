<?php

namespace App\Jobs;

use App\Formats\CertificadoAtencionMedica;
use App\Formats\MedicamentoDispensado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;
use Illuminate\Support\Facades\Storage;


class CertificadosMasivos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected static $bodegas = [
        'SUMIMEDICAL' => [48, 35, 33, 31, 32, 47, 1, 46, 29, 14, 49, 28, 34, 30, 39],
        'RAMEDICAS' => [4, 3, 8, 12, 5, 6, 7, 2, 51, 44, 10, 11, 9]
    ];

    /**
     * Create a new job instance.
     */
    private MedicamentoDispensado $medicamentoDispensado;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $articulosDispensados = OrdenArticulo::select([
            'orden_articulo_id as articulo',
            'm.id as movimiento',
        ])
            ->join('movimientos as m', 'orden_articulos.id', 'm.orden_articulo_id')
            ->join('ordenes as o', 'orden_articulos.orden_id', 'o.id')
            ->join('consultas as c', 'o.consulta_id', 'c.id')
            ->join('codesumis as s', 's.id', 'orden_articulos.codesumi_id')
            ->whereNotNull('c.firma_paciente')
            ->whereIn('orden_articulos.estado_id', [18, 34]);

        if ($this->data['bodega']) {
            $articulosDispensados->whereIn('m.bodega_origen_id', self::$bodegas[$this->data['bodega']]);
        }

        $entidad = Entidad::find($this->data['entidad']);
        $pathRaiz = storage_path('app/public/certificadosAtencionDispensacion/') . str_replace(' ', '', $entidad->nombre);

        File::makeDirectory($pathRaiz, 0777, true, true);
        $pathDispensacion = $pathRaiz . '/dispensacion';
        File::makeDirectory($pathDispensacion, 0777, true, true);
        foreach ($articulosDispensados->limit(10)->get()->toArray() as $articulo) {
            $medicamentoDispensado = new MedicamentoDispensado('p', 'mm', 'A4');
            $medicamentoDispensado->generar(['id' => $articulo['articulo']], $articulo['movimiento'], null, false, true, $pathDispensacion);
        }

        $pathCertificado = $pathRaiz . '/certificadosAtencion';
        File::makeDirectory($pathCertificado, 0777, true, true);
        $consultas = Consulta::select('consultas.id')
            ->join('afiliados as a', 'a.id', 'consultas.afiliado_id')
            ->where('a.entidad_id', $this->data['entidad'])
            ->where('consultas.tipo_consulta_id', '<>', 1)
            ->whereNotNull('consultas.firma_paciente')
            ->limit(10)
            ->get()->toArray();
        $certificadoAtencion = new CertificadoAtencionMedica();

        foreach ($consultas as $consulta) {
            $certificadoAtencion->generar(['consulta' => $consulta['id']], true, $pathCertificado);
        }

        $nombreZip = 'certificados' . uniqid() . '.zip';

        $rutaCarpeta = storage_path('app/public/certificadosAtencionDispensacion');

        $rutaZip = storage_path('app/public/certificadosAtencionDispensacion/' . $nombreZip);

        $zip = new ZipArchive();
        if ($zip->open($rutaZip, ZipArchive::CREATE) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rutaCarpeta), RecursiveIteratorIterator::LEAVES_ONLY);

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rutaCarpeta) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        } 

        $carpetaS3 = 'certificadosAtencionDispensacion';
        $rutaS3 = "$carpetaS3/$nombreZip";

        Storage::disk('server37')->put($rutaS3, file_get_contents($rutaZip));

        $url = Storage::disk('server37')->temporaryUrl($rutaS3, now()->addHours(24));

        // Mail::to($this->data['correo'])->send(new ZipCertificadosAtencionDispensacionMail($url));
        $data = [];
        $correo = $this->data['correo'];

        Mail::send('email_certificados_masivos', ['url' => $url], function ($message) use ($correo) {
            $message->to($correo);
            $message->subject('Certificados de Atención y Dispensación');
        });

        $ubicacionCarpeta = storage_path('app/public/certificadosAtencionDispensacion');

        if (File::exists($ubicacionCarpeta)) {
            File::deleteDirectory($ubicacionCarpeta);
        } 
    }
}
