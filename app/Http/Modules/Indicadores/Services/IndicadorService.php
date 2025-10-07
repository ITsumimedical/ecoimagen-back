<?php

namespace App\Http\Modules\Indicadores\Services;

use App\Formats\IndicadorOncologicoFomag;
use App\Http\Modules\Imagenes\Models\Imagene;


class IndicadorService
{
    public function generarPlantilla($tipo,$request){
        $ruta = null;
        switch (intval($tipo)) {
            case 1:
                $plantilla = new IndicadorOncologicoFomag($request['desde'],$request['hasta']);
                $ruta = $plantilla->formato();
                break;
        }
        return $ruta;
    }

    public function generarPlantilla2($tipo,$request){}

    public function calcularRangosFechasIndicadorOncologicoFomag($desde,$hasta){
        $mesesTrimestrales = [
            '01',
            '04',
            '07',
            '10'
        ];
        $mesesSemestrales= [
            '04',
            '10'
        ];
        $f1 = new \DateTime($desde);
        $f2 = new \DateTime($hasta);

        $cant_meses = $f2->diff($f1);
        $cant_meses = $cant_meses->format('%m'); //devuelve el numero de meses entre ambas fechas.
        $listaMeses = [$f1->format('Y-m-d')];
        $filtroMesesMensuales[$f1->format('m')] = ['desde'=> $f1->format('Y-m-01'),'hasta'=> $desde];
        for ($i = 1; $i < $cant_meses; $i++) {
            $ultimaFecha = end($listaMeses);
            $ultimaFecha = new \DateTime($ultimaFecha);
            $nuevaFecha = $ultimaFecha->add(new \DateInterval("P1M"));
            $filtroMesesMensuales[$nuevaFecha->format('m')] = ['desde'=> $nuevaFecha->format('Y-m-01'),'hasta'=> $nuevaFecha->format('Y-m-t')];

            $nuevaFecha = $nuevaFecha->format('Y-m-d');
            array_push($listaMeses, $nuevaFecha);
        }
        $filtroMesesMensuales[$f2->format('m')] = ['desde'=> $f2->format('Y-m-01'),'hasta'=> $hasta];
        array_push($listaMeses,$hasta);
        $filtroMesesTrimestrales = [];
        foreach ($listaMeses as $mes) {
            $fechaFormateada = explode('-',$mes);
            $fechaDesde = $fechaFormateada[0].'-'.$fechaFormateada[1].'-01';
            $bandera = true;
            while ($bandera) {
                $fechaDesdeFormateada = new \DateTime($fechaDesde);
                $fechaRestada = $fechaDesdeFormateada->sub(new \DateInterval('P1M'));
                $fechaRestadaFormateada = $fechaRestada->format('Y-m-01');
                $fechaRestadaSeparada = explode('-',$fechaRestadaFormateada);
                if(array_search($fechaRestadaSeparada['1'],$mesesTrimestrales) !== false){
                    $bandera = false;
                }else{
                    $fechaDesde = $fechaRestadaFormateada;
                }
            }
            $filtroMesesTrimestrales[$fechaFormateada[1]] = ['desde' => $fechaDesde, 'hasta' => $mes];
        }
        $filtroMesesSemestrales= [];
        foreach ($listaMeses as $mes) {
            $fechaFormateada = explode('-',$mes);
            $fechaDesde = $fechaFormateada[0].'-'.$fechaFormateada[1].'-01';
            $bandera = true;
            while ($bandera) {
                $fechaDesdeFormateada = new \DateTime($fechaDesde);
                $fechaRestada = $fechaDesdeFormateada->sub(new \DateInterval('P1M'));
                $fechaRestadaFormateada = $fechaRestada->format('Y-m-01');
                $fechaRestadaSeparada = explode('-',$fechaRestadaFormateada);
                if(array_search($fechaRestadaSeparada['1'],$mesesSemestrales) !== false){
                    $bandera = false;
                }else{
                    $fechaDesde = $fechaRestadaFormateada;
                }
            }
            $filtroMesesSemestrales[$fechaFormateada[1]] = ['desde' => $fechaDesde, 'hasta' => $mes];
        }
        return ['mensuales' => $filtroMesesMensuales,'trimestrales'=> $filtroMesesTrimestrales,'semestrales'=> $filtroMesesSemestrales];
    }
}
