<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\Permission\Models\Permission;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Pqrsf\AsignadosPqrsf\Model\Asignado;
use App\Http\Modules\ResponsablePqrsf\Models\ResponsablePqrsf;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\AreaResponsablePqrsf\Models\AreaResponsablePqrsf;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FormulariopqrsfRepository extends RepositoryBase
{
    private $festivos = [
        "2024-01-01",
        "2024-01-08",
        "2024-03-24",
        "2024-03-25",
        "2024-03-28",
        "2024-03-29",
        "2024-03-31",
        "2024-05-01",
        "2024-05-13",
        "2024-06-03",
        "2024-06-10",
        "2024-07-01",
        "2024-07-20",
        "2024-08-07",
        "2024-08-19",
        "2024-10-14",
        "2024-11-04",
        "2024-11-11",
        "2024-12-08",
        "2024-12-25",
        "2024-01-01",
        "2024-01-06",
        "2024-01-07",
        "2024-01-13",
        "2024-01-14",
        "2025-01-20",
        "2024-01-21",
        "2024-01-27",
        "2024-01-28",
        "2024-02-03",
        "2024-02-04",
        "2024-02-10",
        "2024-02-11",
        "2024-02-17",
        "2024-02-18",
        "2024-02-24",
        "2024-02-25",
        "2024-03-02",
        "2024-03-03",
        "2024-03-09",
        "2024-03-10",
        "2024-03-16",
        "2024-03-17",
        "2024-03-23",
        "2024-03-24",
        "2024-03-30",
        "2024-03-31",
        "2024-04-06",
        "2024-04-07",
        "2024-04-13",
        "2024-04-14",
        "2024-04-20",
        "2024-04-21",
        "2024-04-27",
        "2024-04-28",
        "2024-05-04",
        "2024-05-05",
        "2024-05-11",
        "2024-05-12",
        "2024-05-18",
        "2024-05-19",
        "2024-05-25",
        "2024-05-26",
        "2024-06-01",
        "2024-06-02",
        "2024-06-08",
        "2024-06-09",
        "2024-06-15",
        "2024-06-16",
        "2024-06-22",
        "2024-06-23",
        "2024-06-29",
        "2024-06-30",
        "2024-07-06",
        "2024-07-07",
        "2024-07-13",
        "2024-07-14",
        "2024-07-20",
        "2024-07-21",
        "2024-07-27",
        "2024-07-28",
        "2024-08-03",
        "2024-08-04",
        "2024-08-10",
        "2024-08-11",
        "2024-08-17",
        "2024-08-18",
        "2024-08-24",
        "2024-08-25",
        "2024-08-31",
        "2024-09-07",
        "2024-09-08",
        "2024-09-14",
        "2024-09-15",
        "2024-09-21",
        "2024-09-22",
        "2024-09-28",
        "2024-09-29",
        "2024-10-05",
        "2024-10-06",
        "2024-10-12",
        "2024-10-13",
        "2024-10-19",
        "2024-10-20",
        "2024-10-26",
        "2024-10-27",
        "2024-11-02",
        "2024-11-03",
        "2024-11-09",
        "2024-11-10",
        "2024-11-16",
        "2024-11-17",
        "2024-11-23",
        "2024-11-24",
        "2024-11-30",
        "2024-12-01",
        "2024-12-07",
        "2024-12-08",
        "2024-12-14",
        "2024-12-15",
        "2024-12-21",
        "2024-12-22",
        "2024-12-28",
        "2024-12-29",

        //--> Festivos 2025 <--\\
        "2025-01-01",
        "2025-01-01",
        "2025-01-06",
        "2025-03-24",
        "2025-04-13",
        "2025-04-17",
        "2025-04-18",
        "2025-04-20",
        "2025-05-01",
        "2025-06-02",
        "2025-06-23",
        "2025-06-30",
        "2025-06-30",
        "2025-07-20",
        "2025-08-07",
        "2025-08-18",
        "2025-10-13",
        "2025-11-03",
        "2025-11-17",
        "2025-12-08",
        "2025-12-25",
        "2025-01-04",
        "2025-01-05",
        "2025-01-11",
        "2025-01-12",
        "2025-01-18",
        "2025-01-19",
        "2025-01-25",
        "2025-01-26",
        "2025-02-01",
        "2025-02-02",
        "2025-02-08",
        "2025-02-09",
        "2025-02-15",
        "2025-02-16",
        "2024-02-22",
        "2025-02-23",
        "2025-03-01",
        "2025-03-02",
        "2025-03-08",
        "2025-03-09",
        "2025-03-15",
        "2025-03-16",
        "2025-03-22",
        "2025-03-23",
        "2025-03-29",
        "2025-03-30",
        "2025-04-05",
        "2025-04-06",
        "2025-04-12",
        "2025-04-13",
        "2025-04-19",
        "2025-04-20",
        "2025-04-26",
        "2025-04-27",
        "2025-05-03",
        "2025-05-04",
        "2025-05-10",
        "2025-05-11",
        "2025-05-17",
        "2025-05-18",
        "2025-05-24",
        "2025-05-25",
        "2025-05-31",
        "2025-06-01",
        "2025-06-07",
        "2025-06-08",
        "2025-06-14",
        "2025-06-15",
        "2025-06-21",
        "2025-06-22",
        "2025-06-28",
        "2025-06-29",
        "2025-07-05",
        "2025-07-06",
        "2025-07-12",
        "2025-07-13",
        "2025-07-19",
        "2025-07-20",
        "2025-07-26",
        "2025-07-27",
        "2025-08-02",
        "2025-08-03",
        "2025-08-09",
        "2025-08-10",
        "2025-08-16",
        "2025-08-17",
        "2025-08-23",
        "2025-08-24",
        "2025-08-30",
        "2025-08-31",
        "2025-09-06",
        "2025-09-07",
        "2025-09-13",
        "2025-09-14",
        "2025-09-20",
        "2025-09-21",
        "2025-09-27",
        "2025-09-28",
        "2025-10-04",
        "2025-10-05",
        "2025-10-11",
        "2025-10-12",
        "2025-10-18",
        "2025-10-19",
        "2025-10-25",
        "2025-10-26",
        "2025-11-01",
        "2025-11-02",
        "2025-11-08",
        "2025-11-09",
        "2025-11-15",
        "2025-11-16",
        "2025-11-22",
        "2025-11-23",
        "2025-11-29",
        "2025-11-30",
        "2025-12-06",
        "2025-12-07",
        "2025-12-13",
        "2025-12-14",
        "2025-12-20",
        "2025-12-21",
        "2025-12-27",
        "2025-12-28",

        //--> Festivos 2026 <--\\
        "2026-01-01",
        "2026-01-12",
        "2026-03-23",
        "2026-03-29",
        "2026-04-02",
        "2026-04-03",
        "2026-04-05",
        "2026-05-01",
        "2026-05-18",
        "2026-06-08",
        "2026-06-15",
        "2026-06-29",
        "2026-07-20",
        "2026-08-07",
        "2026-08-17",
        "2026-10-12",
        "2026-11-02",
        "2026-11-16",
        "2026-12-08",
        "2026-12-25",
        "2026-01-03",
        "2026-01-04",
        "2026-01-10",
        "2026-01-11",
        "2026-01-17",
        "2026-01-18",
        "2026-01-24",
        "2026-01-25",
        "2026-01-31",
        "2026-02-01",
        "2026-02-07",
        "2026-02-08",
        "2026-02-14",
        "2026-02-15",
        "2026-02-21",
        "2026-02-22",
        "2026-02-28",
        "2026-03-01",
        "2026-03-07",
        "2026-03-08",
        "2026-03-14",
        "2026-03-15",
        "2026-03-21",
        "2025-03-22",
        "2026-03-28",
        "2026-03-29",
        "2026-04-04",
        "2026-04-05",
        "2026-04-11",
        "2026-04-12",
        "2026-04-18",
        "2026-04-19",
        "2026-04-25",
        "2026-04-26",
        "2026-05-02",
        "2026-05-03",
        "2026-05-09",
        "2026-05-10",
        "2026-05-16",
        "2026-05-17",
        "2026-05-23",
        "2026-05-24",
        "2026-05-30",
        "2026-05-31",
        "2026-06-06",
        "2026-06-07",
        "2026-06-13",
        "2026-06-14",
        "2026-06-20",
        "2026-06-21",
        "2026-06-27",
        "2026-06-28",
        "2026-07-04",
        "2026-07-05",
        "2026-07-11",
        "2026-07-12",
        "2026-07-18",
        "2026-07-19",
        "2026-07-25",
        "2026-07-26",
        "2026-08-01",
        "2026-08-02",
        "2026-08-08",
        "2026-08-09",
        "2026-08-15",
        "2026-08-16",
        "2026-08-22",
        "2026-08-23",
        "2026-08-29",
        "2026-08-30",
        "2026-09-05",
        "2026-09-06",
        "2026-09-12",
        "2026-09-13",
        "2026-09-19",
        "2026-09-20",
        "2026-09-26",
        "2026-09-27",
        "2026-10-03",
        "2026-10-04",
        "2026-10-10",
        "2026-10-11",
        "2026-10-17",
        "2026-10-18",
        "2026-10-24",
        "2026-10-25",
        "2026-10-31",
        "2026-11-01",
        "2026-11-07",
        "2026-11-08",
        "2026-11-14",
        "2026-11-15",
        "2026-11-21",
        "2026-11-22",
        "2026-11-28",
        "2026-11-29",
        "2026-12-05",
        "2026-12-06",
        "2026-12-12",
        "2026-12-13",
        "2026-12-19",
        "2026-12-20",
        "2026-12-26",
        "2026-12-27",

        //--> Festivos 2027 <--\\
        "2027-01-01",
        "2027-01-11",
        "2027-03-21",
        "2027-03-22",
        "2027-03-25",
        "2027-03-26",
        "2027-03-28",
        "2027-05-01",
        "2027-05-10",
        "2027-05-31",
        "2027-06-07",
        "2027-07-05",
        "2027-07-20",
        "2027-08-07",
        "2027-08-16",
        "2027-10-18",
        "2027-11-01",
        "2027-11-15",
        "2027-12-08",
        "2027-12-25",
        "2027-01-02",
        "2027-01-03",
        "2027-01-09",
        "2027-01-10",
        "2027-01-16",
        "2027-01-17",
        "2027-01-23",
        "2027-01-24",
        "2027-01-30",
        "2027-01-31",
        "2027-02-06",
        "2027-02-07",
        "2027-02-13",
        "2027-02-14",
        "2027-02-20",
        "2027-02-21",
        "2027-02-27",
        "2027-02-28",
        "2027-03-06",
        "2027-03-07",
        "2027-03-13",
        "2027-03-14",
        "2027-03-20",
        "2027-03-21",
        "2027-03-27",
        "2027-03-28",
        "2027-04-03",
        "2027-04-04",
        "2027-04-10",
        "2027-04-11",
        "2027-04-17",
        "2027-04-18",
        "2027-04-24",
        "2027-04-25",
        "2027-05-01",
        "2027-05-02",
        "2027-05-08",
        "2027-05-09",
        "2027-05-15",
        "2027-05-16",
        "2027-05-22",
        "2027-05-23",
        "2027-05-29",
        "2027-05-30",
        "2027-06-05",
        "2027-06-06",
        "2027-06-12",
        "2027-06-13",
        "2027-06-19",
        "2027-06-20",
        "2027-06-26",
        "2027-06-27",
        "2027-07-03",
        "2027-07-04",
        "2027-07-10",
        "2027-07-11",
        "2027-07-17",
        "2027-07-18",
        "2027-07-24",
        "2027-07-25",
        "2027-08-07",
        "2027-08-08",
        "2027-08-14",
        "2027-08-15",
        "2027-08-21",
        "2027-08-22",
        "2027-08-28",
        "2027-08-29",
        "2027-09-04",
        "2027-09-05",
        "2027-09-11",
        "2027-09-12",
        "2027-09-18",
        "2027-09-19",
        "2027-09-25",
        "2027-09-26",
        "2027-10-02",
        "2027-10-03",
        "2027-10-09",
        "2027-10-10",
        "2027-10-16",
        "2027-10-17",
        "2027-10-23",
        "2027-10-24",
        "2027-10-30",
        "2027-10-31",
        "2027-11-06",
        "2027-11-07",
        "2027-11-13",
        "2027-11-14",
        "2027-11-20",
        "2027-11-21",
        "2027-11-27",
        "2027-11-28",
        "2027-12-04",
        "2027-12-05",
        "2027-12-11",
        "2027-12-12",
        "2027-12-18",
        "2027-12-19",
        "2027-12-25",
        "2027-12-26",

        //--> Festivos 2028 <--\\
        "2028-01-01",
        "2028-01-10",
        "2028-03-20",
        "2028-04-09",
        "2028-04-13",
        "2028-04-14",
        "2028-04-16",
        "2028-05-01",
        "2028-05-29",
        "2028-06-19",
        "2028-06-26",
        "2028-07-03",
        "2028-07-20",
        "2028-08-07",
        "2028-08-21",
        "2028-10-16",
        "2028-11-06",
        "2028-11-13",
        "2028-12-08",
        "2028-12-25",
        "2028-01-01",
        "2028-01-02",
        "2028-01-08",
        "2028-01-09",
        "2028-01-15",
        "2028-01-16",
        "2028-01-22",
        "2028-01-23",
        "2028-01-29",
        "2028-01-30",
        "2028-02-05",
        "2028-02-06",
        "2028-02-12",
        "2028-02-13",
        "2028-02-19",
        "2028-02-20",
        "2028-02-26",
        "2028-02-27",
        "2028-03-04",
        "2028-03-05",
        "2028-03-11",
        "2028-03-12",
        "2028-03-18",
        "2028-03-19",
        "2028-03-25",
        "2028-03-26",
        "2028-04-01",
        "2028-04-02",
        "2028-04-08",
        "2028-04-09",
        "2028-04-15",
        "2028-04-16",
        "2028-04-22",
        "2028-04-23",
        "2028-04-29",
        "2028-04-30",
        "2028-05-06",
        "2028-05-07",
        "2028-05-13",
        "2027-08-14",
        "2028-05-20",
        "2028-05-21",
        "2028-05-27",
        "2028-05-28",
        "2028-06-03",
        "2028-06-04",
        "2028-06-10",
        "2028-06-11",
        "2028-06-17",
        "2028-06-18",
        "2028-06-24",
        "2028-06-25",
        "2028-07-01",
        "2028-07-02",
        "2028-07-08",
        "2028-07-09",
        "2028-07-15",
        "2028-07-16",
        "2028-07-22",
        "2028-07-23",
        "2028-07-29",
        "2028-07-30",
        "2028-08-05",
        "2028-08-06",
        "2028-08-12",
        "2028-08-13",
        "2028-08-19",
        "2028-08-20",
        "2028-08-26",
        "2028-08-27",
        "2028-09-02",
        "2028-09-03",
        "2028-09-09",
        "2028-09-10",
        "2028-09-16",
        "2028-09-17",
        "2028-09-23",
        "2028-09-24",
        "2028-09-30",
        "2028-10-01",
        "2028-10-07",
        "2028-10-08",
        "2028-10-14",
        "2028-10-15",
        "2028-10-21",
        "2028-10-22",
        "2028-10-28",
        "2028-10-29",
        "2028-11-04",
        "2028-11-05",
        "2028-11-11",
        "2028-11-12",
        "2028-11-18",
        "2028-11-19",
        "2028-11-25",
        "2028-11-26",
        "2028-12-02",
        "2028-12-03",
        "2028-12-09",
        "2028-12-10",
        "2028-12-16",
        "2028-12-17",
        "2028-12-23",
        "2028-12-24",
        "2028-12-30",
        "2028-12-31",

        //--> Festivos 2029 <--\\
        "2029-01-01",
        "2029-01-08",
        "2029-03-19",
        "2029-03-25",
        "2029-03-29",
        "2029-03-30",
        "2029-04-01",
        "2029-05-01",
        "2029-05-14",
        "2029-06-04",
        "2029-06-11",
        "2029-07-02",
        "2029-07-20",
        "2029-08-07",
        "2029-08-20",
        "2029-10-15",
        "2029-11-05",
        "2029-11-12",
        "2029-12-08",
        "2029-12-25",
        "2029-01-06",
        "2029-01-07",
        "2029-01-13",
        "2029-01-14",
        "2029-01-20",
        "2029-01-21",
        "2029-01-27",
        "2029-01-28",
        "2029-02-03",
        "2029-02-04",
        "2029-02-10",
        "2029-02-11",
        "2029-02-17",
        "2029-02-18",
        "2029-02-24",
        "2029-02-25",
        "2029-03-03",
        "2029-03-04",
        "2029-03-10",
        "2029-03-11",
        "2029-03-17",
        "2029-03-18",
        "2029-03-24",
        "2029-03-25",
        "2029-03-31",
        "2029-04-01",
        "2029-04-07",
        "2029-04-08",
        "2029-04-14",
        "2029-04-15",
        "2029-04-21",
        "2029-04-22",
        "2029-04-28",
        "2029-04-29",
        "2029-05-05",
        "2029-05-06",
        "2029-05-12",
        "2029-05-13",
        "2028-05-19",
        "2029-05-20",
        "2029-05-26",
        "2029-05-27",
        "2029-06-02",
        "2029-06-03",
        "2029-06-09",
        "2029-06-10",
        "2029-06-16",
        "2029-06-17",
        "2029-06-23",
        "2029-06-24",
        "2029-06-30",
        "2029-07-01",
        "2029-07-07",
        "2029-07-08",
        "2029-07-14",
        "2029-07-15",
        "2029-07-21",
        "2029-07-22",
        "2029-07-28",
        "2029-07-29",
        "2029-08-04",
        "2029-08-05",
        "2029-08-11",
        "2029-08-12",
        "2029-08-18",
        "2029-08-19",
        "2029-08-25",
        "2029-08-26",
        "2029-09-01",
        "2029-09-02",
        "2029-09-08",
        "2029-09-09",
        "2029-09-15",
        "2029-09-16",
        "2029-09-22",
        "2029-09-23",
        "2029-09-29",
        "2029-09-30",
        "2029-10-06",
        "2029-10-07",
        "2029-10-13",
        "2029-10-14",
        "2029-10-20",
        "2029-10-21",
        "2029-10-27",
        "2029-10-28",
        "2028-11-03",
        "2029-11-04",
        "2029-11-10",
        "2029-10-11",
        "2029-11-17",
        "2029-11-18",
        "2029-11-24",
        "2029-11-25",
        "2029-12-01",
        "2029-12-02",
        "2029-12-08",
        "2029-12-09",
        "2029-12-15",
        "2029-12-16",
        "2029-12-22",
        "2029-12-23",
        "2029-12-29",
        "2029-12-30",

        //--> Festivos 2030 <--\\
        "2030-01-01",
        "2030-01-07",
        "2030-03-25",
        "2030-04-14",
        "2030-04-18",
        "2030-04-19",
        "2030-04-21",
        "2030-05-01",
        "2030-06-03",
        "2030-06-24",
        "2030-07-01",
        "2030-07-01",
        "2030-07-20",
        "2030-08-07",
        "2030-08-19",
        "2030-10-14",
        "2030-11-04",
        "2030-11-11",
        "2030-12-08",
        "2030-12-25",
    ];

    protected $formularioPqrsfModel;

    public function __construct()
    {
        $this->formularioPqrsfModel = new Formulariopqrsf();
        parent::__construct($this->formularioPqrsfModel);
    }

    public function esFestivo(Carbon $date)
    {
        return in_array($date->format('Y-m-d'), $this->festivos);
    }

    public function listarPendientesDetallePqrsf($data)
    {
        $pqr = Formulariopqrsf::with(
            'afiliado',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.EstadoAfiliado',
            'afiliado.tipo_afiliacion',
            'afiliado.tipo_afiliado',
            'afiliado.departamento_atencion',
            'afiliado.municipio_atencion',
            'canal',
            'gestionPqr.user.operador',
            'gestionPqr.adjuntos',
            'solicitud:id,nombre as Solicitud_nombre',
            'subcategoriaPqrsf.derechos',
            'codesumiPqrsf',
            'servicioPqrsf',
            'areaPqrsf',
            'ipsPqrsf',
            'codigoPropioPqrsf',
            'operadorPqrsf',
            'user.operador',
            'user.afiliado'
        )
            ->where('id', $data['pqr_id'])->first();
        return $pqr;
    }

    public function listarAsignadosDetallePqrsf($data)
    {
        $pqr = Formulariopqrsf::with([
            'afiliado',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.EstadoAfiliado',
            'afiliado.tipo_afiliacion',
            'afiliado.tipo_afiliado',
            'afiliado.departamento_atencion',
            'afiliado.municipio_atencion',
            'canal',
            'gestionPqr' => function ($query) { $query->orderBy('created_at', 'asc'); },//se ordena cronologicamente historico de la pqr
            'gestionPqr.user.operador',
            'gestionPqr.adjuntos',
            'gestionPqr.areaResponsable',
            'gestionPqr.tipo',
            'solicitud:id,nombre as Solicitud_nombre',
            'subcategoriaPqrsf.derechos',
            'codesumiPqrsf',
            'servicioPqrsf',
            'areaPqrsf',
            'ipsPqrsf',
            'codigoPropioPqrsf',
            'operadorPqrsf',
        ])
            ->where('id', $data['pqr_id'])
            ->first();
        return $pqr;
    }

    public function listarPendientesInternaPqrsf($data)
    {
        $usuario = auth()->user(); // Obtiene el usuario autenticado

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.user_id', $usuario->id)
            ->where('gestion_pqrsfs.tipo_id', 3) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 10); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal' // Relación con el canal del formulario
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11]) // Excluye los formularios de los canales 22 y 11
            ->get(); // Obtiene la colección de formularios

        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
            $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos como "días calendario"
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    public function listarPendientesCentralPqrf($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.tipo_id', 3) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 10); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal' // Relación con el canal del formulario
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when($data->filtros['usuario_registra'],function($query)use($data){
                $query->where('usuario_registra_id',$data->filtros['usuario_registra']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }


    public function consultarPqr($data)
    {
        $pqr = $this->formularioPqrsfModel->select(
            'formulariopqrsfs.id',
            'formulariopqrsfs.afiliado_id as afiliado',
            'afiliados.primer_nombre',
            'afiliados.primer_apellido',
            'afiliados.numero_documento',
            'estados.nombre as estado',
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre,' ', afiliados.segundo_nombre, ' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as paciente")
            ->join('estados', 'estados.id', 'formulariopqrsfs.estado_id')
            ->leftjoin('afiliados', 'afiliados.id', 'formulariopqrsfs.afiliado_id')
            ->with('gestionPqr')
            ->where('formulariopqrsfs.id', $data['radicado'])
            ->where('formulariopqrsfs.afiliado_id', $data['afiliado_id'])
            ->with(['afiliado' => function ($afiliado) {
                $afiliado->with(['ips' => function ($rep) {
                    $rep->select('nombre', 'id');
                }]);
            }])
            ->get();

        if ($pqr) {
            return $pqr;
        } else {
            return 'fgf';
        }
    }

    public function verificarExistenciaPqrsf($idUsuario, $numeroCedula)
    {
        return Formulariopqrsf::where('afiliado_id', $idUsuario)
            ->whereHas('afiliado', function ($query) use ($numeroCedula) {
                $query->where('numero_documento', $numeroCedula);
            })
            ->count();
    }

    public function obtenerHistorialPqrsf($idUsuario, $numeroCedula)
    {
        return Formulariopqrsf::where('afiliado_id', $idUsuario)
            ->whereHas('afiliado', function ($query) use ($numeroCedula) {
                $query->where('numero_documento', $numeroCedula);
            })
            ->with('afiliado', 'estado', 'solicitud', 'canal', 'user.operador')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function obtenerAfiliadoPorCedula($numeroCedula)
    {
        return Afiliado::where('numero_documento', $numeroCedula)->first();
    }

    public function actualizarPqr($data)
    {
        $pqr = $this->formularioPqrsfModel::find($data['pqrsf_id'])->update([
            'tipo_solicitud_id' => $data['tipo_solicitud'] ? $data['tipo_solicitud'] : null,
            'priorizacion' => $data['priorizacion'] ? $data['priorizacion'] : null,
            'reabierta' => $data['reabierta'],
            'deber' => $data['deber'] ? $data['deber'] : null,
            'derecho' => $data['derecho'] ? $data['derecho'] : null,
            'atributo_calidad' => $data['atributo_calidad'] ? $data['atributo_calidad'] : null,
            'codigo_super' => $data['codigo_super'] ? $data['codigo_super'] : null,
            'correo' => $data['correo'] ? $data['correo'] : null,
        ]);

        if ($pqr == true) {
            return $this->formularioPqrsfModel::find($data['pqrsf_id']);
        } else {
            return 'no';
        }
    }

    public function estado($data, $estado)
    {
        return $this->formularioPqrsfModel::find($data['pqrsf_id'])->update(['estado_id' => $estado]);
    }

    public function listarAsignadosCentralPqrf($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::whereIn('gestion_pqrsfs.tipo_id', [6, 15])
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [6, 15]); // Filtra por estado_id en la relación formulario_pqrsf
            })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when(isset($data->filtros['area_id']) && $data->filtros['area_id'] !== null, function ($query) use ($data) {
                $query->whereHas('areaResponsable', function ($query) use ($data) {
                    $query->where('area_responsable_pqrsfs.id', $data->filtros['area_id']);
                });
            })

            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);


        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        foreach ($pqrf as $pqrsfItem) {
            foreach ($pqrsfItem->areaResponsable as $area) {
                // consulto las gestiones de esta área para el formulario que se recorre
                $gestiones = $area->gestiones()->where('formulario_pqrsf_id', $pqrsfItem->id)->get();

                // Marcamos si alguna de las gestiones tiene tipo_id igual a 8
                $area->respondio = $gestiones->contains(function ($gestion) {
                    return $gestion->tipo_id == 8;
                });
            }
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    public function listarPqrsfAsignados($data)
    {
        $usuario = auth()->user();

        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.user_id', $usuario->id)
            ->whereIn('gestion_pqrsfs.tipo_id', [6, 15])
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [6, 15]); // Filtra por estado_id en la relación formulario_pqrsf
            })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento',
            'afiliado.ips:id,nombre',
            'afiliado.entidad:id,nombre',
            'solicitud:id,nombre as Solicitud_nombre',
            'asignado:id,area_responsable_id,formulario_pqrsf_id',
            'asignado.areaResponsable:id,nombre',
            'canal'
        ])
            ->whereIn('id', $formulariosIds)
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11])
            ->get();

        // Recorre cada formulario para calcular los días hábiles
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at);
            $fechaActual = Carbon::now();

            // Calcular los días límite según la priorización
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1,
                'Riesgo priorizado (2 Días)' => 2,
                'Riesgo simple (3 Días)' => 3,
                'Peticiones generales (10 Días)' => 10,
                default => 3, // Valor por defecto si no coincide con ninguna opción
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }
            // Asignar el semáforo según los días hábiles
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde';
            $pqrsfItem->diasHabiles = $diasTranscurridos;
        }

        return $pqrf;
    }

    public function listarPresolucionCentralPqrf($data)
    {
        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::whereHas('formulario_pqrsf', function ($query) {
            $query->where('estado_id', 18); // Filtra por estado_id en la relación formulario_pqrsf
        })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when($data->filtros['usuario_registra'],function($query)use($data){
                $query->where('usuario_registra_id',$data->filtros['usuario_registra']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);


        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }


    /**
     * Lista los PQRF solucionados y anulados asociados al usuario, aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs solucionados y anulados y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarSolucionadosCentral($data)
    {
        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::where('tipo_id', 9)// Filtra por tipo_id (9 en este caso que es solucionados)
            ->whereHas('formulario_pqrsf', function ($query) {
            $query->whereIn('estado_id', [5, 17]); // Filtra por estado_id en la relación formulario_pqrsf
        })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
            'estado'
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })

            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);


        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaCierre = Carbon::parse($pqrsfItem->updated_at); // Obtiene la fecha de actualizacion la cual obedece a la ultima actualizacion cuando cambio a estado solucionado

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaCierre);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }


    public function listarPresolucion($data)
    {

        $usuario = auth()->user();

        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.user_id', $usuario->id)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 18); // Filtra por estado_id en la relación formulario_pqrsf
            })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento',
            'afiliado.ips:id,nombre',
            'afiliado.entidad:id,nombre',
            'solicitud:id,nombre as Solicitud_nombre',
            'asignado:id,area_responsable_id,formulario_pqrsf_id',
            'asignado.areaResponsable:id,nombre',
            'canal'
        ])
            ->whereIn('id', $formulariosIds)
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11])
            ->get();

        // Recorre cada formulario para calcular los días hábiles
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at);
            $fechaActual = Carbon::now();

            // Calcular los días límite según la priorización
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1,
                'Riesgo priorizado (2 Días)' => 2,
                'Riesgo simple (3 Días)' => 3,
                'Peticiones generales (10 Días)' => 10,
                default => 3, // Valor por defecto si no coincide con ninguna opción
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }
            // Asignar el semáforo según los días hábiles
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde';
            $pqrsfItem->diasHabiles = $diasTranscurridos;
        }

        return $pqrf;
    }


    public function reclasificarPqr($data)
    {
        return $this->formularioPqrsfModel::find($data['pqrsf_id'])->update([
            'correo' => $data['correo'] ? $data['correo'] : null,
            'tipo_solicitud_id' => $data['tipo_solicitud_id'] ? $data['tipo_solicitud_id'] : null,
            'atributo_calidad' => $data['atributo_calidad'] ? $data['atributo_calidad'] : null,
        ]);
    }

    public function listarSolucionados($data)
    {
        $usuario = auth()->user();
        $isAdmin = $usuario->hasPermissionTo('admin.pqrsfs');

        $pqrsfQuery = Formulariopqrsf::select([
            'formulariopqrsfs.id',
            'formulariopqrsfs.quien_genera',
            'formulariopqrsfs.documento_genera',
            'formulariopqrsfs.nombre_genera',
            'formulariopqrsfs.correo as correo',
            'formulariopqrsfs.telefono',
            'formulariopqrsfs.priorizacion',
            'formulariopqrsfs.atributo_calidad',
            'formulariopqrsfs.deber',
            'formulariopqrsfs.derecho',
            'formulariopqrsfs.reabierta',
            'formulariopqrsfs.descripcion',
            'formulariopqrsfs.canal_id',
            'canalpqrsfs.nombre as nombre_Canal',
            'formulariopqrsfs.tipo_solicitud_id',
            'tipo_solicitudpqrsfs.nombre as Solicitud_nombre',
            'formulariopqrsfs.afiliado_id',
            'formulariopqrsfs.usuario_registra_id',
            'formulariopqrsfs.estado_id',
            'estados.nombre as estadoPqrsf',
            'formulariopqrsfs.created_at',
            'formulariopqrsfs.updated_at',
        ])
            ->leftJoin('canalpqrsfs', 'formulariopqrsfs.canal_id', 'canalpqrsfs.id')
            ->join('tipo_solicitudpqrsfs', 'formulariopqrsfs.tipo_solicitud_id', 'tipo_solicitudpqrsfs.id')
            ->join('estados', 'formulariopqrsfs.estado_id', 'estados.id')
            ->join('gestion_pqrsfs', 'gestion_pqrsfs.formulario_pqrsf_id', 'formulariopqrsfs.id')
            ->with([
                'gestionPqr.adjuntos',
                'gestionPqr.user.operador',
                'afiliado' => function ($afiliado) {
                    $afiliado->with(['ips', 'departamento_atencion']);
                },
                // 'subcategoriaPqrsf' => function ($query) {
                //     $query->select('subcategoria_id as id', 'id as idSubPqr', 'formulariopqrsf_id');
                // },
                'asignado',
                'medicamentoPqrsf.medicamento.codesumi',
                'servicioPqrsf.cup',
                // 'areaPqrsf' => function ($query) {
                //     $query->select('area_id as id', 'id as idSubPqr', 'formulario_pqrsf_id');
                // },
                'ipsPqrsf',
                'empleadoPqrsf',
                'areaPqrsf.area',
                'asignado.areaResponsable',
                'subcategoriaPqrsf.subcategoria',
            ])
            ->where('gestion_pqrsfs.tipo_id', 3)
            ->whereIn('formulariopqrsfs.estado_id', [17, 5])
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11]);

        if (!$isAdmin) {
            $pqrsfQuery->where('gestion_pqrsfs.user_id', $usuario->id);
        }

        if (!empty($data['id'])) {
            $pqrsfQuery->where('formulariopqrsfs.id', $data['id']);
        }
        if (!empty($data['documento'])) {
            $pqrsfQuery->whereHas('afiliado', function ($query) use ($data) {
                $query->where('numero_documento', $data['documento']);
            });
        }
        if (!empty($data['tipo'])) {
            $pqrsfQuery->where('tipo_solicitudpqrsfs.nombre', 'ILIKE', '%' . $data['tipo'] . '%');
        }
        if (!empty($data['canal'])) {
            $pqrsfQuery->where('canalpqrsfs.nombre', 'ILIKE', '%' . $data['canal'] . '%');
        }
        if (!empty($data['departamento'])) {
            $departamentoSelect = Departamento::where('nombre', 'ILIKE', '%' . $data['departamento'] . '%')->first();
            if ($departamentoSelect) {
                $pqrsfQuery->whereHas('afiliado', function ($query) use ($departamentoSelect) {
                    $query->where('departamento_afiliacion_id', $departamentoSelect->id);
                });
            }
        }

        $info = isset($data->page) ? $pqrsfQuery->paginate($data->cant) : $pqrsfQuery->get();

        foreach ($info as $pqrsf) {
            $fechaCreacion = Carbon::parse($pqrsf->created_at);
            $fechaActual = Carbon::now();

            switch ($pqrsf->priorizacion) {
                case 'Riesgo Vital (1 Día)':
                    $diasLimite = 2;
                    break;
                case 'Riesgo priorizado (2 Días)':
                    $diasLimite = 3;
                    break;
                case 'Riesgo simple (3 Días)':
                    $diasLimite = 4;
                    break;
                case 'Peticiones generales (10 Días)':
                    $diasLimite = 11;
                    break;
                default:
                    $diasLimite = 3;
                    break;
            }

            $diasHabilesTranscurridos = $fechaCreacion->diffInDaysFiltered(function (Carbon $date) {
                return !$date->isWeekend() && !$this->esFestivo($date);
            }, $fechaActual);

            if ($diasHabilesTranscurridos >= $diasLimite) {
                $pqrsf->semaforo = 'rojo';
            } else {
                $pqrsf->semaforo = 'verde';
            }

            $pqrsf->diasHabiles = $diasHabilesTranscurridos;
        }

        return $info;
    }

    public function listarPendientesExterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::whereHas('formulario_pqrsf', function ($query) {
            $query->where('estado_id', 10); // Filtra por estado_id en la relación formulario_pqrsf
        })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento',
            'afiliado.ips:id,nombre',
            'afiliado.entidad:id,nombre',
            'solicitud:id,nombre as Solicitud_nombre',
            'asignado:id,area_responsable_id,formulario_pqrsf_id',
            'asignado.areaResponsable:id,nombre',
            'canal'
        ])
            ->whereIn('id', $formulariosIds)
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->get();

        // Recorre cada formulario para calcular los días hábiles
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at);
            $fechaActual = Carbon::now();

            // Calcular los días límite según la priorización
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1,
                'Riesgo priorizado (2 Días)' => 2,
                'Riesgo simple (3 Días)' => 3,
                'Peticiones generales (10 Días)' => 10,
                default => 3, // Valor por defecto si no coincide con ninguna opción
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }
            // Asignar el semáforo según los días hábiles
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde';
            $pqrsfItem->diasHabiles = $diasTranscurridos;
        }

        return $pqrf;
    }

    public function listarAsignadosExterna($data)
    {
        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::whereHas('formulario_pqrsf', function ($query) {
            $query->whereIn('estado_id', [6, 20, 15])
                ->where('tipo_id', 6);
        })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento',
            'afiliado.ips:id,nombre',
            'afiliado.entidad:id,nombre',
            'solicitud:id,nombre as Solicitud_nombre',
            'asignado:id,area_responsable_id,formulario_pqrsf_id',
            'asignado.areaResponsable:id,nombre',
            'canal'
        ])
            ->whereIn('id', $formulariosIds)
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->get();

        // Recorre cada formulario para calcular los días hábiles
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at);
            $fechaActual = Carbon::now();

            // Calcular los días límite según la priorización
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1,
                'Riesgo priorizado (2 Días)' => 2,
                'Riesgo simple (3 Días)' => 3,
                'Peticiones generales (10 Días)' => 10,
                default => 3, // Valor por defecto si no coincide con ninguna opción
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }
            // Asignar el semáforo según los días hábiles
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde';
            $pqrsfItem->diasHabiles = $diasTranscurridos;
        }
        return $pqrf;
    }


    public function listarPresolucionExterna($data)
    {
        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::whereHas('formulario_pqrsf', function ($query) {
            $query->whereIn('estado_id', [18]);
        })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento',
            'afiliado.ips:id,nombre',
            'afiliado.entidad:id,nombre',
            'solicitud:id,nombre as Solicitud_nombre',
            'asignado:id,area_responsable_id,formulario_pqrsf_id',
            'asignado.areaResponsable:id,nombre',
            'canal'
        ])
            ->whereIn('id', $formulariosIds)
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->get();

        // Recorre cada formulario para calcular los días hábiles
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at);
            $fechaActual = Carbon::now();

            // Calcular los días límite según la priorización
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1,
                'Riesgo priorizado (2 Días)' => 2,
                'Riesgo simple (3 Días)' => 3,
                'Peticiones generales (10 Días)' => 10,
                default => 3, // Valor por defecto si no coincide con ninguna opción
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }
            // Asignar el semáforo según los días hábiles
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde';
            $pqrsfItem->diasHabiles = $diasTranscurridos;
        }
        return $pqrf;
    }

    public function listarSolucionadosExterna($data)
    {
        $pqrsf = Formulariopqrsf::select([
            'formulariopqrsfs.id',
            'formulariopqrsfs.quien_genera',
            'formulariopqrsfs.documento_genera',
            'formulariopqrsfs.nombre_genera',
            'formulariopqrsfs.correo as correo',
            'formulariopqrsfs.telefono',
            'formulariopqrsfs.priorizacion',
            'formulariopqrsfs.atributo_calidad',
            'formulariopqrsfs.deber',
            'formulariopqrsfs.derecho',
            'formulariopqrsfs.reabierta',
            'formulariopqrsfs.descripcion',
            'formulariopqrsfs.canal_id',
            'canalpqrsfs.nombre as nombre_Canal',
            'formulariopqrsfs.tipo_solicitud_id',
            'tipo_solicitudpqrsfs.nombre as Solicitud_nombre',
            'formulariopqrsfs.afiliado_id',
            'formulariopqrsfs.usuario_registra_id',
            'formulariopqrsfs.estado_id',
            'estados.nombre as estadoPqrsf',
            'formulariopqrsfs.created_at',
            'formulariopqrsfs.updated_at',

        ])
            ->leftjoin('canalpqrsfs', 'formulariopqrsfs.canal_id', 'canalpqrsfs.id')
            ->join('tipo_solicitudpqrsfs', 'formulariopqrsfs.tipo_solicitud_id', 'tipo_solicitudpqrsfs.id')
            ->join('estados', 'formulariopqrsfs.estado_id', 'estados.id')
            ->join('gestion_pqrsfs', 'gestion_pqrsfs.formulario_pqrsf_id', 'formulariopqrsfs.id')
            ->with(['afiliado' => function ($afiliado) {
                $afiliado->with(['ips:id,nombre', 'entidad:id,nombre']);
            }, 'gestionPqr', 'subcategoriaPqrsf', 'asignado', 'medicamentoPqrsf.medicamento.codesumi:id,nombre', 'servicioPqrsf', 'areaPqrsf.area:id,nombre', 'ipsPqrsf', 'empleadoPqrsf', 'asignado.areaResponsable', 'gestionPqr.adjuntos', 'gestionPqr.user.operador', 'subcategoriaPqrsf.subcategoria',])
            ->where('gestion_pqrsfs.tipo_id', 3)
            ->whereIn('formulariopqrsfs.estado_id', [17, 5])
            ->whereIn('formulariopqrsfs.canal_id', [11, 22]);
        if ($data['id']) {
            $pqrsf->where('formulariopqrsfs.id', $data['id']);
        }
        if ($data['documento']) {
            $pqrsf->whereHas('afiliado', function ($query) use ($data) {
                $query->where('numero_documento', $data['documento']);
            });
        }
        if ($data['tipo']) {
            $pqrsf->where('tipo_solicitudpqrsfs.nombre', 'ILIKE', '%' . $data['tipo'] . '%')->first();
        }
        if ($data['canal']) {
            $pqrsf->where('canalpqrsfs.id', $data['canal'])->first();
        }
        if ($data['departamento']) {
            $departamentoSelect = Departamento::where('nombre', 'ILIKE', '%' . $data['departamento'] . '%')->first();
            $pqrsf->whereHas('afiliado', function ($query) use ($departamentoSelect) {
                $query->where('departamento_afiliacion_id', $departamentoSelect->id);
            });
        }
        $info = $data->page ? $pqrsf->paginate($data->cant) : $pqrsf->get();
        return $info;
    }

    public function listarAsignadosTodos($data)
    {
        $usuario = auth()->user();

        $permisosUsuario = ResponsablePqrsf::whereHas('user', function ($query) use ($usuario) {
            $query->where('id', $usuario->id);
        })->pluck('id');

        $area_id = AreaResponsablePqrsf::whereHas('responsable', function ($query) use ($permisosUsuario) {
            $query->whereIn('responsable_pqrsfs.id', $permisosUsuario);
        })->pluck('id');

        // Obtiene los IDs únicos de los formularios asociados al usuario
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.tipo_id', 6)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [15, 6]); // Filtra por estado_id en la relación formulario_pqrsf
            })
            ->whereHas('formulario_pqrsf.asignado', function ($query) use ($area_id) {
                $query->whereIn('area_responsable_id', $area_id)
                    ->where('estado_id', 1);
            })
            ->distinct('formulario_pqrsf_id')
            ->pluck('formulario_pqrsf_id');

        // Carga los datos relacionados de los formularios
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id',
            'afiliado.tipoDocumento',
            'afiliado.ips:id,nombre',
            'afiliado.entidad:id,nombre',
            'solicitud:id,nombre as Solicitud_nombre',
            'asignado:id,area_responsable_id,formulario_pqrsf_id',
            'asignado.areaResponsable:id,nombre',
            'canal'
        ])
            ->whereIn('id', $formulariosIds)
            ->get();

        // Recorre cada formulario para calcular los días hábiles
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at);
            $fechaActual = Carbon::now();

            // Calcular los días límite según la priorización
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1,
                'Riesgo priorizado (2 Días)' => 2,
                'Riesgo simple (3 Días)' => 3,
                'Peticiones generales (10 Días)' => 10,
                default => 3, // Valor por defecto si no coincide con ninguna opción
            };

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($fechaCreacion->eq($fechaActual)) {
                $diasTranscurridos = 0; // Si es el mismo día, no ha transcurrido ningún día
            } else {
                // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
                $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual) + 1; // Devuelve la diferencia en días entre la creación y la fecha actual
            }
            // Asignar el semáforo según los días hábiles
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde';
            $pqrsfItem->diasHabiles = $diasTranscurridos;
        }

        return $pqrf;
    }


    public function listarSolucionadosTodos($data)
    {

        $permisosUsuario = ResponsablePqrsf::whereHas('user', function ($query) {
            $query->where('id', Auth::id());
        })->pluck('id');

        if (count($permisosUsuario) > 0) {
            $prueba = AreaResponsablePqrsf::whereHas('responsable', function ($query) use ($permisosUsuario) {
                $query->whereIn('responsable_pqrsfs.id', $permisosUsuario);
            })->pluck('id');

            $pqrsf = Formulariopqrsf::select([
                'formulariopqrsfs.id',
                'formulariopqrsfs.quien_genera',
                'formulariopqrsfs.documento_genera',
                'formulariopqrsfs.nombre_genera',
                'formulariopqrsfs.correo as correo',
                'formulariopqrsfs.telefono',
                'formulariopqrsfs.priorizacion',
                'formulariopqrsfs.atributo_calidad',
                'formulariopqrsfs.deber',
                'formulariopqrsfs.derecho',
                'formulariopqrsfs.reabierta',
                'formulariopqrsfs.descripcion',
                'formulariopqrsfs.canal_id',
                'canalpqrsfs.nombre as nombre_Canal',
                'formulariopqrsfs.tipo_solicitud_id',
                'tipo_solicitudpqrsfs.nombre as Solicitud_nombre',
                'formulariopqrsfs.afiliado_id',
                'formulariopqrsfs.usuario_registra_id',
                'formulariopqrsfs.estado_id',
                'estados.nombre as estadoPqrsf',
                'formulariopqrsfs.created_at',
                'formulariopqrsfs.updated_at',

            ])
                ->leftjoin('canalpqrsfs', 'formulariopqrsfs.canal_id', 'canalpqrsfs.id')
                ->join('tipo_solicitudpqrsfs', 'formulariopqrsfs.tipo_solicitud_id', 'tipo_solicitudpqrsfs.id')
                ->join('estados', 'formulariopqrsfs.estado_id', 'estados.id')
                ->join('gestion_pqrsfs', 'gestion_pqrsfs.formulario_pqrsf_id', 'formulariopqrsfs.id')
                ->with([
                    'afiliado' => function ($afiliado) {
                        $afiliado->with(['ips']);
                    },
                    'gestionPqr',
                    'subcategoriaPqrsf',
                    'asignado',
                    'medicamentoPqrsf',
                    'servicioPqrsf',
                    'areaPqrsf.area',
                    'ipsPqrsf',
                    'empleadoPqrsf',
                    'asignado.areaResponsable',
                    'gestionPqr.adjuntos',
                    'gestionPqr.user.operador',
                    'subcategoriaPqrsf.subcategoria',
                ])
                ->whereHas('asignado', function ($query) use ($prueba) {
                    $query->whereIn('area_responsable_id', $prueba);
                })
                ->where('gestion_pqrsfs.tipo_id', 3)
                ->where('formulariopqrsfs.estado_id', 17);
            if ($data['id']) {
                $pqrsf->where('formulariopqrsfs.id', $data['id']);
            }
            if ($data['documento']) {
                $pqrsf->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data['documento']);
                });
            }
            if ($data['tipo']) {
                $pqrsf->where('tipo_solicitudpqrsfs.nombre', 'ILIKE', '%' . $data['tipo'] . '%')->first();
            }
            if ($data['canal']) {
                $pqrsf->where('canalpqrsfs.nombre', 'ILIKE', '%' . $data['canal'] . '%')->first();
            }
            $info = $data->page ? $pqrsf->paginate($data->cant) : $pqrsf->get();
            return $info;
        } else {
            return [];
        }
    }

    public function reporte($data)
    {
        $result = [];
        switch ($data['resolucion']) {
            case 1:
                $appointments = Collect(DB::select("exec dbo.PendientesPqrsf"));
                $result = json_decode($appointments, true);
                break;
            case 2:
                $appointments = Collect(DB::select("exec dbo.InformePQRSF ?,?", [$data['fechaDesde'], $data['fechaHasta']]));
                $result = json_decode($appointments, true);
                break;
            case 3:
                $appointments = Collect(DB::select("exec dbo.oportunidadPqrsf ?,?", [$data['fechaDesde'], $data['fechaHasta']]));
                $result = json_decode($appointments, true);
                break;
                // case 4:
                //     if ($request->entidad == 1) {
                //         $appointments = Detallearticulospqrsf::select('detallearticulos.Producto as Medicamento', DB::raw('Count(pqrsfs.id) as Cantidad'))
                //             ->join('detallearticulos', 'detallearticulos.id', 'detallearticulospqrsf.Detallearticulo_id')
                //             ->join('pqrsfs', 'pqrsfs.id', 'detallearticulospqrsf.Pqrsf_id')
                //             ->whereBetween('pqrsfs.created_at', array($request->fechaDesde . ' 00:00:00.000', $request->fechaHasta . ' 23:59:00.000'))
                //             ->groupby('detallearticulos.Producto', 'pqrsfs.id')
                //             ->orderby('pqrsfs.id', 'desc')->get();
                //         $result = json_decode($appointments, true);
                //     }
                //     if ($request->entidad == 2) {
                //         $appointments = Cupspqrsf::select('cups.Nombre as Procedimiento', DB::raw('Count(pqrsfs.id) as Cantidad'))
                //             ->join('cups', 'cups.id', 'cupspqrsf.Cup_id')
                //             ->join('pqrsfs', 'pqrsfs.id', 'cupspqrsf.Pqrsf_id')
                //             ->whereBetween('pqrsfs.created_at', array($request->fechaDesde . ' 00:00:00.000', $request->fechaHasta . ' 23:59:00.000'))
                //             ->groupby('cups.Nombre', 'pqrsfs.id')
                //             ->orderby('pqrsfs.id', 'desc')->get();
                //         $result = json_decode($appointments, true);
                //     }
                //     if ($request->entidad == 3) {
                //         $appointments = Areapqrsf::select('areas.Nombre as Area', DB::raw('Count(pqrsfs.id) as Cantidad'))
                //             ->join('areas', 'areas.id', 'areaspqrsf.area_id')
                //             ->join('pqrsfs', 'pqrsfs.id', 'areaspqrsf.Pqrsf_id')
                //             ->whereBetween('pqrsfs.created_at', array($request->fechaDesde . ' 00:00:00.000', $request->fechaHasta . ' 23:59:00.000'))
                //             ->groupby('areas.Nombre', 'pqrsfs.id')
                //             ->orderby('pqrsfs.id', 'desc')->get();
                //         $result = json_decode($appointments, true);
                //     }
                //     if ($request->entidad == 4) {
                //         $appointments = Empleadopqrsf::select('empleados.Nombre as Empleado', DB::raw('Count(pqrsfs.id) as Cantidad'))
                //             ->join('empleados', 'empleados.id', 'empleadospqrsf.Empleado_id')
                //             ->join('pqrsfs', 'pqrsfs.id', 'empleadospqrsf.Pqrsf_id')
                //             ->whereBetween('pqrsfs.created_at', array($request->fechaDesde . ' 00:00:00.000', $request->fechaHasta . ' 23:59:00.000'))
                //             ->groupby('empleados.Nombre', 'pqrsfs.id')
                //             ->orderby('pqrsfs.id', 'desc')->get();
                //         $result = json_decode($appointments, true);
                //     }
                //     break;
            case 5:
                $appointments = Formulariopqrsf::select(
                    'formulariopqrsfs.id as Readicado',
                    DB::raw("CONCAT(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as 'Nombre de Usuario'"),
                    'afiliados.numero_documento as Documento',
                    'canalpqrsfs.nombre as Canal',
                    'tipo_solicitudpqrsfs.nombre as TipoSolicitud',
                    'formulariopqrsfs.descripcion',
                    'formulariopqrsfs.created_at as "Fecha de creacion"',
                    'estados.nombre as Estado'
                )
                    ->join('canalpqrsfs', 'formulariopqrsfs.canal_id', 'canalpqrsfs.id')
                    ->join('tipo_solicitudpqrsfs', 'formulariopqrsfs.tipo_solicitud_id', 'tipo_solicitudpqrsfs.id')
                    ->join('afiliados', 'afiliados.id', 'formulariopqrsfs.afiliado_id')
                    ->join('estados', 'formulariopqrsfs.estado_id', 'estados.id')
                    ->where('afiliados.numero_documento', $data['cedulaPacientes'])
                    ->whereBetween('formulariopqrsfs.created_at', array($data['fechaDesde'] . ' 00:00:00.000', $data['fechaHasta'] . ' 23:59:00.000'))
                    ->orderby('formulariopqrsfs.id', 'desc')->get();

                $result = json_decode($appointments, true);
                break;
            case 6:
                $usuario = auth()->user()->id;
                $appointments = Formulariopqrsf::select(
                    'formulariopqrsfs.id as Readicado',
                    DB::raw("CONCAT(afiliados.primer_nombre,' ',afiliados.segundo_nombre,' ',afiliados.primer_apellido,' ',afiliados.segundo_apellido) as 'Nombre de Usuario'"),
                    'afiliados.numero_documento as Documento',
                    'canalpqrsfs.nombre as Canal',
                    'tipo_solicitudpqrsfs.nombre as TipoSolicitud',
                    'formulariopqrsfs.descripcion',
                    'formulariopqrsfs.created_at as "Fecha de creacion"',
                    DB::raw("CONCAT(operadores.nombre,' ',operadores.apellido) as 'Nombre de Responsable'"),
                    'estados.nombre as Estado'
                )
                    ->join('canalpqrsfs', 'formulariopqrsfs.canal_id', 'canalpqrsfs.id')
                    ->join('tipo_solicitudpqrsfs', 'formulariopqrsfs.tipo_solicitud_id', 'tipo_solicitudpqrsfs.id')
                    ->join('afiliados', 'afiliados.id', 'formulariopqrsfs.afiliado_id')
                    ->join('estados', 'formulariopqrsfs.estado_id', 'estados.id')
                    ->join('gestion_pqrsfs', 'gestion_pqrsfs.formulario_pqrsf_id', 'formulariopqrsfs.id')
                    ->join('users', 'users.id', 'gestion_pqrsfs.user_id')
                    ->leftjoin('operadores', 'operadores.user_id', 'users.id')
                    ->where('gestion_pqrsfs.user_id', $usuario)
                    ->whereIn('gestion_pqrsfs.tipo_id', [3, 5])
                    ->whereBetween('formulariopqrsfs.created_at', array($data['fechaDesde'] . ' 00:00:00.000', $data['fechaHasta'] . ' 23:59:00.000'))
                    ->orderby('formulariopqrsfs.id', 'desc')->get();

                $result = json_decode($appointments, true);
                break;
            case 7:
                $appointments = Collect(DB::select("exec SP_Reporte_SuperSalud ?,?", [$data['fechaDesde'], $data['fechaHasta']]));
                $result = json_decode($appointments, true);
                break;
        }
        return (new FastExcel($result))->download('file.xls');
    }

    public function contadoresPqrsfInterna()
    {
        $usuario = auth()->user();
        $userId = $usuario->id;

        // Contar pendientes
        $pendientes = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->where('gestion_pqrsfs.user_id', $usuario->id)  // Cambiar a $usuario->id
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11])
            ->where('formulariopqrsfs.estado_id', 10)  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();

        // Contar asignados
        $asignadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->where('gestion_pqrsfs.user_id', $usuario->id)  // Cambiar a $usuario->id
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11])
            ->whereIn('gestion_pqrsfs.tipo_id', [6, 15])
            ->whereIn('formulariopqrsfs.estado_id', [6, 15])  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        // Contar pre-solucionadas
        $pre_solucionadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->where('gestion_pqrsfs.user_id', $usuario->id)  // Cambiar a $usuario->id
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11])
            ->where('formulariopqrsfs.estado_id', 18)  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        // Contar solucionadas
        $solucionadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->where('gestion_pqrsfs.user_id', $usuario->id)  // Cambiar a $usuario->id
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11])
            ->whereIn('formulariopqrsfs.estado_id', [17, 5])  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        return (object)[
            'totalPendientes' => $pendientes,
            'totalAsignados' => $asignadas,
            'totalPresolucionadas' => $pre_solucionadas,
            'cerrados' => $solucionadas,
        ];
    }

    public function contadoresPqrsfAdmin()
    {

        // Contar pendientes
        $pendientes = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->where('formulariopqrsfs.estado_id', 10)  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();

        // Contar asignados
        $asignadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->whereIn('gestion_pqrsfs.tipo_id', [6, 15])
            ->whereIn('formulariopqrsfs.estado_id', [6, 15])  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        // Contar pre-solucionadas
        $pre_solucionadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->where('formulariopqrsfs.estado_id', 18)  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        // Contar solucionadas
        $solucionadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->whereIn('formulariopqrsfs.estado_id', [17, 5])  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        return (object)[
            'totalPendientes' => $pendientes,
            'totalAsignados' => $asignadas,
            'totalPresolucionadas' => $pre_solucionadas,
            'cerrados' => $solucionadas,
        ];
    }



    public function contadoresPqrsfExterna($data)
    {
        // Contar pendientes
        $pendientes = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->where('formulariopqrsfs.estado_id', 10)  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();

        // Contar asignados
        $asignadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->whereIn('gestion_pqrsfs.tipo_id', [6, 15])
            ->whereIn('formulariopqrsfs.estado_id', [6, 15])  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        // Contar pre-solucionadas
        $pre_solucionadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->where('formulariopqrsfs.estado_id', 18)  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        // Contar solucionadas
        $solucionadas = GestionPqrsf::join('formulariopqrsfs', 'formulariopqrsfs.id', 'gestion_pqrsfs.formulario_pqrsf_id')
            ->whereIn('formulariopqrsfs.canal_id', [22, 11])
            ->whereIn('formulariopqrsfs.estado_id', [17, 5])  // Asegurarse de que esto sea un array
            ->distinct('gestion_pqrsfs.formulario_pqrsf_id')
            ->count();


        return (object)[
            'totalPendientes' => $pendientes,
            'totalAsignados' => $asignadas,
            'totalPresolucionadas' => $pre_solucionadas,
            'cerrados' => $solucionadas,
        ];
    }


    public function contadoresPqrsfTodos($data)
    {

        // Obtiene los IDs de los permisos de responsables PQRSF para el usuario autenticado
        $permisosUsuario = ResponsablePqrsf::whereHas('user', function ($query) {
            $query->where('id', Auth::id());
        })->pluck('id');


        $area_id = AreaResponsablePqrsf::whereHas('responsable', function ($query) use ($permisosUsuario) {
            $query->whereIn('responsable_pqrsfs.id', $permisosUsuario);
        })->pluck('id');

        $asignadas = Asignado::join('formulariopqrsfs', 'formulariopqrsfs.id', 'asignados.formulario_pqrsf_id')
            ->whereIn('asignados.area_responsable_id', $area_id)
            ->whereIn('formulariopqrsfs.estado_id', [6, 15])  // Asegurarse de que esto sea un array
            ->where('asignados.estado_id', 1)
            ->distinct('formulariopqrsfs.id')
            ->count();

        $solucionadas = Asignado::join('formulariopqrsfs', 'formulariopqrsfs.id', 'asignados.formulario_pqrsf_id')
            ->whereIn('asignados.area_responsable_id', $area_id)
            ->whereIn('formulariopqrsfs.estado_id', [17, 5])  // Asegurarse de que esto sea un array
            ->where('asignados.estado_id', 2)
            ->distinct('formulariopqrsfs.id')
            ->count();

        return (object)[
            'totalAsignados' => $asignadas,
            'cerrados' => $solucionadas,
        ];
    }

    /**
     * Lista las PQRF pendientes solo de los canales WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs pendientes y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarPendientesGestionExterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.tipo_id', 3) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 10); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal' // Relación con el canal del formulario
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when($data->filtros['usuario_registra'],function($query)use($data){
                $query->where('usuario_registra_id',$data->filtros['usuario_registra']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF asignadas solo de los canales WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs asignadas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarAsignadasGestionExterna($data)
    {
        // $areaResponsableIds = ResponsablePqrsf::where('user_id', auth()->user()->id)
        // ->with('areasResponsables')
        // ->get()
        // ->pluck('areasResponsables')
        // ->flatten()
        // ->pluck('id')
        // ->unique();

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.tipo_id', 3) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [6, 15]); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
                        ->whereHas('asignado', function ($query) use ($formulariosIds) {
                $query->where('estado_id', 1)
                      ->whereIn('formulario_pqrsf_id', $formulariosIds);
                    //   ->whereIn('area_responsable_id', $areaResponsableIds);
            })
            // Filtros adicionales
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when(isset($data->filtros['area_id']) && $data->filtros['area_id'] !== null, function ($query) use ($data) {
                $query->whereHas('areaResponsable', function ($query) use ($data) {
                    $query->where('area_responsable_pqrsfs.id', $data->filtros['area_id']);
                });
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF pre-solucionadas solo de los canales WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs pre-solucionadas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarPreSolucionadasGestionExterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::whereIn('gestion_pqrsfs.tipo_id', [8,22,51]) //Filtra por tipo_id (8 en este caso, que corresponde a las que tengan ya gestion con respuesta final,22 para devolucion y 51 para los correos enviados que hayan fallado)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 18); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when($data->filtros['usuario_registra'],function($query)use($data){
                $query->where('usuario_registra_id',$data->filtros['usuario_registra']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF solucionadas y anuladas solo de los canales WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs solucionadas y anuladas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarSolucionadasGestionExterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('gestion_pqrsfs.tipo_id', 9) // Filtra por tipo_id (9 en este caso, que es tipo solucion PQRSF que es como queda luego de solucionar)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [5, 17]); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
            'estado'
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })

            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaCierre = Carbon::parse($pqrsfItem->updated_at); // Obtiene la fecha de actualizacion de la PQR que obedece al update_at al momento de cambiar a estado cerrado o anulado

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaCierre);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF pendientes de todos los canales EXCEPTO WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs pendientes y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarPendientesGestionInterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('user_id', auth()->user()->id) // Filtra por el user_id del gestor
            ->where('tipo_id', 3) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 10); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal' // Relación con el canal del formulario
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when($data->filtros['usuario_registra'],function($query)use($data){
                $query->where('usuario_registra_id',$data->filtros['usuario_registra']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF asignadas de todos los canales EXCEPTO WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs asignadas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarAsignadasGestionInterna($data)
    {

        // $areaResponsableIds = ResponsablePqrsf::where('user_id', auth()->user()->id)
        // ->with('areasResponsables')
        // ->get()
        // ->pluck('areasResponsables')
        // ->flatten()
        // ->pluck('id')
        // ->unique();

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('user_id', auth()->user()->id) // Filtra por el user_id del gestor
            ->where('tipo_id', 3) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [6, 15]); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            ->whereHas('asignado', function ($query) use ($formulariosIds) {
                $query->where('estado_id', 1)
                      ->whereIn('formulario_pqrsf_id', $formulariosIds);
                    //   ->whereIn('area_responsable_id', $areaResponsableIds);
            })
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when(isset($data->filtros['area_id']) && $data->filtros['area_id'] !== null, function ($query) use ($data) {
                $query->whereHas('areaResponsable', function ($query) use ($data) {
                    $query->where('area_responsable_pqrsfs.id', $data->filtros['area_id']);
                });
            })

            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF pre-solucionadas de todos los canales EXCEPTO WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs pre-solucionadas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarPreSolucionadasGestionInterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('user_id', auth()->user()->id) // Filtra por el user_id del gestor
            ->whereIn('tipo_id', [3,8,22,51]) // Filtra por tipo_id (3 para creo, 8 en este caso, que corresponde a las que tienen respuesta final,22 para devoluciones y 51 para los correos enviados que hayan fallado)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->where('estado_id', 18); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->when($data->filtros['usuario_registra'],function($query)use($data){
                $query->where('usuario_registra_id',$data->filtros['usuario_registra']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF solucionadas y anuladas de todos los canales EXCEPTO WEB y SuperSalud aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs solucionadas y anuladas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarSolucionadasGestionInterna($data)
    {

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::where('user_id', auth()->user()->id) // Filtra por el user_id del gestor
            ->where('tipo_id', 9) // Filtra por tipo_id (9 en este caso que es solucionados)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [5, 17]); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // dd($data->filtros['numero_radicado']);

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
            'estado'
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            ->whereNotIn('formulariopqrsfs.canal_id', [22, 11]) // Filtra por los canales Web y SuperSalud
            // Filtros
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })

            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaCierre = Carbon::parse($pqrsfItem->updated_at); // Obtiene la fecha de actualizacion que obedece a la solucion de la pqr

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaCierre);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }

    /**
     * Lista las PQRF asignadas a las áreas del usuario loggueado aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs asignadas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarAsignadasGestionArea($data)
    {
        $user = auth()->user();
        $userId = $user->id;

        // Cargar los responsables y sus áreas responsables
        $responsables = $user->responsablePqrsfs()->with('areasResponsables')->get();

        // Extraer todos los IDs de las áreas responsables
        $userAreaIds = $responsables->flatMap(function ($responsable) {
            return $responsable->areasResponsables->pluck('id');
        })->unique()->toArray();

        // Depuración para verificar los IDs
        // dd($userAreaIds);

        // Verificar que el usuario tenga áreas responsables asociadas
        if (empty($userAreaIds)) {
            // Retornar una paginación vacía si no hay áreas responsables
            return FormularioPqrsf::whereRaw('0 = 1')->paginate(
                $data->paginacion['cantidadRegistros'],
                ['*'],
                'page',
                $data->paginacion['pagina']
            );
        }

        // // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = Asignado::where('estado_id', 1)->whereIn('area_responsable_id',$userAreaIds) // Filtra por tipo_id (3 en este caso)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [6, 15]); // Filtra por estado_id en la relación 'formulario_pqrsf'
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
            'gestionPqr' // Cargar la relación 'gestionPqr' para aplicar el filtro
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
   
            // Filtros existentes
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })
            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);

        // Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            $fechaActual = Carbon::now(); // Obtiene la fecha actual

            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }



    /**
     * Lista las PQRF solucionadas y anuladas a las áreas del usuario loggueado aplicando filtros y paginación. También calcula los días calendario transcurridos
     * desde la creación del PQRF y determina el semáforo correspondiente (verde o rojo) según la priorización.
     * @param object $data Contiene los filtros y los parámetros de paginación.
     * @return LengthAwarePaginator Paginador con la lista de PQRFs solucionadas y anuladas y sus datos relacionados.
     * Cada PQRF incluye cálculos de días transcurridos desde la creación y su respectivo semáforo.
     * @author Thomas
     */
    public function listarSolucionadasGestionArea($data)
    {

        $userId = auth()->user()->id;

        // Obtiene los IDs únicos de los formularios asociados al usuario según el tipo y estado
        $formulariosIds = GestionPqrsf::whereIn('gestion_pqrsfs.tipo_id', [8,9,22]) // Filtra por tipo_id (8,9,22 para respuesta final, solucionados y devoluciones)
            ->whereHas('formulario_pqrsf', function ($query) {
                $query->whereIn('estado_id', [5,17,18]); // Filtra por estado_id en la relación 'formulario_pqrsf' anulado, cerrado, parcial(respuesta final)
            })
            ->distinct('formulario_pqrsf_id') // Asegura que los formularios sean únicos
            ->pluck('formulario_pqrsf_id'); // Extrae solo los IDs de los formularios

        // Carga los datos relacionados de los formularios filtrados por los IDs obtenidos anteriormente
        $pqrf = FormularioPqrsf::with([
            'afiliado:id,numero_documento,tipo_documento,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,entidad_id,ips_id,departamento_atencion_id',
            'afiliado.tipoDocumento', // Relación con el tipo de documento del afiliado
            'afiliado.ips:id,nombre', // Relación con la IPS del afiliado
            'afiliado.entidad:id,nombre', // Relación con la entidad del afiliado
            'afiliado.departamento_atencion',
            'solicitud:id,nombre as Solicitud_nombre', // Relación con la solicitud y su nombre
            'canal', // Relación con el canal del formulario
            'areaResponsable.responsable.user.operador',
            'estado'
        ])
            ->whereIn('id', $formulariosIds) // Aplica el filtro de IDs obtenidos
            // Filtros
            ->whereHas('asignado.areaResponsable.responsable', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->when($data->filtros['numero_radicado'], function ($query) use ($data) {
                $query->where('id', $data->filtros['numero_radicado']);
            })
            ->when($data->filtros['numero_documento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('numero_documento', $data->filtros['numero_documento']);
                });
            })
            ->when($data->filtros['departamento'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('departamento_atencion_id', $data->filtros['departamento']);
                });
            })
            ->when($data->filtros['canal_id'], function ($query) use ($data) {
                $query->where('canal_id', $data->filtros['canal_id']);
            })
            ->when($data->filtros['entidad_id'], function ($query) use ($data) {
                $query->whereHas('afiliado', function ($query) use ($data) {
                    $query->where('entidad_id', $data->filtros['entidad_id']);
                });
            })
            ->when($data->filtros['fecha_inicio'] && $data->filtros['fecha_fin'], function ($query) use ($data) {
                $query->whereBetween('created_at', [$data->filtros['fecha_inicio'], $data->filtros['fecha_fin']]);
            })
            ->when($data->filtros['codigo_super'], function ($query) use ($data) {
                $query->where('codigo_super', $data->filtros['codigo_super']);
            })

            ->paginate($data->paginacion['cantidadRegistros'], ['*'], 'page', $data->paginacion['pagina']);



        //Recorre cada formulario para calcular los días calendario transcurridos
        foreach ($pqrf as $pqrsfItem) {
            $fechaCreacion = Carbon::parse($pqrsfItem->created_at); // Obtiene la fecha de creación del formulario
            //se verifica si la pqr asociada ya fue cerrada para verificar con qué fecha hacer el semaforo de cada pqr asociada. Si fue cerrada se toma la fecha de la ultima actualizacion que fue cuando se cerró, sino toma la fecha del dia.
            $fechaActual = $pqrsfItem->estado_id === 17 ? Carbon::parse($pqrsfItem->updated_at) : Carbon::now(); 
           
            // Calcular los días límite según la priorización del formulario
            $diasLimite = match ($pqrsfItem->priorizacion) {
                'Riesgo Vital (1 Día)' => 1, // 1 día límite para "Riesgo Vital"
                'Riesgo priorizado (2 Días)' => 2, // 2 días límite para "Riesgo priorizado"
                'Riesgo simple (3 Días)' => 3, // 3 días límite para "Riesgo simple"
                'Peticiones generales (10 Días)' => 10, // 10 días límite para "Peticiones generales"
                default => 3, // Por defecto, se asigna 3 días límite si la priorización no coincide con las anteriores
            };

            // Calcular días calendario transcurridos (sin excluir fines de semana ni festivos)
            $diasTranscurridos = $fechaCreacion->diffInDays($fechaActual);

            // Si la fecha de creación y la fecha actual son iguales, los días transcurridos son 0
            if ($diasTranscurridos === 0) {
                $pqrsfItem->diasHabiles = 0; // Asignar 0 si es el mismo día
            } else {
                $pqrsfItem->diasHabiles = $diasTranscurridos; // Asignar los días transcurridos
            }

            // Asignar el semáforo según si los días transcurridos superan o no el límite
            $pqrsfItem->semaforo = $diasTranscurridos >= $diasLimite ? 'rojo' : 'verde'; // Rojo si los días transcurridos exceden el límite, verde si no
        }

        return $pqrf; // Retorna la colección de formularios con los cálculos aplicados
    }


    /**
     * Obtiene el registro de una PQR segun su ID.
     * @param mixed $pqr_Id
     * @return Formulariopqrsf|Formulariopqrsf[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @author AlejoSR
     */
    public function obtenerPqr($pqr_Id)
    {
        return $this->formularioPqrsfModel->findOrFail($pqr_Id);
    }
}
