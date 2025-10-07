<?php

namespace App\Http\Modules\ConfiguracionReportes\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ConfiguracionReportes\Models\ConfiguracionReporte;
use App\Http\Modules\Reportes\Models\CabeceraReporte;
use App\Http\Modules\Reportes\Models\EndpointRuta;

class ConfiguracionReporteRepository extends RepositoryBase {

    public function __construct(ConfiguracionReporte $model, protected CabeceraReporte $cabeceraReporteModel)
    {
        parent::__construct($model);
    }

    public function obtenerTodos($columns = ['*'])
    {
        return $this->model->select($columns)->get();
    }

        /**
         * Listar datos quemados de instituciones
         ** Manuela
         * @return JsonResponse
         */
        public function obtenerReps(): \Illuminate\Http\JsonResponse
    {
        $reps = [
            [
                "id" => "CLINICA VICTORIANA",
                "nombre" => "CLINICA VICTORIANA",
            ],
            [
                "id" => "FERROCARRILES BELLO",
                "nombre" => "FERROCARRILES BELLO",
            ],
            [
                "id" => "FERROCARRILES MEDELLIN",
                "nombre" => "FERROCARRILES MEDELLIN",
            ],
            [
                "id" => "SEDE SUMIMEDICAL ITAGUI",
                "nombre" => "SEDE SUMIMEDICAL ITAGUI",
            ],
            [
                "id" => "SUMIMEDICAL COPACABANA",
                "nombre" => "SUMIMEDICAL COPACABANA",
            ],
            [
                "id" => "SUMIMEDICAL ISTMINA",
                "nombre" => "SUMIMEDICAL ISTMINA",
            ],
            [
                "id" => "SUMIMEDICAL QUIBDO",
                "nombre" => "SUMIMEDICAL QUIBDO",
            ],
            [
                "id" => "SUMIMEDICAL RIONEGRO",
                "nombre" => "SUMIMEDICAL RIONEGRO",
            ],
            [
                "id" => "SUMIMEDICAL SAS BELLO",
                "nombre" => "SUMIMEDICAL SAS BELLO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE APARTADO",
                "nombre" => "SUMIMEDICAL SEDE APARTADO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE APOYO TERAPEUTICO",
                "nombre" => "SUMIMEDICAL SEDE APOYO TERAPEUTICO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE BUCARAMANGA",
                "nombre" => "SUMIMEDICAL SEDE BUCARAMANGA",
            ],
            [
                "id" => "SUMIMEDICAL SEDE CALDAS",
                "nombre" => "SUMIMEDICAL SEDE CALDAS",
            ],
            [
                "id" => "SUMIMEDICAL SEDE CAUCASIA",
                "nombre" => "SUMIMEDICAL SEDE CAUCASIA",
            ],
            [
                "id" => "TORRE INTERMEDICA",
                "nombre" => "TORRE INTERMEDICA",
            ],
            [
                "id" => "SUMIMEDICAL SEDE PUERTO BERRIO",
                "nombre" => "SUMIMEDICAL SEDE PUERTO BERRIO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE ENVIGADO",
                "nombre" => "SUMIMEDICAL SEDE ENVIGADO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE CHIGORODO",
                "nombre" => "SUMIMEDICAL SEDE CHIGORODO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE ESTADIO",
                "nombre" => "SUMIMEDICAL SEDE ESTADIO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE NECOCLI",
                "nombre" => "SUMIMEDICAL SEDE NECOCLI",
            ],
            [
                "id" => "SUMIMEDICAL SEDE ORIENTAL",
                "nombre" => "SUMIMEDICAL SEDE ORIENTAL",
            ],
            [
                "id" => "SUMIMEDICAL SEDE TURBO",
                "nombre" => "SUMIMEDICAL SEDE TURBO",
            ],
            [
                "id" => "SUMIMEDICAL SEDE VILLANUEVA",
                "nombre" => "SUMIMEDICAL SEDE VILLANUEVA",
            ]
        ];

        return response()->json($reps);
    }

    /**
     * Obtener entidades quemadas
     ** Manuela
     * @return array
     */
    public function obtenerEntidades(): array
    {
        return [
            [
                'id' => 1,
                'nombre' => 'FOMAG',
            ],
            [
                'id' => 3,
                'nombre' => 'Fondo de pasivo social de ferrocarriles nacionales de Colombia',
            ],
        ];
    }

    /**
     * Solo permite consultar los end point que esten en estado true
     *
     * @author Calvarez
     */
    public function rutas() {
        return EndpointRuta::where('estado', true)
            ->whereJsonContains('methods', 'GET')
            ->get();
    }

    /**
     * Obtener las cabeceras de los reportes con los detalles
     *
     * @author Calvarez
     */
    public function obtenerReportes() {
        return $this->cabeceraReporteModel->with('detalles:id,nombre_parametro,orden_parametro,tipo_dato,origen,cabecera_reporte_id,nombre_columna_bd,valor_columna_guardar')->get();
    }

}
