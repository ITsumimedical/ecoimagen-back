<?php

namespace App\Http\Modules\CuentasMedicas\Glosas\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Modules\Rips\Af\Models\Af;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\Glosas\Models\Glosa;

class GlosaRepository extends RepositoryBase {

    protected $glosa;

    public function __construct() {
        $this->glosa = new Glosa();
        parent::__construct($this->glosa);
    }


    // obtiene las glosas que tiene una factura

    public function listarFacturasGlosa($data,$af_id){


        $glosas = Glosa::select('concepto','descripcion','codigo','valor','id')->where('af_id',$af_id);

        return $glosas->get();
    }

    //crea o actualiza una glosa

    public function glosar($request){
        if($request['id']){
            $glosa = Glosa::where('id',$request['id'])->update( ['codigo' => $request['codigo'],
         'concepto' => $request['concepto'],
         'descripcion' => $request['descripcion'],
         'valor' => $request['valor'],
         'af_id' => $request['af_id'],
         'estado_id' => 13,
         'user_id' => Auth::user()->id
        ]);
        }else {
        $glosa = Glosa::create( ['codigo' => $request['codigo'],
         'concepto' => $request['concepto'],
         'descripcion' => $request['descripcion'],
         'valor' => $request['valor'],
         'af_id' => $request['af_id'],
         'estado_id' => 13,
         'user_id' => Auth::user()->id
        ]);
        }


        return $glosa ;
    }

    public function afGlosa($afsAuditadas,$emailPrestador){
        $afs_conglosa_id = [];

        foreach ($afsAuditadas as $key) {
            $glosa = Glosa::where('af_id',$key->id)->first();
            if($glosa){
             $afs_conglosa_id[] = $glosa->af_id;
            }
                Af::where('id', $key->id)
                ->update([
                    'estado_id' => 17
                ]);
            }
            $afs = array_unique($afs_conglosa_id);

            if(count($afs) > 0){
                foreach ($afs as $af){
                    $updateAf = Af::where('id', $af)
                    ->update([
                        'estado_id' => 19,
                        'fecha_notificacion_prestador' => date('Y-m-d H:i:s')
                    ]);
                }

                Mail::send('email_cuentas_medicas',['email' => $emailPrestador],function ($message) use ($emailPrestador){
                    $message->to($emailPrestador->email);
                    $message->subject('Cuentas Medicas');
                });
                return  'El prestador fue notificado con exito!';
            }else{
                return 'No habia glosas por notificar, proceso guardado con exito!';
            }

    }

    public function glosasPrestador($data,$af_id){

        $glosasPrestador = $this->glosa->whereGlosasPrestador($af_id);

        return $glosasPrestador->get();
    }


    public function glosasConciliacion($data,$af_id){

        $glosasPrestador = $this->glosa->whereGlosasConciliacion($af_id);

        return $glosasPrestador->get();
    }

    public function glosasCerradas($data,$af_id){

        $glosasPrestador = $this->glosa->whereGlosasCerradas($af_id);

        return $glosasPrestador->get();
    }

    public function glosasFacturaFinal($data,$af_id){

        $glosasPrestador = $this->glosa->whereGlosasAuditoriaFinal($af_id);

        return $glosasPrestador->get();
    }

    public function contadorGlosas($af){
        return  $this->glosa::join('radicacion_glosas','glosas.id','radicacion_glosas.glosa_id')
        ->join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->where('glosas.af_id',$af)
        ->where('radicacion_glosa_sumimedicals.estado_id',1)
        ->count();
    }

    public function seleccionarGlosa($glosa){
        return $this->glosa::find($glosa);

    }

    public function contadorTotalGlosas($id_af){
        return $this->glosa::where('af_id',$id_af)->count();

    }

    public function contadorGlosasasRadicadasEStado2($af_id){
        return $this->glosa::join('radicacion_glosa_sumimedicals','glosas.id','radicacion_glosa_sumimedicals.glosa_id')
        ->where('glosas.af_id',$af_id)
        ->where('radicacion_glosa_sumimedicals.estado_id',2)
        ->count();
    }

    public function facturasGlosasConciliadas($data,$af_id){

        $glosasPrestador = $this->glosa->whereGlosasFacturasConciliadas($af_id);

        return  $glosasPrestador->get();
    }

    public function facturasGlosasConciliadasConSaldo($data,$af_id){

        $glosasPrestador = $this->glosa->whereGlosasFacturasConciliadasConSaldo($af_id);

        return  $glosasPrestador->get();
    }





}
