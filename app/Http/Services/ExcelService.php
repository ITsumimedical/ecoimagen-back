<?php

namespace App\Http\Services;

use Illuminate\Support\Collection;
use Rap2hpoutre\FastExcel\FastExcel;

class ExcelService {
    
    private $excel;

    public function __construct(){
        $this->excel = new FastExcel();
    }

    /**
     * obtiene un columna en especifico de un excel
     * @param File $file
     * @param array $columnas
     * @return Collection
     */
    public function getColumnas($file, $columnas): Collection{
        return $this->excel->import($file, function ($row) use($columnas){
            $array = [];
            foreach($columnas as $columna){
                $array[$columna] = $row[$columna];
            }
            return $array;
        });
    }

} 