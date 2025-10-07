<?php

namespace App\Http\Modules\Referencia\Services;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Chat\Models\canal;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;

class ReferenciaService {

    public function prepararData($data){
        $usuarioLogueado = User::find(Auth::id());
        $data['user_id'] = Auth::id();
        $data['rep_id'] = $usuarioLogueado->reps_id;
        $data['estado_id'] = 10;
        return $data;
    }

    public function GuardarCie10($referencia,$data){
        foreach($data['cie10s'] as $cie10){
            $referencia->cie10s()->attach($cie10);
        }
    }

    public function crearChat($data)
    {
       $consulta = User::where('reps_id',$data->rep_id)->first();
       $chat = canal::create([
           'user_crea_id' => Auth::id(),
            'user_recibe_id' => $consulta->id,
            'referencia_id' =>$data->id
        ]);
        return true;
    }

    public function prepararDataUrgencia($data){
        $usuarioLogueado = User::find(Auth::id());
        $rep = Rep::find($usuarioLogueado->reps_id);
        $prestador = Prestador::find($rep->prestador_id);
        $especialidad = AdmisionesUrgencia::find($data['admision']);
        // Consulta o crea el usuario en la base secundaria
        $usuario = DB::connection('secondary')->table('users')->where('email', $prestador->nit . '@fomag.com')->first();
        if (!$usuario) {
            $repFomag = DB::connection('secondary')->table('reps')->where('codigo_habilitacion', $rep->codigo_habilitacion)->first();
            $usuarioId = DB::connection('secondary')->table('users')->insertGetId([
                'password' => bcrypt($prestador->nit),
                'email' => $prestador->nit . '@fomag.com',
                'activo' => true,
                'tipo_usuario_id' => 3,
                'reps_id' => $repFomag->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Crear operador asociado
            DB::connection('secondary')->table('operadores')->insert([
                'user_id' => $usuarioId,
                'rep_id' => $repFomag->id,
                'prestador_id' => $repFomag->prestador_id,
                'tipo_doc' => 'NIT',
                'nombre' => $prestador->nit,
                'documento' => $prestador->nit,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Recupera el usuario creado
            $usuario = DB::connection('secondary')->table('users')->where('id', $usuarioId)->first();
        }

        $data['user_id'] = $usuario->id;
        $data['rep_id'] = $usuario->reps_id;
        $data['estado_id'] = 10;
        $data['especialidad_remision'] =  $especialidad->especialidad;
        return $data;
    }

    public function GuardarCie10Urgencia($referencia,$data){
        $fecha = now();
        foreach($data['cie10s'] as $cie10){
            $datoCie10 = Cie10::where('id',$cie10);
            $datos = DB::connection('secondary')->table('cie10s')
            ->where('codigo_cie10',$datoCie10->codigo_cie10)->first();
            $insertar[] = [
                'cie10_id' => $datos->id,
                'referencia_id' => $referencia,
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ];
        }
        if (!empty($insertar)) {
            DB::connection('secondary')->table('cie10_referencias')->insert($insertar);
        }

    }

    public function crearChatUrgencia($data){
        $referencia = DB::connection('secondary')->table('referencias')->where('id',$data)->first();
        $datos = DB::connection('secondary')->table('users')
        ->where('reps_id',$referencia->rep_id)->first();
        DB::connection('secondary')->table('canals')->insert([
            'user_crea_id' => $referencia->user_id,
             'user_recibe_id' => $datos->id,
             'referencia_id' =>$data,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         return true;
    }


}
