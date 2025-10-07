<?php

namespace Database\Seeders;

use App\Http\Modules\Departamentos\Models\Departamento;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $departamentos = [
                [
                    'nombre'      => 'ANTIOQUIA',
                    'codigo_dane' => '05',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'ATLANTICO',
                    'codigo_dane' => '08',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'BOGOTA',
                    'codigo_dane' => '11',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'BOLIVAR',
                    'codigo_dane' => '13',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'BOYACA',
                    'codigo_dane' => '15',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CALDAS',
                    'codigo_dane' => '17',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CAQUETA',
                    'codigo_dane' => '18',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CAUCA',
                    'codigo_dane' => '19',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CESAR',
                    'codigo_dane' => '20',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CORDOBA',
                    'codigo_dane' => '23',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CUNDINAMARCA',
                    'codigo_dane' => '25',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CHOCO',
                    'codigo_dane' => '27',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'HUILA',
                    'codigo_dane' => '41',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'LA GUAJIRA',
                    'codigo_dane' => '44',
                    'pais_id' => 42],
                [
                    'nombre'      => 'MAGDALENA',
                    'codigo_dane' => '47',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'META',
                    'codigo_dane' => '50',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'NARIÑO',
                    'codigo_dane' => '52',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'N. DE SANTANDER',
                    'codigo_dane' => '54',
                    'pais_id' => 42],
                [
                    'nombre'      => 'QUINDIO',
                    'codigo_dane' => '63',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'RISARALDA',
                    'codigo_dane' => '66',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'SANTANDER',
                    'codigo_dane' => '68',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'SUCRE',
                    'codigo_dane' => '70',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'TOLIMA',
                    'codigo_dane' => '73',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'VALLE DEL CAUCA',
                    'codigo_dane' => '76',
                    'pais_id' => 42],
                [
                    'nombre'      => 'ARAUCA',
                    'codigo_dane' => '81',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'CASANARE',
                    'codigo_dane' => '85',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'PUTUMAYO',
                    'codigo_dane' => '86',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'SAN ANDRES',
                    'codigo_dane' => '88',
                    'pais_id' => 42],
                [
                    'nombre'      => 'AMAZONAS',
                    'codigo_dane' => '91',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'GUAINIA',
                    'codigo_dane' => '94',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'GUAVIARE',
                    'codigo_dane' => '95',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'VAUPES',
                    'codigo_dane' => '97',
                    'pais_id'     => 42],
                [
                    'nombre'      => 'VICHADA',
                    'codigo_dane' => '99',
                    'pais_id'     => 42],
            ];
            foreach ($departamentos as $departamento) {
                Departamento::updateOrCreate([
                    'nombre' => $departamento['nombre'],
                ],[
                    'nombre' => $departamento['nombre'],
                    'codigo_dane' => $departamento['codigo_dane'],
                    'pais_id' => $departamento['pais_id'],
                ]);
            }

            }catch (\Throwable $th) {
                return response()->json([
                    'mensaje' => 'error al crear el seeder de departamento'
                ], Response::HTTP_BAD_REQUEST);
            }
    }
}
