<?php

namespace App\Http\Modules\Historia\Paraclinicos\Services;

use App\Http\Modules\Historia\Paraclinicos\Models\Paraclinico;
use App\Http\Modules\Historia\RegistroLaboratorios\Models\registroLaboratorios;

class ParaclinicoService {

    public function guardarParaclinico($request){
        $request['usuario_id'] = auth()->user()->id;
        Paraclinico::create([
            'resultadoCreatinina' => $request['resultadoCreatinina'],
            'ultimaCreatinina' => $request['ultimaCreatinina'],
            'resultaGlicosidada' => $request['resultaGlicosidada'],
            'fechaGlicosidada' => $request['fechaGlicosidada'],
            'resultadoAlbuminuria' => $request['resultadoAlbuminuria'],
            'fechaAlbuminuria' => $request['fechaAlbuminuria'],
            'fechaColesterol' => $request['fechaColesterol'],
            'resultadoHdl' => $request['resultadoHdl'],
            'fechaHdl' => $request['fechaHdl'],
            'resultadoLdl' => $request['resultadoLdl'],
            'fechaLdl' => $request['fechaLdl'],
            'resultadoTrigliceridos' => $request['resultadoTrigliceridos'],
            'fechaTrigliceridos' => $request['fechaTrigliceridos'],
            'resultadoGlicemia' => $request['resultadoGlicemia'],
            'fechaGlicemia' => $request['fechaGlicemia'],
            'resultadoPht' => $request['resultadoPht'],
            'fechaPht' => $request['fechaPht'],
            'resultadoHemoglobina' => $request['resultadoHemoglobina'],
            'albumina' => $request['albumina'],
            'fechaAlbumina' => $request['fechaAlbumina'],
            'fosforo' => $request['fosforo'],
            'fechaFosforo' => $request['fechaFosforo'],
            'resultadoEkg' => $request['resultadoEkg'],
            'fechaEkg' => $request['fechaEkg'],
            'glomerular' => $request['glomerular'],
            'fechaGlomerular' => $request['fechaGlomerular'],
            'usuario_id' => $request['usuario_id'],
            'afiliado_id' => $request['afiliado_id'],
            'consulta_id' => $request['consulta_id'],
            'nombreParaclinico' => $request['nombreParaclinico'],
            'resultadoParaclinico' => $request['resultadoParaclinico'],
            'checkboxParaclinicos' => $request['checkboxParaclinicos'],
            'fechaParaclinico' => $request['fechaParaclinico'],
        ]);
        if (isset($request['idRegistoColesterol'])) {
        registroLaboratorios::where('id', $request['idRegistoColesterol'])
            ->update([
                'resultado' => $request['resultadoColesterol'],
                'fecha_validacion' => $request['fechaColesterol']
            ]);
        }
        if (isset($request['idHdl'])) {
        RegistroLaboratorios::where('id', $request['idHdl'])
            ->update([
                'resultado' => $request['resultadoHdl'],
                'fecha_validacion' => $request['fechaHdl']
            ]);
        }
        if (isset($request['idTrigliceridos'])) {
        RegistroLaboratorios::where('id', $request['idTrigliceridos'])
            ->update([
                'resultado' => $request['resultadoTrigliceridos'],
                'fecha_validacion' => $request['fechaTrigliceridos']
            ]);
        }
        if (isset($request['idCreatina'])) {
        RegistroLaboratorios::where('id', $request['idCreatina'])
            ->update([
                'resultado' => $request['resultadoCreatinina'],
                'fecha_validacion' => $request['ultimaCreatinina']
            ]);
        }
        if (isset($request['idAlbuminuria'])) {
        RegistroLaboratorios::where('id', $request['idAlbuminuria'])
            ->update([
                'resultado' => $request['resultadoAlbuminuria'],
                'fecha_validacion' => $request['fechaAlbuminuria']
            ]);
        }
        if (isset($request['idHemoglobina'])) {
        RegistroLaboratorios::where('id', $request['idHemoglobina'])
            ->update([
                'resultado' => $request['resultaGlicosidada'],
                'fecha_validacion' => $request['fechaGlicosidada']
            ]);
        }
        if (isset($request['idGlicemia'])) {
        RegistroLaboratorios::where('id', $request['idGlicemia'])
            ->update([
                'resultado' => $request['resultadoGlicemia'],
                'fecha_validacion' => $request['fechaGlicemia']
            ]);
        }
        if (isset($request['idPht'])) {
        RegistroLaboratorios::where('id', $request['idPht'])
            ->update([
                'resultado' => $request['resultadoPht'],
                'fecha_validacion' => $request['fechaPht']
            ]);
        }
        if (isset($request['idAlbumina'])) {
        RegistroLaboratorios::where('id', $request['idAlbumina'])
            ->update([
                'resultado' => $request['albumina'],
                'fecha_validacion' => $request['fechaAlbumina']
            ]);
        }
        if (isset($request['idFosforo'])) {
        RegistroLaboratorios::where('id', $request['idFosforo'])
            ->update([
                'resultado' => $request['fosforo'],
                'fecha_validacion' => $request['fechaFosforo']
            ]);
        }
        return response()->json([
            'message' => 'Paraclinicos guardado con exito!'
        ], 200);
    }



}
