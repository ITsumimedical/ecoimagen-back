<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosas\Repositories;


use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\RadicacionGlosas\Models\RadicacionGlosa;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Reps\Models\Rep;
use App\Traits\ArchivosTrait;


class RadicacionGlosaRepository extends RepositoryBase {

    protected $radicacion;
    use ArchivosTrait;

    public function __construct() {
        $this->radicacion = new RadicacionGlosa();
        parent::__construct($this->radicacion);
    }

    public function crearActualizar($data){
        $operador = Operadore::select('prestador_id')->where('user_id',Auth::user()->id)->first();
        $glosa = RadicacionGlosa::updateOrCreate(['glosa_id' =>  request('id')],
        [
         'respuesta_prestador' => $data['respuesta_prestador'],
         'codigo' => $data['codigo'],
         'valor_no_aceptado' => $data['valor_no_aceptado'],
         'valor_aceptado' => $data['valor_aceptado'],
         'prestador_id' => $operador->prestador_id,
         'glosa_id' =>  $data['id'],
         'estado' => 1
    ]);


    return $glosa;

    }

    public function cargarArchivo($data) {
         $archivo = $data->file('adjunto');
        $ruta = 'adjuntosCuentasMedicas';
        if ($archivo){
            $existe = RadicacionGlosa::where('glosa_id',$data->id)->first();
             $nombreOriginal = $this->obtenerNombreArchivo($archivo);
             $operador = Operadore::select('prestador_id')->where('user_id',Auth::user()->id)->first();
            if($existe){
                $nombre = $operador->prestador_id .'/'.$data->id.'g'.time().$nombreOriginal;
                 $subirArchivo = $this->subirArchivoNombre($ruta,$archivo,$nombre,'server37');
                 RadicacionGlosa::where('glosa_id',$data->id)->update([
                    'archivo' => $subirArchivo
                ]);

               return  'Exito al cargar el archivo.';
            }else{
                return  'Aun no existe una respuesta!';
            }
        }

    }



}
