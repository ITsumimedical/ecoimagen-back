<?php

namespace App\Http\Modules\Fias\Descarga\Services;

use App\Http\Modules\Fias\FiasGenerado\Models\FiasGenerado;
use App\Traits\ArchivosTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DescargaFiasService {

    use ArchivosTrait;

    public function determinarFias($fias){
        switch ($fias['tipo_fias']) {
            case 'F2A':
                $txt ='';
                $appointments = Collect(DB::select("SET NOCOUNT ON exec dbo.SP_Archivo_F2A ?,?",[intval($fias['anio']),intval($fias['mes'])]));
                $array = json_decode($appointments, true);
                foreach ($array as $key => $arra){
                    if ($key != count($array) - 1) {
                        $txt .= implode("|",$arra)."\r";
                    } else {
                        $txt .= implode("|",$arra);
                    }
                }

                return Response::make($txt);
                break;
            case 'F2B':
                $txt = "";
                $exportarsaldos =  json_decode(collect(DB::select("exec dbo.SP_Archivo_F2B ?,?", [$fias['mes'],$fias['anio']])),true);
                foreach ($exportarsaldos as $f2b){
                    $txt .= implode('|',$f2b)."\r".PHP_EOL;
                }
                return Response::make($txt);
                break;
            case 'F2C':
                $txt = "";
                $exportarsaldos =  json_decode(collect(DB::select("exec dbo.SP_Archivo_F2C ?,?", [$fias['mes'],$fias['anio']])),true);
                foreach ($exportarsaldos as $f2c){
                    $txt .= implode('|',$f2c)."\r".PHP_EOL;
                }
                return Response::make($txt);
                break;
            case 'F2D':
                $txt = "";
                $exportarsaldos =  json_decode(collect(DB::select("exec dbo.SP_Archivo_F2D ?,?", [$fias['mes'],$fias['anio']])),true);
                foreach ($exportarsaldos as $f2d){
                    $txt .= implode('|',$f2d)."\r".PHP_EOL;
                }
                return Response::make($txt);
                break;
default:
                throw new Exception('El tipo de fias no es valido.');
                break;
        }
}

            public function guardarFias($data,$txt){
                $nombreArchivo = $data['tipo_fias'] .''. $data['mes'] .''.$data['anio']. '.txt';

                // $fh = fopen($nombreArchivo, 'w');
                // fwrite($fh, $txt);
                // fclose($fh);

                // $contenido = public_path() . '/'. $nombreArchivo;
                // $ruta = 'fias';

                // $existe = FiasGenerado::where('mes', $data['mes'])->where('anio',$data['anio'])->first();
                // if(!$existe){
                //     $subirArchivo = $this->subirArchivoNombre($ruta,$contenido,$nombreArchivo,'server37');
                    FiasGenerado::create([
                        'ruta' =>$nombreArchivo,
                        'tipo_fias' => $data['tipo_fias'],
                        'mes' => $data['mes'],
                        'anio' => $data['anio'],
                        'user_id' => auth()->user()->id,
                    ]);
                // }else{
                //     $subirArchivo = $this->subirArchivoNombre($ruta,$contenido,$nombreArchivo,'server37');
                //     FiasGenerado::where('id',$existe->id)->update([
                //         'ruta' =>$subirArchivo,
                //         'tipo_fias' => $data['tipo_fias'],
                //         'mes' => $data['mes'],
                //         'anio' => $data['anio'],
                //         'user_id' => auth()->user()->id,
                //     ]);
                // }

                // return $contenido;

                // unlink($contenido);
            }
}
